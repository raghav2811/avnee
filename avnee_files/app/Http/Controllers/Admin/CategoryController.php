<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['brand', 'parent'])->orderBy('brand_id')->orderBy('sort_order')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('is_active', true)->get();
        // Get only root categories to act as parents
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('brands', 'parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'parent_id' => 'nullable|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->where(function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id);
                })
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'sort_order' => 'required|integer|min:0',
            'show_in_menu' => 'nullable|boolean',
            'show_in_site_header' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $brand = Brand::findOrFail($request->brand_id);
        $slug = Str::slug($request->name);

        // Check if slug already exists globally
        if (Category::where('slug', $slug)->exists()) {
            // Apply brand prefix to make it unique across brands
            $slug = Str::slug($brand->name . ' ' . $request->name);
            
            // If still exists, add a numeric suffix as a last resort
            if (Category::where('slug', $slug)->exists()) {
                $originalSlug = $slug;
                $count = 1;
                while (Category::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }
            }
        }

        Category::create([
            'brand_id' => $request->brand_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'show_in_menu' => $request->has('show_in_menu'),
            'show_in_site_header' => $request->has('show_in_site_header'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
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
    public function edit(Category $category)
    {
        $brands = Brand::where('is_active', true)->get();
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
            
        return view('admin.categories.edit', compact('category', 'brands', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'parent_id' => 'nullable|exists:categories,id|not_in:'.$category->id,
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id)->where(function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id);
                })
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'sort_order' => 'required|integer|min:0',
            'show_in_menu' => 'nullable|boolean',
            'show_in_site_header' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        } elseif ($request->has('remove_image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = null;
        }

        $newSlug = $category->slug;
        if ($category->name !== $request->name || $category->brand_id != $request->brand_id) {
            $brand = Brand::findOrFail($request->brand_id);
            $newSlug = Str::slug($request->name);
            
            if (Category::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
                $newSlug = Str::slug($brand->name . ' ' . $request->name);
                
                if (Category::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
                    $originalSlug = $newSlug;
                    $count = 1;
                    while (Category::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
                        $newSlug = $originalSlug . '-' . $count++;
                    }
                }
            }
        }

        $category->update([
            'brand_id' => $request->brand_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $newSlug,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'show_in_menu' => $request->has('show_in_menu'),
            'show_in_site_header' => $request->has('show_in_site_header'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete a category with sub-categories. Remove them first.');
        }

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete a category assigned to products.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
