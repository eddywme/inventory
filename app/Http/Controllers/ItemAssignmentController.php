<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\Utility\ItemStatus;
use App\Utility\Utils;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemAssignmentController extends Controller
{



    public function assignIndex($slug){
        $item = Utils::findItemBySlug($slug);
        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id)->all();

        return view('items-assignment.assignment-index',[
            'item' => $item,
            'itemAccessories' => $itemAccessories
        ]);
    }


    public function assignPost(Request $request, $itemSlug){

        $item = Utils::findItemBySlug($itemSlug);



        $user = DB::table('users')->where([
            ['first_name', '=', $request->get('first_name')],
            ['last_name', '=', $request->get('last_name')],
            ['email', '=', $request->get('email')],
        ])->first();

        if($user === null){
            return redirect()->back()->with('error-status', 'Assignment Failed. That person does not exist in the system');
        }elseif ($item === null){
            return redirect()->back()->with('error-status', 'Assignment Failed. That Item does not exist in the system');
        }
        elseif ($item->status){
            if($item->status === ItemStatus::$ITEM_TAKEN || $item->status == ItemStatus::$ITEM_RESERVED){
                return redirect()->back()->with('error-status', 'Assignment Failed. That Item is not available');
            }
        }



            /* Change the status state of the item */
            $item->status = ItemStatus::$ITEM_TAKEN;
            $item->save();



        $now = Carbon::now();
        DB::table('item_assignments')->insert([
            [
                'item_id' => $item->id,
                'user_id' => $user->id,
                'assigned_at' => $now->toDateTimeString(),
                'supposed_returned_at' => ($now->addHours($item->time_span))->toDateTimeString(),
                'assigned_by' => Utils::authUserId(),
                'assigned_condition' => $item->condition_id,
                'assigned_comment' => $request->get('comment'),

            ]
        ]);

            return redirect()->back()->with('success-status', 'The item was assigned successfully to '.$user->first_name.' '.$user->last_name);




    }

    public function assignmentList(){

        $itemAssignments = DB::table('item_assignments')->get();

        return view('items-assignment.assignment-list', [
            'itemAssignments' => $itemAssignments
        ]);
    }













    public function firstNamesEndPoint(Request $request){
        $users = DB::table('users')
            ->where('first_name','like', '%'.$request->get('query').'%')
            ->get();

        $users_first_names = $users->pluck('first_name');

        /*Conform to the response norms of the auto-complete*/
        $array_response['query'] = "Unit";
        $array_response['suggestions'] = $users_first_names;

        return response()->json($array_response,200);
    }

    public function lastNamesEndPoint(Request $request){
        $users = DB::table('users')
            ->where('last_name','like', '%'.$request->get('query').'%')
            ->get();

        $users_last_names = $users->pluck('last_name');

        /*Conform to the response norms of the auto-complete*/
        $array_response['query'] = "Unit";
        $array_response['suggestions'] = $users_last_names;

        return response()->json($array_response,200);
    }

    public function emailsEndPoint(Request $request){
        $users = DB::table('users')
            ->where('email','like', '%'.$request->get('query').'%')
            ->get();

        $users_emails = $users->pluck('email');

        /*Conform to the response norms of the auto-complete*/
        $array_response['query'] = "Unit";
        $array_response['suggestions'] = $users_emails;

        return response()->json($array_response,200);
    }


}
