<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\Utility\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemAccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Utils::isAdmin()) {
            return redirect('/');
        }

        $itemAccessories = ItemAccessory::all();

        return view('items-accessories.item-accessory-index', [
            'itemAccessories' => $itemAccessories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return view('items-accessories.item-accessory-form', [
            'items' => $items
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
            'name' => 'required|string',
            'description' => 'required',
            'item' => 'nullable|numeric',
            'photo_url' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $pathToImage = null;

        if(($request->file('photo_url')) !== null){
            $uploadedFileImage = $request->file('photo_url');
            $clientOriginalName = $uploadedFileImage->getClientOriginalName();
            $pathToImage = Storage::putFileAs(
                'public/items-accessories-images',
                $uploadedFileImage,
                str_replace([".", " "], "", $clientOriginalName)."_".str_random(10).".".$uploadedFileImage->getClientOriginalExtension()
            );

        }

        $itemAccessory = new ItemAccessory();
        $itemAccessory->name = $request->input('name');
        $itemAccessory->description = $request->input('description');
        $itemAccessory->photo_url = $pathToImage;
        $itemAccessory->slug = str_slug( $request->input('name')."-".Carbon::now()->timestamp);
        $itemAccessory->item_id = $request->input('item');;


        $itemAccessory->save();

        return redirect()->back()->with('status', 'A new Item Accessory has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $itemAccessory = $this->findItemAccessoryBySlug($slug);

        return view('items-accessories.items-accessories-show', [
            'itemAccessory' => $itemAccessory
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
        $itemAccessory = $this->findItemAccessoryBySlug($slug);

        if(!$itemAccessory){
            return redirect('/');
        }
        $itemRelated = $itemAccessory->item;


        $items = Item::all();

        return view('items-accessories.item-accessory-form', [
            'itemAccessory' => $itemAccessory,
            'itemRelated' => $itemRelated,
            'items' => $items
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

        $itemAccessory = $this->findItemAccessoryBySlug($slug);

        if($itemAccessory == null){
            return redirect('/');
        }



        $this->validate($request, [
        'name' => 'required|string',
        'description' => 'required',
        'item' => 'nullable|numeric',
        'photo_url' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pathToImage = null;

        if(($request->file('photo_url')) !== null){
            $uploadedFileImage = $request->file('photo_url');
            $clientOriginalName = $uploadedFileImage->getClientOriginalName();
            $pathToImage = Storage::putFileAs(
                'public/items-accessories-images',
                $uploadedFileImage,
                str_replace([".", " "], "", $clientOriginalName)."_".str_random(10).".".$uploadedFileImage->getClientOriginalExtension()
            );

        }

        /* If the item accessory has already a image :  update its image if and only if a new image has been uploaded */
        if ($itemAccessory->photo_url) {

            if($pathToImage !== null) {
                /* Remove the replaced image*/
                Storage::delete($itemAccessory->photo_url);

                $itemAccessory->photo_url = $pathToImage;
            }

        } else {
            $itemAccessory->photo_url = $pathToImage;
        }

        $itemAccessory->name = $request->input('name');
        $itemAccessory->description = $request->input('description');
        $itemAccessory->item_id = $request->input('item');
        $itemAccessory->save();

        return redirect(route('item-accessories'))->with('status', 'The  Accessory has been updated successfully !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $itemAccessory = $this->findItemAccessoryBySlug($slug);



        if(!$itemAccessory->is_available()){
            return redirect()->back();
        }

        Storage::delete($itemAccessory->photo_url);

        $itemAccessory->delete();

        return redirect(route('item-accessories'))->with('success-status', 'You have successfully deleted the Accessory');
    }

    /**
     * @param $slug
     * @return Item
     */
    protected function findItemBySlug($slug)
    {
        return Item::all()->where('slug', $slug)->first();
    }

    /**
     * @param $slug
     * @return mixed
     */
    protected function findItemAccessoryBySlug($slug)
    {
        return ItemAccessory::all()->where('slug', $slug)->first();
    }
}

