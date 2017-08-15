<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory;
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

        return view('admin.admin-index', [
            'numberOfUsers' => $numberOfUsers,
            'numberOfItems' => $numberOfItems,
            'numberOfItemCategories' => $numberOfItemCategories,
        ]);
    }

}
