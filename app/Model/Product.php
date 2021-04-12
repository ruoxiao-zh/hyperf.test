<?php

declare (strict_types = 1);

namespace App\Model;

use App\Constants\ProductOnSaleStatusEnum;
use Hyperf\Database\Model\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'on_sale' => 'boolean',
    ];

    public function scopeOnSale($query)
    {
        return $query->where('on_sale', ProductOnSaleStatusEnum::IS_ON_SALE);
    }
}