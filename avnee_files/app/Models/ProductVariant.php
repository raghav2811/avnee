<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'sku', 'size', 'colour', 'price',
        'compare_price', 'stock', 'low_stock_threshold'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if variant has enough stock
     */
    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    /**
     * Decrement stock
     */
    public function decrementStock($quantity)
    {
        if ($this->hasStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }
}
