<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenAssignmentController extends Controller
{
    public function index(){
        return view('api.token-assignment-index');
    }

    public function assignTokenGet(){
        return view('api.token-assignment-index');
    }
}
