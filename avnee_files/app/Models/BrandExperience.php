<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandExperience extends Model
{
    protected $fillable = [
        'brand_id',
        'layout_type',
        'title',
        'content_title',
        'content_description',
        'image_1',
        'image_1_label',
        'image_2',
        'image_2_label',
        'image_3',
        'image_3_label',
        'image_4',
        'image_4_label',
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
