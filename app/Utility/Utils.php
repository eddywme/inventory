<?php

/*
=============================================================
File name   : Utils.php.
Author      : Eddy WM [ eddywmdev@gmail.com ]
Date        : 8/15/17 1:03 AM
Description : Code written for ........
=============================================================
*/

namespace App\Utility;

use Illuminate\Support\Facades\Auth;

class Utils
{


    private static function authHasRole($role_name){
        return Auth::user()->role->name === $role_name;
    }



    public static function isAdmin(){
        return self::authHasRole("admin") || self::authHasRole("super-admin");
    }

    public static function isSuperAdmin(){
        return  self::authHasRole("super-admin");
    }

    public static function isSimpleUser(){
        return  self::authHasRole("simple-user");
    }

    public static function canUpdateUser($user){
        return Auth::user()->id === $user->id;
    }

}