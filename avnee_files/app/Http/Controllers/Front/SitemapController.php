<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\BlogPost;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->get();
        $posts = BlogPost::where('is_published', true)->latest()->get();
        $categories = Category::where('is_active', true)->get();

        return response()->view('front.sitemap', [
            'products' => $products,
            'posts' => $posts,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
