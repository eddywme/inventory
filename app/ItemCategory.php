<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemCategory
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Item[] $items
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCategory whereUpdatedAt($value)
 */
class ItemCategory extends Model
{
    protected $table = "item_categories";

    public function items()
    {
        return $this->hasMany('App\Item', 'category_id');
    }
}
