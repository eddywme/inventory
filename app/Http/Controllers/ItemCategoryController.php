<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemCategories = ItemCategory::all();

        return view('items-categories.items-categories-index',[
            'itemCategories' => $itemCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items-categories.items-categories-form');
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
            'name' => 'required|unique:item_categories',
            'description' => 'required',
        ]);

        $itemCategory = new ItemCategory();
        $itemCategory->name = $request->input('name');
        $itemCategory->description = $request->input('description');
        $itemCategory->slug = str_slug( $request->input('name'));
        $itemCategory->save();

        return redirect('item-categories')->with('status', 'A new Item Category has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $itemCategory = $this->findItmCategoryBySlug($slug);

        return view('items-categories.items-categories-form', [
            'itemCategory' => $itemCategory
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
        $itemCategory = $this->findItmCategoryBySlug($slug);

        if($itemCategory === null){
            return redirect('/');
        }
        $this->validate($request, [
            'name' => 'required|unique:item_categories,name,'.$itemCategory->id,
            'description' => 'required'

        ]);

        $itemCategory->name = $request->input('name');
        $itemCategory->description = $request->input('description');
//        $itemCategory->slug = str_slug( $request->input('name'));
        $itemCategory->save();
        return redirect('item-categories')->with('status', 'The Item Category has been updated .');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $itemCategory = $this->findItmCategoryBySlug($slug);

        $itemsRelated = Item::all()->where('category_id', $itemCategory->id);

        dd('Items related that are about to be deleted ',$itemsRelated);

        foreach ($itemsRelated as $item){
            $item->delete();
        }

        $itemCategory->delete();

        return redirect('items-categories.items-categories-index')->with('status', 'The Item Category and Its related data were deleted successfully ');
    }

    public function showCategoryItems($slug){

        $itemCategory = $this->findItmCategoryBySlug($slug);

        $itemCategories = ItemCategory::all();

        $itemsRelated = Item::where('category_id', $itemCategory->id);

        $items = $itemsRelated
            ->orderByDesc('status')
            ->paginate(5);

        return view('items-categories.categories-items-list', [
            'itemCategory' =>  $itemCategory,
            'itemQ' => $itemsRelated->count(),
            'items' => $items,
            'itemCategories' => $itemCategories

        ]);


    }

    /**
     * @param $slug
     * @return mixed
     */
    protected function findItmCategoryBySlug($slug)
    {
        return ItemCategory::all()->where('slug', $slug)->first();
    }
}
