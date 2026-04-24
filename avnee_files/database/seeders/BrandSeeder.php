<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'AVNEE Studio', 'slug' => 'avnee-studio', 'is_active' => true],
            ['name' => 'AVNEE Jewellery', 'slug' => 'avnee-jewellery', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}
