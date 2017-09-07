<?php

namespace App\Http\Controllers;

use App\ItemAccessory;
use App\ItemRequest;
use App\Mail\ItemRequestAccepted;
use App\Mail\ItemRequestAcceptedMD;
use App\User;
use App\Utility\ItemStatus;
use App\Utility\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ItemRequestController extends Controller
{
    public function requestIndex($slug){
        $item = Utils::findItemBySlug($slug);

        if ($item === null){
            return redirect()->back()->with('error-status', 'That Item does not exist in the system');
        }
        $itemAccessories = ItemAccessory::all()->where('item_id', $item->id)->all();
        return view('items-requests.request-index',[
            'item' => $item,
            'itemAccessories' => $itemAccessories
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

        $item->status = ItemStatus::$ITEM_RESERVED;
        $item->save();

        $item_request = new ItemRequest();
        $item_request->user_id = Utils::authUserId();
        $item_request->item_id = $item->id;
        $item_request->pickup_time = $request->get('pickup_date');
        $item_request->save();

        return redirect()->back()->with('success-status', 'Your request was sent successfully');

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

        $itemRequest->is_accepted = 1;
        $itemRequest->approved_by = Utils::authUserId();
        $itemRequest->save();

        $h = Mail::to($user)
            ->send(new ItemRequestAcceptedMD($itemRequest));



        return redirect()->back()->with('success-status', 'That User has received the e-mail request accepted notification');

    }
}
