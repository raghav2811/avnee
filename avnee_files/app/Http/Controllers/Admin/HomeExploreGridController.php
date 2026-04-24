<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeExploreGrid;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeExploreGridController extends Controller
{
    public function index()
    {
        $grids = HomeExploreGrid::with('brand')->orderBy('brand_id')->orderBy('sort_order')->paginate(15);
        return view('admin.home-explore-grids.index', compact('grids'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.home-explore-grids.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'redirect_url' => 'nullable|string|max:255',
            'grid_span' => 'required|integer|in:1,2',
            'sort_order' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('explore_grids', 'public');
        }

        HomeExploreGrid::create([
            'brand_id' => $request->brand_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'redirect_url' => $request->redirect_url,
            'grid_span' => $request->grid_span,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.home-explore-grids.index')->with('success', 'Explore Grid item created successfully.');
    }

    public function edit(HomeExploreGrid $homeExploreGrid)
    {
        $brands = Brand::all();
        return view('admin.home-explore-grids.edit', compact('homeExploreGrid', 'brands'));
    }

    public function update(Request $request, HomeExploreGrid $homeExploreGrid)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'redirect_url' => 'nullable|string|max:255',
            'grid_span' => 'required|integer|in:1,2',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = [
            'brand_id' => $request->brand_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'redirect_url' => $request->redirect_url,
            'grid_span' => $request->grid_span,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($homeExploreGrid->image) {
                Storage::disk('public')->delete($homeExploreGrid->image);
            }
            $data['image'] = $request->file('image')->store('explore_grids', 'public');
        }

        $homeExploreGrid->update($data);

        return redirect()->route('admin.home-explore-grids.index')->with('success', 'Explore Grid item updated successfully.');
    }

    public function destroy(HomeExploreGrid $homeExploreGrid)
    {
        if ($homeExploreGrid->image) {
            Storage::disk('public')->delete($homeExploreGrid->image);
        }
        $homeExploreGrid->delete();
        return redirect()->route('admin.home-explore-grids.index')->with('success', 'Explore Grid item deleted successfully.');
    }
}
