<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('location')->orderBy('sort_order')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'location' => 'required|string|in:home_top,jewellery_top,home_first_sale,jewellery_first_sale',
            'type' => 'required|string|in:studio,jewellery',
            'sort_order' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'image' => $imagePath,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'link' => $request->link,
            'location' => $request->location,
            'type' => $request->type,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image',
            'location' => 'required|string|in:home_top,jewellery_top,home_first_sale,jewellery_first_sale',
            'type' => 'required|string|in:studio,jewellery',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'link' => $request->link,
            'location' => $request->location,
            'type' => $request->type,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        } elseif ($request->has('remove_image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = null;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
