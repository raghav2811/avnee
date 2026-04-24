<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleProduct extends Model
{
    protected $table = 'flash_sale_products';

    protected $fillable = [
        'flash_sale_id', 'product_id', 'discount_amount', 'discount_percentage', 'sort_order'
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
