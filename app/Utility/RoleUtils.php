<?php
/**
 * Created by PhpStorm.
 * User: eddylloyd
 * Date: 9/27/17
 * Time: 11:59 PM
 */

namespace app\Utility;


use Illuminate\Support\Facades\Auth;

class RoleUtils
{
    /* @param string
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

    public static function isAccountant(){
        return  self::authHasRole("account-user");
    }

    public static function isManager(){
        return  self::authHasRole("manager-user");
    }

    public static function isSysAdmin(){
        return  self::authHasRole("sys-admin-user");
    }



}