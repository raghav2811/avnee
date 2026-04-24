<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Studio Categories (Brand ID 1)
            [
                'brand_id' => 1,
                'name' => 'Anarkali Sets',
                'slug' => 'anarkali-sets',
                'description' => 'Flowing silhouettes and intricate embroideries.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
            ],
            [
                'brand_id' => 1,
                'name' => 'Sarees',
                'slug' => 'sarees',
                'description' => 'Six yards of pure elegance.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 2,
            ],
            [
                'brand_id' => 1,
                'name' => 'Lehenga Choli',
                'slug' => 'lehenga-choli',
                'description' => 'The perfect festive attire.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 3,
            ],
            [
                'brand_id' => 1,
                'name' => 'Western Wear',
                'slug' => 'western-wear',
                'description' => 'Modern styles with an ethnic touch.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 4,
            ],
            [
                'brand_id' => 1,
                'name' => 'Party Frocks',
                'slug' => 'party-frocks',
                'description' => 'Beautiful party wear for girls.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 5,
            ],
            [
                'brand_id' => 1,
                'name' => 'Festive Wear',
                'slug' => 'festive-wear',
                'description' => 'Traditional festive collections.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 6,
            ],
            [
                'brand_id' => 1,
                'name' => 'Girls Dresses',
                'slug' => 'girls-dresses',
                'description' => 'Daily wear dresses for girls.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 7,
            ],
            [
                'brand_id' => 1,
                'name' => 'Daily Wear',
                'slug' => 'daily-wear',
                'description' => 'Comfortable daily wear options.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 8,
            ],
            [
                'brand_id' => 1,
                'name' => '2-4 Years',
                'slug' => '2-4-years',
                'description' => 'Clothing for toddlers aged 2-4 years.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 9,
            ],
            [
                'brand_id' => 1,
                'name' => '4-6 Years',
                'slug' => '4-6-years',
                'description' => 'Clothing for kids aged 4-6 years.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 10,
            ],
            [
                'brand_id' => 1,
                'name' => '6-14 Years',
                'slug' => '6-14-years',
                'description' => 'Clothing for older kids aged 6-14 years.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 11,
            ],
            [
                'brand_id' => 1,
                'name' => 'Infant Sets',
                'slug' => 'infant-sets',
                'description' => 'Complete sets for infants.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 12,
            ],
            [
                'brand_id' => 1,
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Fashion accessories for girls.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 13,
            ],
            [
                'brand_id' => 1,
                'name' => 'Fun Trinkets',
                'slug' => 'fun-trinkets',
                'description' => 'Cute trinkets and collectibles.',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 14,
            ],

            // Jewellery Categories (Brand ID 2)
            [
                'brand_id' => 2,
                'name' => 'Necklaces',
                'slug' => 'necklaces',
                'description' => 'Statement pieces for your neckline',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
            ],
            [
                'brand_id' => 2,
                'name' => 'Earrings',
                'slug' => 'earrings',
                'description' => 'Dangling beauties and elegant studs',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 2,
            ],
            [
                'brand_id' => 2,
                'name' => 'Bangles & Bracelets',
                'slug' => 'bangles-bracelets',
                'description' => 'Adorn your wrists with gold and gems',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 3,
            ],
            [
                'brand_id' => 2,
                'name' => 'Bridal Sets',
                'slug' => 'bridal-sets',
                'description' => 'Complete sets for your special day',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 4,
            ],
            [
                'brand_id' => 2,
                'name' => 'Rings',
                'slug' => 'rings',
                'description' => 'Elegant rings for every occasion',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 5,
            ],
            [
                'brand_id' => 2,
                'name' => 'Mangalsutra',
                'slug' => 'mangalsutra',
                'description' => 'Traditional mangalsutra with intricate designs',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 6,
            ],
            [
                'brand_id' => 2,
                'name' => 'Necklace Sets',
                'slug' => 'necklace-set',
                'description' => 'Complete necklace sets for elegant looks',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 7,
            ],
            [
                'brand_id' => 2,
                'name' => 'Hair Accessories',
                'slug' => 'hair-accessories',
                'description' => 'Beautiful hair accessories for all occasions',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 8,
            ],
            [
                'brand_id' => 2,
                'name' => 'Jewellery Gallery',
                'slug' => 'jewellery-gallery',
                'description' => 'Complete jewellery collection',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
