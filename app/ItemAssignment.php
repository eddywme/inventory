<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemAssignment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $item_id
 * @property int $user_id
 * @property string $assigned_at
 * @property string $supposed_returned_at
 * @property string|null $returned_at
 * @property int $assigned_by
 * @property int|null $marked_returned_by
 * @property int $assigned_condition
 * @property string|null $assigned_comment
 * @property int|null $returned_condition
 * @property string|null $returned_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereAssignedComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereAssignedCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereMarkedReturnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereReturnedComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereReturnedCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereSupposedReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemAssignment whereUserId($value)
 */
class ItemAssignment extends Model
{

}
