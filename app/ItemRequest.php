<?php

namespace App;

use App\Utility\Utils;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemRequest
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 * @property string $pickup_time
 * @property int|null $approved_by
 * @property string|null $approved_on
 * @property int $is_accepted
 * @property int $is_concluded
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereApprovedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereIsAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereIsConcluded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest wherePickupTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemRequest whereUserId($value)
 */
class ItemRequest extends Model
{

}
