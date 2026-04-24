<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Studio Products
        $p1 = Product::updateOrCreate(
            ['slug' => 'elegant-silk-saree'],
            [
                'brand_id' => 1,
                'category_id' => 2, // Sarees
                'name' => 'Elegant Silk Saree',
                'description' => 'Beautiful premium silk saree for festive occasions.',
                'care_instructions' => 'Dry clean only.',
                'image' => 'products/silk-saree.jpg',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        ProductVariant::updateOrCreate(
            ['product_id' => $p1->id, 'sku' => 'ST-SAR-01-RED'],
            [
                'colour' => 'Red',
                'size' => 'Free Size',
                'price' => 5999,
                'stock' => 10,
            ]
        );

        // Jewellery Products
        $p2 = Product::updateOrCreate(
            ['slug' => 'diamond-studded-necklace'],
            [
                'brand_id' => 2,
                'category_id' => 5, // Necklaces
                'name' => 'Diamond Studded Necklace',
                'description' => 'Exquisite diamond necklace for weddings.',
                'care_instructions' => 'Keep away from moisture.',
                'image' => 'products/necklace.jpg',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        ProductVariant::updateOrCreate(
            ['product_id' => $p2->id, 'sku' => 'JW-NEC-01-GLD'],
            [
                'colour' => 'Gold',
                'size' => 'Standard',
                'price' => 25999,
                'compare_price' => 29999,
                'stock' => 5,
            ]
        );
    }
}
