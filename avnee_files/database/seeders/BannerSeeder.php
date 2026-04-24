<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $banners = [
            [
                'title' => 'Ethereal Studio Edit',
                'sub_title' => 'Ships In Time For The Celebration',
                'image' => 'banners/hero-1.jpg', // From DummyImageSeeder
                'link' => '/products',
                'location' => 'home_top',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Jewellery Masterpieces',
                'sub_title' => 'Exquisite Craftsmanship',
                'image' => 'banners/hero-2.jpg',
                'link' => '/jewellery',
                'location' => 'home_top',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(['title' => $banner['title']], $banner);
        }
    }
}
