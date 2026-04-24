<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FlashSale extends Model
{
    protected $fillable = [
        'title', 'slug', 'image', 'start_time', 'end_time', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sale) {
            if (empty($sale->slug)) {
                $sale->slug = Str::slug($sale->title);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(FlashSaleProduct::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_products')
                    ->withPivot('discount_amount', 'discount_percentage', 'sort_order')
                    ->withTimestamps();
    }

    public function isActiveNow()
    {
        return $this->is_active && 
               now()->between($this->start_time, $this->end_time);
    }
}
