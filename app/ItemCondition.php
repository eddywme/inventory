<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemCondition
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemCondition whereUpdatedAt($value)
 */
class ItemCondition extends Model
{
    //
}
