<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemAccessory;
use App\ItemAssignment;
use App\ItemCategory;
use App\ItemRequest;
use App\User;
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
        $numberOfItemRequests = ItemRequest::all()->count();

        return view('admin.admin-index', [
            'numberOfUsers' => $numberOfUsers,
            'numberOfItems' => $numberOfItems,
            'numberOfItemCategories' => $numberOfItemCategories,
            'numberOfItemAccessories' => $numberOfItemAccessories,
            'numberOfItemAssigned' => $numberOfItemAssigned,
            'numberOfItemRequests' => $numberOfItemRequests,
        ]);
    }

}
