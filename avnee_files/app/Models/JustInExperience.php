<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustInExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
