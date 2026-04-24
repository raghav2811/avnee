<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = HomeSection::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();
        return view('admin.home_sections.index', compact('sections'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.home_sections.create', compact('products', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'section_id' => 'required|unique:home_sections,section_id,NULL,id,brand_id,' . $request->brand_id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string',
            'image' => 'nullable|image',
            'product_ids' => 'nullable|array',
            'limit' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home_sections', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['product_ids'] = $request->input('product_ids', []);

        \Illuminate\Support\Facades\Log::info('Creating HomeSection', ['data' => $validated]);
        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'Home section created successfully.');
    }

    public function edit(HomeSection $homeSection)
    {
        $products = Product::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.home_sections.edit', compact('homeSection', 'products', 'brands'));
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        \Illuminate\Support\Facades\Log::info('HomeSection update hit', ['request' => $request->all()]);
        
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'section_id' => 'required|unique:home_sections,section_id,' . $homeSection->id . ',id,brand_id,' . $request->brand_id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'product_ids' => 'nullable|array',
            'limit' => 'required|integer|min:1',
            'is_active' => 'nullable',
            'sort_order' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($homeSection->image) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = $request->file('image')->store('home_sections', 'public');
        } elseif ($request->has('remove_image')) {
            if ($homeSection->image) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = null;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['product_ids'] = $request->input('product_ids', []);

        \Illuminate\Support\Facades\Log::info('Updating HomeSection', ['id' => $homeSection->id, 'data' => $validated]);
        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'Home section updated successfully.');
    }

    public function destroy(HomeSection $homeSection)
    {
        if ($homeSection->image) {
            Storage::disk('public')->delete($homeSection->image);
        }
        $homeSection->delete();
        return redirect()->route('admin.home-sections.index')->with('success', 'Home section deleted successfully.');
    }
}
