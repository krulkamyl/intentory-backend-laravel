<?php

namespace App;

use App\Classes\Constant;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Parameter
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereUpdatedAt($value)
 */
class Parameter extends Model
{
    /**
     * Define table name in database
     * @var string
     */
    protected $table = Constant::TABLE_PARAMETERS;

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d\TH:i:sO';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
