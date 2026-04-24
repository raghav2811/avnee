<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for moderation.
     */
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user', 'brand']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('user_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('comment', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('product', function($pq) use ($searchTerm) {
                      $pq->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();
        $brands = \App\Models\Brand::all();

        return view('admin.reviews.index', compact('reviews', 'brands'));
    }


    /**
     * Approve the specified review.
     */
    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject the specified review.
     */
    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
    /**
     * Update the admin reply for a review.
     */
    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);
 
        $review->update([
            'admin_reply' => $request->admin_reply,
        ]);
 
        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    /**
     * Show form to create a new review manually.
     */
    public function create()
    {
        $products = \App\Models\Product::where('is_active', true)->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        return view('admin.reviews.create', compact('products', 'brands'));
    }

    /**
     * Store a manually created review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'product_id' => 'required|exists:products,id',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'brand_id' => $validated['brand_id'],
            'product_id' => $validated['product_id'],
            'user_name' => $validated['user_name'],
            'user_id' => null, // Manual review
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'location' => $validated['location'] ?? null,
            'image' => $imagePath,
            'status' => 'approved',
            'is_verified' => true
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    /**
     * Show form to edit an existing review.
     */
    public function edit(Review $review)
    {
        $products = \App\Models\Product::where('is_active', true)->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        return view('admin.reviews.edit', compact('review', 'products', 'brands'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'product_id' => 'required|exists:products,id',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($review->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($review->image);
            }
            $validated['image'] = $request->file('image')->store('reviews', 'public');
        } elseif ($request->remove_image) {
            if ($review->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($review->image);
            }
            $validated['image'] = null;
        }

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }
}
