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

use App\Item;
use App\ItemCategory;
use Illuminate\Support\Facades\Auth;

class Utils
{

    public static function authUserId(){
        return Auth::user()->id;
    }

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

    public function getCategoryNameFromId($id){
        return ItemCategory::all()->where('id', $id)->first()->name;
    }

    #returns an associative array
    public static function secondsToTime($inputSeconds) {
        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;
        $secondsInAMonth = 30 * $secondsInADay;
        $secondsInAYear = 12 * $secondsInAMonth;

        $years = floor($inputSeconds / $secondsInAYear);

        $monthSeconds = $inputSeconds % $secondsInAYear;
        $months = floor($monthSeconds / $secondsInAMonth);

        $daySeconds = $monthSeconds % $secondsInAMonth;
        $days = floor($daySeconds / $secondsInADay);

        $hourSeconds = $daySeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        $obj = array(
            'years' => (int) $years,
            'months' => (int) $months,
            'days' => (int) $days,
            'hours' => (int) $hours,
            'minutes' => (int) $minutes,
            'seconds' => (int) $seconds
        );
        return $obj;
    }

    /**
     * @param $slug
     * @return Item
     */
    public static function findItemBySlug($slug)
    {
        return Item::all()->where('slug', $slug)->first();
    }

    public static function getReadableDateTime($time){
        return (date("F jS, Y H:i:s",strtotime($time)));
    }


}