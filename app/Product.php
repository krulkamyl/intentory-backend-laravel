<?php

namespace App;

use App\Classes\Constant;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductHasParam[] $parameters
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 */
class Product extends Model
{
    /**
     * Define table name in database
     * @var string
     */
    protected $table = Constant::TABLE_PRODUCTS;

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
        'name',
        'price',
        'is_deleted'
    ];


    /**
     * Search product who is not deleted
     *
     * @param $id
     * @return Product|\Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function findProduct($id) {
        return Product::whereId($id)->whereIsDeleted(false)->first();
    }

    /**
     * Get all parameters in this product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameters()
    {
        return $this->hasMany(ProductHasParam::class,'id_param','id');
    }


}
