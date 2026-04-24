<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JustInExperience;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JustInExperienceController extends Controller
{
    public function index()
    {
        $experiences = JustInExperience::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();
        return view('admin.just_in_experiences.index', compact('experiences'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.just_in_experiences.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'button_link' => 'nullable|string',
            'image' => 'required|image',
            'sort_order' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('just_in_experiences', 'public');
        }

        JustInExperience::create($data);
        return redirect()->route('admin.just-in-experiences.index')->with('success', 'Just In experience established.');
    }

    public function edit(JustInExperience $justInExperience)
    {
        $brands = Brand::all();
        return view('admin.just_in_experiences.edit', compact('justInExperience', 'brands'));
    }

    public function update(Request $request, JustInExperience $justInExperience)
    {
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'button_link' => 'nullable|string',
            'image' => 'nullable|image',
            'sort_order' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            if ($justInExperience->image) {
                Storage::disk('public')->delete($justInExperience->image);
            }
            $data['image'] = $request->file('image')->store('just_in_experiences', 'public');
        } elseif ($request->has('remove_image')) {
            if ($justInExperience->image) {
                Storage::disk('public')->delete($justInExperience->image);
            }
            $data['image'] = null;
        }

        $justInExperience->update($data);
        return redirect()->route('admin.just-in-experiences.index')->with('success', 'Just In experience refined.');
    }

    public function destroy(JustInExperience $justInExperience)
    {
        if ($justInExperience->image) {
            Storage::disk('public')->delete($justInExperience->image);
        }
        $justInExperience->delete();
        return redirect()->route('admin.just-in-experiences.index')->with('success', 'Just In experience archived.');
    }
}
