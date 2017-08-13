<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){

        return view('admin.admin-index');
    }

}
