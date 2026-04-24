<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeStyle;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeStyleController extends Controller
{
    public function index()
    {
        $styles = HomeStyle::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();
        return view('admin.home_styles.index', compact('styles'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.home_styles.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'redirect_url' => 'nullable|string',
            'image' => 'required|image',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home_styles', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        HomeStyle::create($data);
        return redirect()->route('admin.home-styles.index')->with('success', 'Home style added successfully.');
    }

    public function edit(HomeStyle $homeStyle)
    {
        $brands = Brand::all();
        return view('admin.home_styles.edit', compact('homeStyle', 'brands'));
    }

    public function update(Request $request, HomeStyle $homeStyle)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'redirect_url' => 'nullable|string',
            'image' => 'nullable|image',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($homeStyle->image) {
                Storage::disk('public')->delete($homeStyle->image);
            }
            $data['image'] = $request->file('image')->store('home_styles', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $homeStyle->update($data);
        return redirect()->route('admin.home-styles.index')->with('success', 'Home style updated successfully.');
    }

    public function destroy(HomeStyle $homeStyle)
    {
        if ($homeStyle->image) {
            Storage::disk('public')->delete($homeStyle->image);
        }
        $homeStyle->delete();
        return redirect()->route('admin.home-styles.index')->with('success', 'Home style deleted successfully.');
    }
}
