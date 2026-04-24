<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image', 'title', 'sub_title', 'link', 'location', 'type', 'sort_order', 'is_active'
    ];
}
