<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeExploreGrid extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'title',
        'subtitle',
        'image',
        'redirect_url',
        'grid_span',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
