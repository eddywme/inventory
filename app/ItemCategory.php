<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ItemCategory extends Model
{
    protected $table = "item_categories";

    public function items()
    {
        return $this->hasMany('App\Item', 'category_id');
    }
}
