<?php

namespace App;

use App\Classes\Constant;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductHasParam
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam query()
 * @mixin \Eloquent
 * @property int $id_product
 * @property int $id_param
 * @property string $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam whereIdParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam whereIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductHasParam whereValue($value)
 */
class ProductHasParam extends Model
{
    /**
     * Define table name in database
     * @var string
     */
    protected $table = Constant::TABLE_PRODUCTHASPARAMS;

    /**
     * Disable incrementing in table
     * @var bool
     */
    public $incrementing = false;

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
        'id_param',
        'id_product',
        'value'
    ];


    /**
     * Get param
     */
    public function param() {
        $this->hasOne(Parameter::class,'id','id_param');
    }

    /**
     * Get product
     */
    public function product() {
        $this->hasOne(Product::class,'id','id_product');
    }

    /**
     * Converting model to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id_param,
            'name' => $this->param->name,
            'value' => $this->value
        ];
    }

    public function toArrayParams() {
        $array = array();
        /** @var ProductHasParam $item */
        foreach (ProductHasParam::whereIdProduct($this->id_product)->get() as $item) {
            $array[$item->id_param] = [
                'name' => $item->param->name,
                'value' => $item->value
            ];
        }
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
