<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemAccessory extends Model
{
    protected $table = 'item_accessories';

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
}
