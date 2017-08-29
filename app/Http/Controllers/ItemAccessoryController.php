<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
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
    public function create($itemSlug)
    {
        $item = $this->findItemBySlug($itemSlug);

        return view('items-accessories.item-accessory-form', [
            'item' => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $itemSlug)
    {
        $item = $this->findItemBySlug($itemSlug);
        if(!$item){
            return redirect('/');
        }

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required',
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
        $itemAccessory->slug = str_slug( $request->input('name')." ".$item->serial_number);
        $itemAccessory->item_id = $item->id;


        $itemAccessory->save();

        return redirect('items/item-accessories')->with('status', 'A new Item Accessory has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $itemAccessory = ItemAccessory::all()->where('slug', $slug)->first();

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

    /**
     * @param $slug
     * @return Item
     */
    protected function findItemBySlug($slug)
    {
        return Item::all()->where('slug', $slug)->first();
    }
}
