<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function ownedBy()
    {
        return $this->belongsTo('App\User', 'owned_by');
    }

    public function recordedBy()
    {
        return $this->belongsTo('App\User', 'recorded_by');
    }

    public function lastlyEditedBy()
    {
        return $this->belongsTo('App\User', 'lastly_edited_by');
    }

    public function itemCondition()
    {
        return $this->belongsTo('App\ItemCondition', 'condition_id');
    }

    public function itemCategory()
    {
        return $this->belongsTo('App\ItemCategory', 'category_id');
    }

    public function itemAccessories()
    {
        return $this->hasMany('App\ItemAccessory', 'item_id');
    }

    public  function timeSpanObject(){
        /**/
        return Utility\Utils::secondsToTime($this->time_span * 60 * 60);
    }


    public function is_available(){
        return $this->status === 2;
    }

    public function showStatusName(){
        if($this->status === 1){
            return "RESERVED";
        }elseif ($this->status === 0){
            return "TAKEN";
        }elseif ($this->status === 2){
            return "AVAILABLE";
        }

        return null;
    }


}
