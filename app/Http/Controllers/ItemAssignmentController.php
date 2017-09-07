<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\ItemAssignment;
use App\ItemCondition;
use App\Mail\MailToAssignedMD;
use App\Mail\MailToAssignedUser;
use App\User;
use App\Utility\ItemStatus;
use App\Utility\Utils;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ItemAssignmentController extends Controller
{



    public function assignIndex($slug){
        $item = Utils::findItemBySlug($slug);

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }

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

    public function assignReturnGet($assignmentId){

        $itemAssignment = $this->findAssignmentFromId($assignmentId);
        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }
        $item = Item::all()->where('id', $itemAssignment->item_id)->first();
        if($item == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id)->all();
        $itemConditions = ItemCondition::all();
        $user = User::all()->where('id', $itemAssignment->user_id)->first();
        $admin = User::all()->where('id', $itemAssignment->assigned_by)->first();

        return view('items-assignment.assignment-return', [
            'item' => $item,
            'itemAccessories' => $itemAccessories,
            'user' => $user,
            'admin' => $admin,
            'itemAssignment' => $itemAssignment,
            'itemConditions' => $itemConditions
        ]);
    }

    public function assignReturnPost(Request $request, $assignmentId){
        $itemAssignment = $this->findAssignmentFromId($assignmentId);
        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');

        }
        $item = Item::all()->where('id', $itemAssignment->item_id)->first();

        if($item == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        $now = Carbon::now();

        DB::table('item_assignments')
            ->where('id', $itemAssignment->id)
            ->update([
                'returned_at' => $now->toDateTimeString(),
                'marked_returned_by' => Utils::authUserId(),
                'returned_condition' => $request->get('returned_condition'),
                'returned_comment' => $request->get('returned_comment'),
            ]);

        $item->status = ItemStatus::$ITEM_AVAILABLE;
        $item->save();

        return redirect()->back()->with('success-status', 'The item return process was done successfully ');

    }

    public function sendMailToAssignedGet($assignmentId){

        $itemAssignment = $this->findAssignmentFromId($assignmentId);
        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');

        }
        $item = Item::all()->where('id', $itemAssignment->item_id)->first();

        if($item == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        $user = User::all()->where('id', $itemAssignment->user_id)->first();

        if($user == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        return view('items-assignment.send-mail-assigned', [
            'item' => $item,
            'user' => $user,
            'itemAssignment' => $itemAssignment
        ]);
    }

    public function sendMailToAssignedPost(Request $request, $assignmentId){
        $itemAssignment = $this->findAssignmentFromId($assignmentId);

        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');

        }

        $this->validate($request, [
            'message' => 'string'
        ]);

        $message =  $request->get('message');
        $user = User::all()->where('id', $itemAssignment->user_id)->first();

        //        dd($message);



        $h = Mail::to($user)
            ->send(new MailToAssignedMD($message, $user));



        return redirect()->back()->with('success-status', 'That email was sent successfully');





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

    /**
     * @param $assignmentId
     * @return mixed
     */
    protected function findAssignmentFromId($assignmentId)
    {
        return ItemAssignment::all()->where('id', $assignmentId)->first();
    }


}
