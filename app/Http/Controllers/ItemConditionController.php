<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCondition;
use App\Utility\RoleUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! RoleUtils::isSystemPersonnel()) {
            return redirect('/');
        }

        $itemConditions = ItemCondition::all();

        return view('items-conditions.items-conditions-index', [
            'itemConditions' => $itemConditions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items-conditions.items-condition-form');
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
            'name' => 'required|string|unique:item_conditions',
            'description' => 'required'
        ]);



        $itemCondition = new ItemCondition();
        $itemCondition->name = $request->input('name');
        $itemCondition->description = $request->input('description');
        $itemCondition->slug = str_slug( $request->input('name'));
        $itemCondition->save();

        return redirect()->back()->with('status', 'A new Item Condition has been created successfully');
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
        $itemCondition = $this->findItmConditionBySlug($slug);

        return view('items-conditions.items-condition-form', [
            'itemCondition' => $itemCondition
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
        $itemCondition = $this->findItmConditionBySlug($slug);

        if($itemCondition === null){
            return redirect()->back();
        }
        $this->validate($request, [
            'name' => 'required|unique:item_conditions,name,'.$itemCondition->id,
            'description' => 'required'

        ]);

        $itemCondition->name = $request->input('name');
        $itemCondition->description = $request->input('description');
        $itemCondition->save();
        return redirect(route('item-conditions.index'))->with('status', 'The Item Condition has been updated .');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
    }

    /**
     * @param $slug
     * @return ItemCondition
     */
    protected function findItmConditionBySlug($slug)
    {
        return ItemCondition::all()->where('slug', $slug)->first();
    }
}
