<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemCategories = ItemCategory::all();
        return view('home', [
            'itemCategories' => $itemCategories
        ]);
    }

    public function search_data(Request $request){

        $items = DB::table('items')
//            ->where('is_available', '=', 1)

            ->where('name','like', '%'.$request->get('query').'%')
//            ->orWhere('description', 'like', '%'.$request->get('query').'%')
            ->get();



        //Get Item Titles
        $items_names = $items->pluck('name');
        $items_names = $items_names->map(function ($item){
            return substr($item,0,60);
        });





        /*Conform to the response norms of the auto-complete*/
        $array_response['query'] = "Unit";
        $array_response['suggestions'] = $items_names;

        return response()->json($array_response,200);
    }

    public function getConfirmationEmail(){

        $item = Item::all()->first();
        $user = User::all()->first();

        return view('emails.request-accepted')
            ->with([
                'item' => $item,
                'user' => $user
            ]);
    }



}
