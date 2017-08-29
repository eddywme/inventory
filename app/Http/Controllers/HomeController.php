<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory;
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

        return view('home');
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



}
