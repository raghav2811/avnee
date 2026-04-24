<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeExploreGrid;
use App\Models\Product;

class ExploreGridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplication during development
        HomeExploreGrid::truncate();

        // Target brand-specific images for a perfect visual fit
        $studioProducts = Product::where('brand_id', 1)->take(5)->pluck('image');
        $jewelleryProducts = Product::where('brand_id', 2)->take(5)->pluck('image');

        // Studio (Brand ID: 1) - High-Fidelity Editorial Selections
        $studioData = [
            [
                'brand_id' => 1,
                'title' => 'Jewellery Edit',
                'subtitle' => 'All That Jewels You Must Own',
                'image' => $studioProducts->get(0) ?? 'products/default.jpg',
                'redirect_url' => '/products',
                'grid_span' => 2,
                'sort_order' => 1
            ],
            [
                'brand_id' => 1,
                'title' => 'Earrings Edit',
                'subtitle' => 'Jhumkas | Chandbalis | Studs',
                'image' => $studioProducts->get(1) ?? 'products/default.jpg',
                'redirect_url' => '/products',
                'grid_span' => 2,
                'sort_order' => 2
            ],
            [
                'brand_id' => 1,
                'title' => 'Organizers Edit',
                'subtitle' => 'Keep Your Precious Jewels Organized',
                'image' => $studioProducts->get(2) ?? 'products/default.jpg',
                'redirect_url' => '/products',
                'grid_span' => 1,
                'sort_order' => 3
            ],
            [
                'brand_id' => 1,
                'title' => 'Organizers Edit',
                'subtitle' => 'Shop Now - Shop To Organized',
                'image' => $studioProducts->get(3) ?? 'products/default.jpg',
                'redirect_url' => '/products',
                'grid_span' => 1,
                'sort_order' => 4
            ],
            [
                'brand_id' => 1,
                'title' => 'Hair Accessories Edit',
                'subtitle' => 'Elegant Pieces To Adorn Your Locks',
                'image' => $studioProducts->get(4) ?? 'products/default.jpg',
                'redirect_url' => '/products',
                'grid_span' => 2,
                'sort_order' => 5
            ]
        ];

        // Jewellery (Brand ID: 2) - Obsidian Archive Selections
        $jewelleryData = [
            [
                'brand_id' => 2,
                'title' => 'The Gold Ritual',
                'subtitle' => 'Handcrafted Heritage Pieces',
                'image' => $jewelleryProducts->get(0) ?? 'products/default.jpg',
                'redirect_url' => '/jewellery',
                'grid_span' => 2,
                'sort_order' => 1
            ],
            [
                'brand_id' => 2,
                'title' => 'Diamond Archive',
                'subtitle' => 'The Brilliance of Bespoke Craft',
                'image' => $jewelleryProducts->get(1) ?? 'products/default.jpg',
                'redirect_url' => '/jewellery',
                'grid_span' => 2,
                'sort_order' => 2
            ],
            [
                'brand_id' => 2,
                'title' => 'Celestial Rings',
                'subtitle' => 'For Eternal Unions',
                'image' => $jewelleryProducts->get(2) ?? 'products/default.jpg',
                'redirect_url' => '/jewellery',
                'grid_span' => 1,
                'sort_order' => 3
            ],
            [
                'brand_id' => 2,
                'title' => 'Temple Protocol',
                'subtitle' => 'Sacred Adornments for the Soul',
                'image' => $jewelleryProducts->get(3) ?? 'products/default.jpg',
                'redirect_url' => '/jewellery',
                'grid_span' => 1,
                'sort_order' => 4
            ],
            [
                'brand_id' => 2,
                'title' => 'Jewellery Restoration',
                'subtitle' => 'Preserve Your Family Archive',
                'image' => $jewelleryProducts->get(4) ?? 'products/default.jpg',
                'redirect_url' => '/jewellery',
                'grid_span' => 2,
                'sort_order' => 5
            ]
        ];

        foreach (array_merge($studioData, $jewelleryData) as $data) {
            HomeExploreGrid::create($data);
        }
    }
}
