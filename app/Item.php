<?php

namespace App;

use App\Utility\ItemStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Item
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ItemAccessory[] $itemAccessories
 * @property-read \App\ItemCategory $itemCategory
 * @property-read \App\ItemCondition $itemCondition
 * @property-read \App\User $lastlyEditedBy
 * @property-read \App\User $ownedBy
 * @property-read \App\User $recordedBy
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $time_span
 * @property string|null $photo_url
 * @property string $serial_number
 * @property string $identifier
 * @property string $slug
 * @property string $location
 * @property float $price
 * @property int $status
 * @property string $model_number
 * @property string $date_acquired
 * @property int|null $lastly_edited_by
 * @property int $recorded_by
 * @property int $owned_by
 * @property int $category_id
 * @property int $condition_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereDateAcquired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereLastlyEditedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereModelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereOwnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereTimeSpan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereUpdatedAt($value)
 */
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
