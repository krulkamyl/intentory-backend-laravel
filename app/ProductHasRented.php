<?php

namespace App;

use App\Classes\Constant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductHasRented
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $id_product
 * @property int $id_customer
 * @property string $rented_time
 * @property string $duration_time
 * @property int $is_rented
 * @property int $is_denuncation
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereDurationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereIdCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereIsDenuncation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereIsRented($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereRentedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasRented whereUpdatedAt($value)
 * @property-read \App\Customer $customer
 * @property-read \App\Product $product
 */
class ProductHasRented extends Model
{
    /**
     * Define table name in database
     * @var string
     */
    protected $table = Constant::TABLE_PRODUCTHASRENTED;

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
    protected $dateFormat = Constant::DATEFORMAT;

    /**
     * This attributes have dates
     * @var array
     */
    protected $dates = [
        'rented_time',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_customer',
        'id_product',
        'rented_time',
        'duration_time',
        'is_rented',
        'is_denuncation'
    ];


    /**
     * Get customer.
     *
     */
    public function customer() {
        return $this->hasOne(Customer::class,'id','id_customer');
    }

    /**
     * Get product
     *
     */
    public function product() {
        return $this->hasOne(Product::class,'id','id_product');
    }

    /**
     * Converting model to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product'=> $this->product->toArray(),
            'customer' => $this->customer->toArray(),
            'rented_time' => $this->rented_time->toDateString(),
            'duration_time' => $this->duration_time,
            'rented_cost' => $this->product->price * $this->duration_time,
            'is_rented' => $this->is_rented,
            'is_denuncation' => $this->is_denuncation,
            'duration_time_date' => $this->durationTimeDate()->toDateString(),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }

    public function durationTimeDate() {
        $immutable = Carbon::createFromTimeString($this->rented_time->toDateTimeString());
        return $immutable->addDays($this->duration_time);
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
