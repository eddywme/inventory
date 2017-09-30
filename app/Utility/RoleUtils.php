<?php
/**
 * Created by PhpStorm.
 * User: eddylloyd
 * Date: 9/27/17
 * Time: 11:59 PM
 */

namespace App\Utility;


use Illuminate\Support\Facades\Auth;

class RoleUtils
{
    /* @param $roleName
     * @return boolean
     * */
    private static function authHasRole($roleName){
        return Auth::user()->role->name === $roleName;
    }



    public static function isSystemPersonnel(){
        return
            self::authHasRole("account-user") ||
            self::authHasRole("manager-user")||
            self::authHasRole("sys-admin-user");
    }

    public static function isRegisteredUser(){
        return  self::authHasRole("registered-user");
    }

    public static function isAccountant(){
        return  self::authHasRole("account-user");
    }

    public static function isManager(){
        return  self::authHasRole("manager-user");
    }

    public static function isSysAdmin(){
        return  self::authHasRole("sys-admin-user");
    }

    public static function isSysAdminOrManager(){
        return  self::authHasRole("sys-admin-user") || self::authHasRole("manager-user");
    }



}