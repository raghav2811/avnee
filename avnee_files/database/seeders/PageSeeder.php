<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h1>About AVNEE Collections</h1><p>AVNEE Collections is a "Made in India" brand for the modern Indian sensibilities. With "Everyday Ethnic" as the motto, we are on a mission to bring the best of India to the very forefront of modern fashion mainstream.</p><p>Bringing the best of India, with age old crafts and textiles, in modern silhouettes at par with the latest trends.</p>',
                'meta_title' => 'About Us | AVNEE Collections',
                'meta_description' => 'Learn more about AVNEE Collections, our mission, and our commitment to bringing ethnic fashion to the modern mainstream.',
                'is_active' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p>Welcome to AVNEE Collections. By using our website, you agree to these terms...</p>',
                'meta_title' => 'Terms of Service | AVNEE Collections',
                'meta_description' => 'Read our terms of service to understand your rights and responsibilities when using AVNEE Collections.',
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us. This policy explains how we collect and use your data...</p>',
                'meta_title' => 'Privacy Policy | AVNEE Collections',
                'meta_description' => 'Understand how AVNEE Collections handles your personal information with our clear and transparent privacy policy.',
                'is_active' => true,
            ],
            [
                'title' => 'Returns Policy',
                'slug' => 'returns-policy',
                'content' => '<h1>Returns & Exchanges</h1><p>We want you to be completely satisfied with your purchase. If not, here is how you can return or exchange items...</p>',
                'meta_title' => 'Returns & Exchanges Policy | AVNEE Collections',
                'meta_description' => 'Check our easy returns and exchange policy for a hassle-free shopping experience at AVNEE Collections.',
                'is_active' => true,
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'content' => '<h1>Shipping Information</h1><p>We offer free shipping on orders above ₹1499. Here are our delivery timelines and methods...</p>',
                'meta_title' => 'Shipping Policy | AVNEE Collections',
                'meta_description' => 'Get details on shipping costs, delivery timelines, and international shipping options from AVNEE Collections.',
                'is_active' => true,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h1>Contact Us</h1><p>Have questions? Reach out to us at support@avneecollections.com or call us at +91-XXXXXXXXXX.</p>',
                'meta_title' => 'Contact Us | AVNEE Collections',
                'meta_description' => 'Get in touch with the AVNEE Collections team for any queries, support, or feedback.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
