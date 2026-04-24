<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category', 'variants']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('variants', function($sq) use ($search) {
                      $sq->where('sku', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'is_returnable' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image',
            'video' => 'nullable|mimes:mp4,mov,ogg,webm',
        ]);

        try {
            DB::beginTransaction();

            // Create Product
            $product = Product::create([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(), // Ensure unique slug
                'description' => $request->description,
                'care_instructions' => $request->care_instructions,
                'weight_grams' => $request->weight_grams,
                'is_featured' => $request->has('is_featured'),
                'is_active' => $request->has('is_active'),
                'is_returnable' => $request->boolean('is_returnable', true),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'video' => $request->hasFile('video') ? $request->file('video')->store('products/videos', 'public') : null,
            ]);

            // Create Variants
            foreach ($request->variants as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'colour' => $variantData['colour'] ?? null,
                    'size' => $variantData['size'] ?? null,
                    'stock' => $variantData['stock'],
                    'price' => $variantData['price'],
                    'compare_price' => $variantData['compare_price'] ?? null,
                ]);
            }

            // Handle Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'sort_order' => $i,
                    ]);

                    if ($i === 0) {
                        $product->update(['image' => $path]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['variants', 'images']);
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'is_returnable' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image',
            'video' => 'nullable|mimes:mp4,mov,ogg,webm,mkv',
        ]);

        try {
            DB::beginTransaction();

            $oldVideoPath = $product->video;
            $newVideoPath = $oldVideoPath;

            if ($request->has('remove_video')) {
                $newVideoPath = null;
            }

            if ($request->hasFile('video')) {
                $newVideoPath = $request->file('video')->store('products/videos', 'public');
            }

            $slug = Str::slug($request->name);
            if ($product->name !== $request->name) {
                $slug = $slug . '-' . uniqid();
            } else {
                $slug = $product->slug;
            }

            $product->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'care_instructions' => $request->care_instructions,
                'weight_grams' => $request->weight_grams,
                'is_featured' => $request->has('is_featured'),
                'is_active' => $request->has('is_active'),
                'is_returnable' => $request->boolean('is_returnable', true),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'video' => $newVideoPath,
            ]);

            // Remove stale video file when replacing or explicitly removing it.
            if ($oldVideoPath && $oldVideoPath !== $newVideoPath) {
                Storage::disk('public')->delete($oldVideoPath);
            }

            // Sync Variants
            $providedVariantSkus = collect($request->variants)->pluck('sku')->toArray();

            // Delete variants not in the request
            $product->variants()->whereNotIn('sku', $providedVariantSkus)->delete();

            foreach ($request->variants as $variantData) {
                ProductVariant::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'sku' => $variantData['sku']
                    ],
                    [
                        'colour' => $variantData['colour'] ?? null,
                        'size' => $variantData['size'] ?? null,
                        'stock' => $variantData['stock'],
                        'price' => $variantData['price'],
                        'compare_price' => $variantData['compare_price'] ?? null,
                    ]
                );
            }

            // Handle Image Deletion
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $img = ProductImage::find($imageId);
                    if ($img && $img->product_id == $product->id) {
                        Storage::disk('public')->delete($img->path);
                        $img->delete();
                    }
                }
            }

            // Handle New Images
            if ($request->hasFile('images')) {
                $maxSort = $product->images()->max('sort_order') ?? 0;
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'sort_order' => $maxSort + $i + 1,
                    ]);
                }
            }

            // Keep cover image synced to the first available media image.
            $primaryImage = $product->images()->orderBy('sort_order')->first();
            $product->update([
                'image' => $primaryImage?->path,
            ]);

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete images from disk
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        if ($product->video) {
            Storage::disk('public')->delete($product->video);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
