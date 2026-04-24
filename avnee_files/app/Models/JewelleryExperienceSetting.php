<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewelleryExperienceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'main_image',
        'main_video',
        'detail_image_1',
        'detail_image_2',
        'detail_image_3',
        'button_text',
        'button_link',
        'is_active',
    ];
}
