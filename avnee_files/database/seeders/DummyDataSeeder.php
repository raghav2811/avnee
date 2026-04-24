<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Create Banners
        Banner::truncate();
        $bannerImages = [
            'https://images.unsplash.com/photo-1610030469983-98e5473595ea?q=80&w=1920&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1515562141207-7a88ef7ce338?q=80&w=1920&auto=format&fit=crop',
        ];

        foreach ($bannerImages as $index => $url) {
            Banner::create([
                'title' => ($index == 0) ? 'The Royale Saree Collection' : 'Timeless Jewellery Pieces',
                'sub_title' => 'Elegance Redefined for the Modern Woman',
                'image' => $url,
                'link' => '/products',
                'location' => 'home_top',
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }

        // 2. Create Brands
        Brand::truncate();
        $brands = ['AVNEE Studio', 'AVNEE Jewellery', 'Nakshatra', 'Zaveri'];
        foreach ($brands as $b) {
            Brand::create(['name' => $b, 'slug' => Str::slug($b), 'is_active' => true]);
        }
        $brandId = Brand::first()->id;

        // 3. Create Categories
        Category::truncate();
        $categories = [
            ['name' => 'Sarees', 'slug' => 'sarees', 'image' => 'https://images.unsplash.com/photo-1610030469983-98e5473595ea?w=1000'],
            ['name' => 'Jewellery', 'slug' => 'jewellery', 'image' => 'https://images.unsplash.com/photo-1515562141207-7a88ef7ce338?w=1000'],
            ['name' => 'Kurtas', 'slug' => 'kurtas', 'image' => 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=1000'],
            ['name' => 'Lehengas', 'slug' => 'lehengas', 'image' => 'https://images.unsplash.com/photo-1599459183200-59c2642edec5?w=1000'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'image' => 'https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?w=1000'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'brand_id' => $brandId, // Migration REQUIRES brand_id
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'image' => $cat['image'],
                'is_active' => true,
                // 'is_featured' => true, // Column doesn't exist in categories
            ]);
        }

        // 4. Create Products
        Product::truncate();
        ProductVariant::truncate();

        $catModels = Category::all();

        foreach ($catModels as $category) {
            for ($i = 1; $i <= 5; $i++) {
                $productName = $category->name . " " . ($i % 2 == 0 ? 'Classic' : 'Premium') . " Collection #$i";
                $productDescription = "Discover the elegance of our handcrafted " . strtolower($category->name) . ". This piece embodies traditional craftsmanship with modern design.";
                
                $product = Product::create([
                    'brand_id' => $brandId,
                    'category_id' => $category->id,
                    'name' => $productName,
                    'slug' => Str::slug($productName . "-" . Str::random(4)),
                    'image' => $category->image,
                    'description' => $productDescription,
                    'is_active' => true,
                    'is_featured' => ($i == 1),
                ]);

                // Create 2-3 variants per product
                $sizes = ($category->slug == 'jewellery') ? ['Small', 'Medium', 'Large'] : ['S', 'M', 'L'];
                $colors = ['Deep Red', 'Emerald Blue', 'Golden Sands', 'Mist Grey', 'Midnight'];

                foreach (array_slice($sizes, 0, rand(2, 3)) as $size) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper($category->slug[0] . Str::random(9)),
                        'size' => $size,
                        'colour' => $colors[rand(0, 4)],
                        'price' => rand(3999, 8999),
                        'compare_price' => rand(10000, 12000),
                        'stock' => rand(5, 25),
                    ]);
                }
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
