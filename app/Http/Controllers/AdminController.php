<?php

namespace App\Http\Controllers;

use App\ApiSubscription;
use App\Item;
use App\ItemAccessory;
use App\ItemAssignment;
use App\ItemCategory;
use App\ItemRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utility\Utils;

class AdminController extends Controller
{
    public function index(){

        if(!Utils::isAdmin()){
            return redirect('/');
        }

        $numberOfUsers = User::all()->count();
        $numberOfItems = Item::all()->count();
        $numberOfItemCategories = ItemCategory::all()->count();
        $numberOfItemAccessories = ItemAccessory::all()->count();
        $numberOfItemAssigned = ItemAssignment::all()->count();
        $numberOfItemRequests = ItemRequest::all()->filter(function ($req) {
            return $req->is_rejected == false;
        })->count();


        $numberOfApiSubscriptions = ApiSubscription::all()->count();

        $lastItem = Item::all()->sortBy('created_at')->last();
        $lastItemAccessory = ItemAccessory::all()->sortBy('created_at')->last();
        $lastUser = User::all()->sortBy('created_at')->last();
        $lastItemAssignment = ItemAssignment::all()->sortBy('assigned_at')->last();
        $lastItemRequest = ItemRequest::all()->sortBy('created_at')->last();

//        dd($lastItemRequest);

//        dd(Carbon::now()->subHours(2)->diffForHumans());

        return view('admin.admin-index', [
            'numberOfUsers' => $numberOfUsers,
            'numberOfItems' => $numberOfItems,
            'numberOfItemCategories' => $numberOfItemCategories,
            'numberOfItemAccessories' => $numberOfItemAccessories,
            'numberOfItemAssigned' => $numberOfItemAssigned,
            'numberOfItemRequests' => $numberOfItemRequests,
            'numberOfApiSubscriptions' => $numberOfApiSubscriptions,

            /* Notification related vars*/

            'lastItem' => $lastItem,
            'lastUser' => $lastUser,
            'lastItemAccessory' => $lastItemAccessory,
            'lastItemAssignment' => $lastItemAssignment,
            'lastItemRequest' => $lastItemRequest


        ]);
    }

}
