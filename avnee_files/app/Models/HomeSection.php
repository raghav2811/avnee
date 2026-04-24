<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'section_id',
        'title',
        'subtitle',
        'redirect_url',
        'image',
        'product_ids',
        'limit',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getProductsAttribute()
    {
        if (empty($this->product_ids)) {
            return collect();
        }
        return Product::whereIn('id', $this->product_ids)->get();
    }
}
