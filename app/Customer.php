<?php

namespace App;

use App\Classes\Constant;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Customer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUpdatedAt($value)
 */
class Customer extends Model
{


    /**
     * Define table name in database
     * @var string
     */
    protected $table = Constant::TABLE_CUSTOMERS;

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


    /**
     * Converting model to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
          'name' => $this->name
        ];
    }

    /**
     * Converting model array to json
     *
     * @param integer $options
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(),$options);
    }
}
