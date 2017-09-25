<?php

namespace App;

use App\Utility\AccessoryStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemAccessory
 *
 * @property-read \App\Item $item
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $photo_url
 * @property int $item_id
 * @property string $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAccessory whereUpdatedAt($value)
 */
class ItemAccessory extends Model
{
    protected $table = 'item_accessories';

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function is_available(){
        return $this->status === AccessoryStatus::$ACCESSORY_AVAILABLE;
    }
}
