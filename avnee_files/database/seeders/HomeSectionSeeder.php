<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_id' => 'just_in',
                'title' => 'Just In',
                'subtitle' => 'Spring Arrivals',
                'sort_order' => 1,
                'limit' => 2,
            ],
            [
                'section_id' => 'shop_by_price',
                'title' => 'Shop By Price',
                'subtitle' => 'Curated Collections',
                'sort_order' => 2,
                'limit' => 4,
            ],
            [
                'section_id' => 'best_buys',
                'title' => 'Best Buys',
                'subtitle' => 'Popular Pieces',
                'sort_order' => 3,
                'limit' => 10,
            ],
            [
                'section_id' => 'shop_the_look',
                'title' => 'Shop The Look',
                'subtitle' => 'Complete Your Style',
                'sort_order' => 4,
                'limit' => 10,
            ],
            [
                'section_id' => 'top_collections',
                'title' => 'Top Collections',
                'subtitle' => 'Trending Now',
                'sort_order' => 5,
                'limit' => 8,
            ],
            [
                'section_id' => 'bestselling_styles',
                'title' => 'Bestselling Styles',
                'subtitle' => 'Most Loved',
                'sort_order' => 6,
                'limit' => 8,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::firstOrCreate(
                ['section_id' => $section['section_id']],
                $section
            );
        }
    }
}
