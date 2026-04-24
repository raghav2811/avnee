<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceBand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'label',
        'price_limit',
        'redirect_url',
        'sort_order',
        'is_active',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
