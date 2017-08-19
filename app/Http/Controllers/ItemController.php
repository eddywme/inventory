<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory;
use App\ItemCondition;
use App\User;
use App\Utility\Utils;
use Illuminate\Http\Request;
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
        $items = Item::paginate(6);
        $item_categories = ItemCategory::all();

        return view("items.items-list", [
            "items" => $items,
            "item_categories" => $item_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            $pathToImage = Storage::putFileAs(
                'public/items-images',
                $uploadedFileImage,
                $uploadedFileImage->getClientOriginalName()."_".str_random(10).".".$uploadedFileImage->getClientOriginalExtension()
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
        $item->slug = str_slug($request->input("name")." ".$request->input("identifier"));

        $item->save();

        return redirect(route('items.index'))->with('status', 'You have successfully registered a new Item');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $item = Item::all()->where('slug', $slug)->first();

        if(!$item) {
            return redirect('/');
        }
        $itemQ = Item::all()->where('category_id', $item->category_id)->count();
        return view("items.items-show", [
            'item' => $item,
            'itemQ' => $itemQ
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
