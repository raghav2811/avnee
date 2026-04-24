<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $category = BlogCategory::firstOrCreate(
            ['slug' => 'heritage-styling'],
            ['name' => 'Heritage Styling', 'is_active' => true]
        );

        $posts = [
            [
                'title' => 'How to Style Traditional Jewellery with Modern Outfits',
                'slug' => 'style-traditional-jewellery-modern-outfits',
                'content' => 'Discover how to effortlessly pair traditional jewellery with modern outfits for a chic and elegant fusion look. Explore styling tips to make a statement with your ethnic jewelry pieces.',
                'image' => 'blogs/blog-1.jpg',
                'is_published' => true,
                'is_on_home' => true,
            ],
            [
                'title' => '5 Must-Have Statement Earrings for Every Occasion',
                'slug' => '5-must-have-statement-earrings',
                'content' => 'Elevate your accessory game with our top picks of statement earrings perfect for weddings, parties, and festive celebrations. Find out which eye-catching designs you need in your jewelry collection.',
                'image' => 'blogs/blog-2.jpg',
                'is_published' => true,
                'is_on_home' => true,
            ],
            [
                'title' => 'The Evolution of Bridal Couture in 2026',
                'slug' => 'evolution-bridal-couture-2026',
                'content' => 'A deep dive into the shifting paradigms of bridal fashion. From minimalism to maximalist archival revivals, we explore what the modern bride is choosing for her legacy moments.',
                'image' => 'blogs/blog-3.jpg',
                'is_published' => true,
                'is_on_home' => true,
            ]
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['blog_category_id' => $category->id])
            );
        }
    }
}
