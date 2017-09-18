<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\ItemCategory;
use App\ItemCondition;
use App\User;
use App\Utility\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = Item::where('time_span', '>', 0)
            ->orderByDesc('status')
            ->paginate(6);

        $item_categories = ItemCategory::all();

        return view("items.items-list", [
            "items" => $items,
            "item_categories" => $item_categories
        ]);
    }

    public function adminIndex()
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $items = Item::where('time_span', '>', 0)
            ->orderByDesc('status')
            ->get();

        return view("items.items-index", [
            "items" => $items
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $categories = ItemCategory::all();
        $conditions = ItemCondition::all();
        $users = User::all(); // Item owners
        return view('items.items-form',[
            'categories' => $categories,
            'conditions' => $conditions,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $this->validate($request, [
            'name' => 'required|string|unique:items|max:255',
            'serial_number' => 'required|string|unique:items|max:255',
            'identifier' => 'required|string|unique:items|max:255',
            'condition_id' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'owned_by' =>  'required|numeric',
            'model_number' =>  'required|string|max:255',
            'description' => 'required|string',
            'date_acquired' => 'required|date',

            'num_hours' => 'required|numeric',
            'num_days' => 'required|numeric',
            'num_months' => 'required|numeric',
            'num_years' => 'required|numeric',
        ]);

//        dd($request);

        #times span related scripts

        $num_hours =  $request->input('num_hours');
        $num_days =  $request->input('num_days');
        $num_months =  $request->input('num_months');
        $num_years =  $request->input('num_years');

        $total_hours_time_span = $num_hours + ( $num_days * 24) + ($num_months * 30 * 24) + ($num_years * 360 * 24);



        $pathToImage = null;

        if(($request->file('photo_url')) !== null){
            $uploadedFileImage = $request->file('photo_url');
            $clientOriginalName = $uploadedFileImage->getClientOriginalName();
            $pathToImage = Storage::putFileAs(
                'public/items-images',
                $uploadedFileImage,
                str_replace(".", "", $clientOriginalName)."_".str_random(10).".".$uploadedFileImage->getClientOriginalExtension()
            );

        }


        $item = new Item();
        $item->name = $request->input("name");
        $item->serial_number = $request->input("serial_number");
        $item->identifier = $request->input("identifier");
        $item->condition_id = $request->input("condition_id");
        $item->price = $request->input("price");
        $item->category_id = $request->input("category_id");
        $item->photo_url = $pathToImage;
        $item->location = $request->input("location");
        $item->owned_by = $request->input("owned_by");
        $item->model_number = $request->input("model_number");
        $item->description = $request->input("description");
        $item->date_acquired = $request->input("date_acquired");
        $item->recorded_by = Utils::authUserId();
        $item->time_span = $total_hours_time_span;
        $item->lastly_edited_by = Utils::authUserId();
        $item->slug = str_slug($request->input("name")." ".$request->input("serial_number")."-".strtoupper(str_random(8)));

        $item->save();

        return redirect(route('items-admin'))->with('status', 'You have successfully registered a new Item');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $item = $this->findItemBySlug($slug);

        if(!$item) {
            return redirect('/');
        }
        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id);

        $itemQ = Item::all()->where('category_id', $item->category_id)->count();
        return view("items.items-show", [
            'item' => $item,
            'itemQ' => $itemQ,
            'itemAccessories' => $itemAccessories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $item = $this->findItemBySlug($slug);

        $conditions = ItemCondition::all();
        $users = User::all(); // Item owners

        $array_time_span = Utils::secondsToTime($item->time_span * 60 * 60);

        $categories = ItemCategory::all();
        return view('items.items-form', [
            'item' => $item,
            'categories' => $categories,
            'conditions' => $conditions,
            'users' => $users,
            'array_time_span' => $array_time_span
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $item = $this->findItemBySlug($slug);

        if($item == null){
            redirect('/');
        }

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:items,name,'.$item->id,
            'serial_number' => 'required|string|max:255|unique:items,serial_number,'.$item->id,
            'identifier' => 'required|string|max:255|unique:items,identifier,'.$item->id,
            'condition_id' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'owned_by' =>  'required|numeric',
            'model_number' =>  'required|string|max:255',
            'description' => 'required|string',
            'date_acquired' => 'required|date',

            'num_hours' => 'required|numeric',
            'num_days' => 'required|numeric',
            'num_months' => 'required|numeric',
            'num_years' => 'required|numeric',
        ]);

//        dd($request);

        #times span related scripts

        $num_hours =  $request->input('num_hours');
        $num_days =  $request->input('num_days');
        $num_months =  $request->input('num_months');
        $num_years =  $request->input('num_years');

        $total_hours_time_span = $num_hours + ( $num_days * 24) + ($num_months * 30 * 24) + ($num_years * 360 * 24);

        $pathToImage = null;

        if(($request->file('photo_url')) !== null){
            $uploadedFileImage = $request->file('photo_url');
            $clientOriginalName = $uploadedFileImage->getClientOriginalName();
            $pathToImage = Storage::putFileAs(
                'public/items-images',
                $uploadedFileImage,
                str_replace(".", "", $clientOriginalName)."_".str_random(10).".".$uploadedFileImage->getClientOriginalExtension()
            );

        }


        $item->name = $request->input("name");
        $item->serial_number = $request->input("serial_number");
        $item->identifier = $request->input("identifier");
        $item->condition_id = $request->input("condition_id");
        $item->price = $request->input("price");
        $item->category_id = $request->input("category_id");

        /* If the item has already a image :  update its image if and only if a new image has been uploaded */
        if ($item->photo_url) {

                if($pathToImage !== null){
                    /* Remove the replaced image*/
                    Storage::delete($item->photo_url);
                    $item->photo_url = $pathToImage;
                }

        } else {
            $item->photo_url = $pathToImage;
        }

        $item->location = $request->input("location");
        $item->owned_by = $request->input("owned_by");
        $item->model_number = $request->input("model_number");
        $item->description = $request->input("description");
        $item->date_acquired = $request->input("date_acquired");
        $item->recorded_by = Utils::authUserId();
        $item->time_span = $total_hours_time_span;
        $item->lastly_edited_by = Utils::authUserId();
//        $item->slug = str_slug($request->input("name")." ".$request->input("serial_number"));

        $item->save();

        return redirect(route('items-admin'))->with('status', 'You have successfully updated the Item');






    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }
        $item = $this->findItemBySlug($slug);


        if(!$item){
            return redirect('/');
        }

        if(!$item->is_available()){
            return redirect('/');
        }


//        $accessories = ItemAccessory::all()->where('item_id', $item->id)->all();
        $accessories = ItemAccessory::with('item')->get();

        foreach ($accessories as $accessory) {
            $accessory->delete();
            Storage::delete($accessory->photo_url);
        }

        Storage::delete($item->photo_url);

        $item->delete();

        return redirect(route('items-admin'))->with('success-status', 'You have successfully deleted the Item');

    }


    public function search(Request $request){
        $this->validate($request, [
            's' => 'required|string',
        ]);



        $category_name = $request->input('category_id');

        $category_id = $request->input('ctg');



        $search_key = $request->get('s');

        $item_categories = ItemCategory::all();
        $items = Item::where('time_span', '>', 0)
            ->where('name','like', '%'. $search_key .'%')
            ->paginate(6);

        $itemCategory = null;

        if($category_id !== null){

            $itemCategory = ItemCategory::all()->where('id', $category_id )->first();
            $items = Item::where('time_span', '>', 0)
                ->where('name','like', '%'. $search_key .'%')
                ->where('category_id','=', $category_id )
                ->paginate(6);
        }



        return view('items.items-search-result', [
            'items'=>$items,
            'search_key'=>$search_key,
            "item_categories" => $item_categories,
            "itemCategory" => $itemCategory
        ]);
    }

    /**
     * @param $slug
     * @return Item
     */
    protected function findItemBySlug($slug)
    {
        return Item::all()->where('slug', $slug)->first();
    }

}
