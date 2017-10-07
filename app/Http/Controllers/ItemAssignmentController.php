<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\ItemAssignment;
use App\ItemCondition;
use App\Mail\MailToAssignedMD;
use App\User;
use App\Utility\AccessoryStatus;
use App\Utility\ItemStatus;
use App\Utility\RoleUtils;
use App\Utility\Utils;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemAssignmentController extends Controller
{



    public function assignIndex($slug){
        $item = Utils::findItemBySlug($slug);

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }

        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id);


        $standaloneAccessories = ItemAccessory::all()->filter(function ($accessory) {
            return $accessory->status === AccessoryStatus::$ACCESSORY_AVAILABLE && $accessory->item_id == null;
        });
        $accessories = $itemAccessories->merge($standaloneAccessories) ; // All available accessories , ability to select standalone accessories and dependent accessories

        return view('items-assignment.assignment-index',[
            'item' => $item,
            'itemAccessories' => $itemAccessories,
            'accessories' => $accessories
        ]);
    }

    /* Assign process when the item was reserved by a user */
    public function assignIndexToReserved ($itemSlug, $userSlug) {
//        dd($itemSlug, $userSlug);
        $item = Utils::findItemBySlug($itemSlug);


        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }

        $user_requester = Utils::findUserBySlug($userSlug);

//        dd($user_requester);

        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id)->all();


        return view('items-assignment.assignment-index',[
            'item' => $item,
            'user_requester' => $user_requester,
            'itemAccessories' => $itemAccessories
        ]);
    }


    public function assignPost(Request $request, $itemSlug){

        $item = Utils::findItemBySlug($itemSlug);



        $user = DB::table('users')->where([
            ['email', '=', $request->get('email')],
        ])->first();

        if($user === null){
            return redirect()->back()->with('error-status', 'Assignment Failed. That person does not exist in the system');
        }elseif ($item === null){
            return redirect()->back()->with('error-status', 'Assignment Failed. That Item does not exist in the system');
        }
        elseif ($item->status){
            if($item->status === ItemStatus::$ITEM_TAKEN ){
                return redirect()->back()->with('error-status', 'Assignment Failed. That Item is not available');
            }
        }



        /* Change the status state of the item */
        $item->status = ItemStatus::$ITEM_TAKEN;
        $item->save();



        $now = Carbon::now();

        $itemAssignment = new ItemAssignment();
        $itemAssignment->item_id = $item->id;
        $itemAssignment->user_id = $user->id;
        $itemAssignment->assigned_at = $now->toDateTimeString();
        $itemAssignment->supposed_returned_at = ($now->addHours($item->time_span))->toDateTimeString();
        $itemAssignment->assigned_by = Utils::authUserId();
        $itemAssignment->assigned_condition = $item->condition_id;
        $itemAssignment->assigned_comment = $request->get('comment');


        $itemAssignment->save();

        $selectedAccessoriesIds = $request->get('accessories');

        if ($selectedAccessoriesIds) {
            foreach ($selectedAccessoriesIds as $accessoryId) {
                $accessory = Utils::findAccessoryById($accessoryId);
                $accessory->status = AccessoryStatus::$ACCESSORY_TAKEN; // Change the accessory status
                $accessory->save();
                DB::table('accessories_assigned')->insert([
                    [
                        'assignment_id' => $itemAssignment->id,
                        'accessory_id' => $accessoryId
                    ]
                ]);



            }

        }



        return redirect(route('assign.list'))->with('success-status', 'The item was assigned successfully to '.$user->first_name.' '.$user->last_name);




    }

    public function assignmentList(){

        $itemAssignments = DB::table('item_assignments')->get();
        //dd($itemAssignments);
        return view('items-assignment.assignment-list', [
            'itemAssignments' => $itemAssignments
        ]);
    }

    public function assignReturnGet ($assignmentId) {

        $itemAssignment = $this->findAssignmentFromId($assignmentId);

        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        if ($itemAssignment->returned_at !== null) {
            return redirect(route('assign.list'))->with('error-status', 'The Item was already marked returned !');
        }

        $item = Item::all()->where('id', $itemAssignment->item_id)->first();
        if($item == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');
        }

        $accessoriesAssigned = \App\AccessoryAssigned::all()->where('assignment_id', $itemAssignment->id)
            ->all();

        $itemAccessories = [];

        foreach ($accessoriesAssigned as $acc) {
            $itemAccessories[] = \App\ItemAccessory::all()->where('id',$acc->accessory_id)->first();
        }
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
        if ($itemAssignment->returned_at !== null) {
            return redirect(route('assign.list'))->with('error-status', 'The Item was already marked returned !');
        }
        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'That Item Assignment does not exist !');

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

        return redirect(route('assign.list'))->with('success-status', 'The item return process was done successfully ');


    }

    public function sendMailToAssignedGet($assignmentId){

        if(!RoleUtils::isSysAdminOrManager()) {
            return redirect('/');
        }

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

        if(!RoleUtils::isSysAdminOrManager()) {
            return redirect('/');
        }

        $itemAssignment = $this->findAssignmentFromId($assignmentId);

        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');

        }

        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $message =  $request->get('message');
        $user = User::all()->where('id', $itemAssignment->user_id)->first();

        //        dd($message);



        $h = Mail::to($user)
            ->send(new MailToAssignedMD($message, $user));

//        sleep(5);
        return response()->json([
            'message' => 'The email was sent successfully'
        ], 200) ;





    }


    public function sendSMSToAssignedGet($assignmentId){

        if(!RoleUtils::isSysAdminOrManager()) {
            return redirect('/');
        }

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

        return view('items-assignment.send-sms-assigned', [
            'item' => $item,
            'user' => $user,
            'itemAssignment' => $itemAssignment
        ]);
    }

    public function sendSMSToAssignedPost(Request $request, $assignmentId){

        if(!RoleUtils::isSysAdminOrManager()) {
            return redirect('/');
        }

        $itemAssignment = $this->findAssignmentFromId($assignmentId);

        if($itemAssignment == null) {
            return redirect()->back()->with('error-status', 'An error occurred !');

        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255'

        ]);

        if ($validator->fails()) {

            $errors['errors'] = $validator->errors()->all();
            return response()->json($errors, 400) ;
        }

        $message =  $request->get('message');
        $user = User::all()->where('id', $itemAssignment->user_id)->first();

        //        dd($message);



        $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to' => $user->phone_number,
            'from' => env('PHONE_NUMBER', 'NEXMO'),
            'text' => $message
        ]);

        return response()->json([
            'message' => 'The SMS was sent successfully'
        ], 200) ;
//        sleep(5);






    }

    public function getListOfOverdue () {
        $itemsAssignments = ItemAssignment::all();

        $overdueAssignments = $itemsAssignments->filter(function($itemAssignment){
            return $itemAssignment->supposed_returned_at < \Carbon\Carbon::now()->toDateTimeString();
        });

        return view('items-assignment.overdue-assignment-list', [
            'overdueAssignments' => $overdueAssignments
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

    /**
     * @param $assignmentId
     * @return mixed
     */
    protected function findAssignmentFromId($assignmentId)
    {
        return ItemAssignment::all()->where('id', $assignmentId)->first();
    }


}
