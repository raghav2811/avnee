<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category')->where('is_published', true);

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(9);
        $categories = BlogCategory::where('is_active', true)->withCount(['posts' => function($q) {
            $q->where('is_published', true);
        }])->get();

        return view('front.blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        $relatedPosts = BlogPost::where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->limit(3)
            ->get();

        return view('front.blog.show', compact('post', 'relatedPosts'));
    }
}
