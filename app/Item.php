<?php

namespace App;

use App\Utility\ItemStatus;
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
        return $this->status === ItemStatus::$ITEM_AVAILABLE;
    }

    public function showStatusName(){
        if($this->status === ItemStatus::$ITEM_RESERVED){
            return "RESERVED";
        }elseif ($this->status === ItemStatus::$ITEM_TAKEN){
            return "TAKEN";
        }elseif ($this->status === ItemStatus::$ITEM_AVAILABLE){
            return "AVAILABLE";
        }

        return null;
    }


}
