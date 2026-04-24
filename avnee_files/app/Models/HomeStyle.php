<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'title',
        'image',
        'redirect_url',
        'sort_order',
        'is_active',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
