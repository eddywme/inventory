<?php

namespace App\Http\Controllers;

use App\AccessoryRequested;
use App\Http\Controllers\Auth\LoginController;
use App\Item;
use App\ItemAccessory;
use App\ItemRequest;
use App\Log;
use App\Mail\ItemRequestAccepted;
use App\Mail\ItemRequestAcceptedMD;
use App\User;
use App\Utility\AccessoryStatus;
use App\Utility\ItemStatus;
use App\Utility\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ItemRequestController extends Controller
{
    public function requestIndex($slug){
        $item = Utils::findItemBySlug($slug);

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }
        if (!$item->is_available()){
            return redirect()->back()->with('error-status', 'That Item is not available');
        }

        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id)->all(); // Current item related acccessories
        $accessories = ItemAccessory::all()->filter(function($accessory) {
            return $accessory->status === AccessoryStatus::$ACCESSORY_AVAILABLE;
        }); // All available accessories , ability to select standalone accessories
        return view('items-requests.request-index',[
            'item' => $item,
            'itemAccessories' => $itemAccessories,
            'accessories' => $accessories
        ]);
    }


    public function show($itemRequestId){



        $itemRequest  = ItemRequest::all()->where('id', $itemRequestId)->first();
        if ($itemRequest === null){
            return redirect()->back()->with('error-status', 'That Item Request does not exist in the system');
        }
        $item  = Item::all()->where('id', $itemRequest->item_id)->first();

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item Request does not exist in the system');
        }
        $user = User::all()->where('id', $itemRequest->user_id)->first();
        if ($user === null){
            return redirect()->back()->with('error-status', 'That User does not exist in the system');
        }

        $AccessoriesRequestedPivot = AccessoryRequested::all()->where('request_id', $itemRequest->id)->all();

        $AccessoriesRequestedIds = array_map((function ($e) {
            return $e['accessory_id'];
        }), $AccessoriesRequestedPivot);

        $accessoriesRequested = [];
        foreach ($AccessoriesRequestedIds as $accessoriesRequestedId) {
            $accessoriesRequested [] = ItemAccessory::all()->where('id', $accessoriesRequestedId)->first();
        }

        return view('items-requests.request-show',[
            'item' => $item,
            'user' => $user,
            'itemRequest' => $itemRequest,
            'accessoriesRequested' => $accessoriesRequested
        ]);

    }

    public function requestPost(Request $request, $slug){

        $this->validate($request, [
            'pickup_date' => 'required|date'
        ]);

        $item = Utils::findItemBySlug($slug);

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }

        if (!$item->is_available()){
            return redirect()->back()->with('error-status', 'That Item is not available');
        }



        $item->status = ItemStatus::$ITEM_RESERVED;
        $item->save();


        $item_request = new ItemRequest();
        $item_request->user_id = Utils::authUserId();
        $item_request->item_id = $item->id;
        $item_request->pickup_time = $request->get('pickup_date');
        $item_request->save();

        $selectedAccessoriesIds = $request->get('accessories');

        if ($selectedAccessoriesIds) {

            foreach ($selectedAccessoriesIds as $accessoryId) {

                $accessoryRequested = new AccessoryRequested();
                $accessoryRequested->request_id  = $item_request->id;
                $accessoryRequested->accessory_id = $accessoryId;

                $accessoryRequested->save();

                $accessory = Utils::findAccessoryById($accessoryId);
                $accessory->status = AccessoryStatus::$ACCESSORY_RESERVED;
                $accessory->save();



            }

        }

        return redirect(route('items.index'))->with('success-status', 'Your request was sent successfully');

    }

    public function requestList(){

        $itemRequests = ItemRequest::all();

        return view('items-requests.request-list', [
            'itemRequests' => $itemRequests
        ]);

    }


    public function requestResponseAccepted($itemRequestId){

        $itemRequest  = ItemRequest::all()->where('id', $itemRequestId)->first();
        if ($itemRequest === null){
            return redirect()->back()->with('error-status', 'That Item Request does not exist in the system');
        }
        $user = User::all()->where('id', $itemRequest->user_id)->first();
        if ($user === null){
            return redirect()->back()->with('error-status', 'That User does not exist in the system');
        }
//        sleep(8);
        Mail::to($user)
            ->send(new ItemRequestAcceptedMD($itemRequest));

        $itemRequest->is_accepted = 1;
        $itemRequest->approved_by = Utils::authUserId();
        $itemRequest->approved_on = Carbon::now();
        $itemRequest->save();




        return response()->json([
            'message' => 'The Item was approved ! A notification was sent to the user : '.$user->getName()
        ], 200) ;

//        return redirect()->back()->with('success-status', 'That User has received the e-mail request accepted notification');

    }

    public function releaseItem($itemSlug){
        $item = Utils::findItemBySlug($itemSlug);
        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }

        $itemRequest  = ItemRequest::all()->where('item_id', $item->id)->last();
        $itemRequest->delete();

        $item->status = ItemStatus::$ITEM_AVAILABLE;
        $item->save();

        $log = new Log();
        $userAdmin = Utils::getAuthName();
        $userRequester = User::all()->where('id', $itemRequest->user_id)->first();
        $log->description ="Administrator : $userAdmin\nRejected the request from: {$userRequester->getName()} ( $userRequester->email )\n
        Item Name: $item->name ($item->serial_number)";
        $log->save();

        return redirect(route('request.list'))->with('success-status', 'The item was released successfully');

    }


}
