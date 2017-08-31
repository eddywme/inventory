<?php

namespace App\Http\Controllers;

use App\ItemAccessory;
use App\ItemRequest;
use App\Utility\ItemStatus;
use App\Utility\Utils;
use Illuminate\Http\Request;

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
}
