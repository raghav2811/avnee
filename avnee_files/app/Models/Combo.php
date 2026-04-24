<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'price',
        'original_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($combo) {
            if (empty($combo->slug)) {
                $combo->slug = Str::slug($combo->title) . '-' . time();
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products')->withTimestamps();
    }
}
