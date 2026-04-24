<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandExperience;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandExperienceController extends Controller
{
    public function index()
    {
        $experiences = BrandExperience::with('brand')->orderBy('sort_order')->get();
        $studioExperiences = $experiences->where('brand_id', 1);
        $jewelExperiences = $experiences->where('brand_id', 2);
        return view('admin.brand_experiences.index', compact('studioExperiences', 'jewelExperiences'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.brand_experiences.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'layout_type' => 'required|string',
            'title' => 'required|string|max:255',
            'content_title' => 'nullable|string|max:255',
            'content_description' => 'nullable|string',
            'image_1' => 'nullable|file|mimetypes:image/*,video/mp4,video/quicktime|max:10240',
            'image_2' => 'nullable|image|max:5120',
            'image_3' => 'nullable|image|max:5120',
            'image_4' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['image_1', 'image_2', 'image_3', 'image_4']);
        $data['is_active'] = $request->has('is_active');

        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $img) {
            if ($request->hasFile($img)) {
                $data[$img] = $request->file($img)->store('experiences', 'public');
            }
        }

        BrandExperience::create($data);

        return redirect()->route('admin.brand-experiences.index')->with('success', 'Experience created.');
    }

    public function edit(BrandExperience $brandExperience)
    {
        $brands = Brand::all();
        return view('admin.brand_experiences.edit', compact('brandExperience', 'brands'));
    }

    public function update(Request $request, BrandExperience $brandExperience)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'layout_type' => 'required|string',
            'title' => 'required|string|max:255',
            'image_1' => 'nullable|file|mimetypes:image/*,video/mp4,video/quicktime|max:10240',
            'image_2' => 'nullable|image|max:5120',
            'image_3' => 'nullable|image|max:5120',
            'image_4' => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['image_1', 'image_2', 'image_3', 'image_4']);
        $data['is_active'] = $request->has('is_active');

        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $img) {
            if ($request->hasFile($img)) {
                if ($brandExperience->$img) {
                    Storage::disk('public')->delete($brandExperience->$img);
                }
                $data[$img] = $request->file($img)->store('experiences', 'public');
            } elseif ($request->has('remove_' . $img)) {
                if ($brandExperience->$img) {
                    Storage::disk('public')->delete($brandExperience->$img);
                }
                $data[$img] = null;
            }
        }

        $brandExperience->update($data);

        return redirect()->route('admin.brand-experiences.index')->with('success', 'Experience updated.');
    }

    public function destroy(BrandExperience $brandExperience)
    {
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $img) {
            if ($brandExperience->$img) {
                Storage::disk('public')->delete($brandExperience->$img);
            }
        }
        $brandExperience->delete();
        return redirect()->route('admin.brand-experiences.index')->with('success', 'Experience deleted.');
    }
}
