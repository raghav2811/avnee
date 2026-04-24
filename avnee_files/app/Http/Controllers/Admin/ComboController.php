<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::withCount('products')->latest()->paginate(10);
        return view('admin.combos.index', compact('combos'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.combos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
        ]);

        $data = $request->only(['title', 'price', 'original_price', 'description', 'is_active']);
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('combos', 'public');
        }

        $combo = Combo::create($data);
        $combo->products()->sync($request->products);

        return redirect()->route('admin.combos.index')->with('success', 'Combo deal created successfully.');
    }

    public function edit(Combo $combo)
    {
        $products = Product::where('is_active', true)->get();
        $selectedProducts = $combo->products->pluck('id')->toArray();
        return view('admin.combos.edit', compact('combo', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Combo $combo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
        ]);

        $data = $request->only(['title', 'price', 'original_price', 'description', 'is_active']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($combo->image) {
                Storage::disk('public')->delete($combo->image);
            }
            $data['image'] = $request->file('image')->store('combos', 'public');
        } elseif ($request->has('remove_image')) {
            if ($combo->image) {
                Storage::disk('public')->delete($combo->image);
            }
            $data['image'] = null;
        }

        $combo->update($data);
        $combo->products()->sync($request->products);

        return redirect()->route('admin.combos.index')->with('success', 'Combo deal updated successfully.');
    }

    public function destroy(Combo $combo)
    {
        if ($combo->image) {
            Storage::disk('public')->delete($combo->image);
        }
        $combo->delete();

        return redirect()->route('admin.combos.index')->with('success', 'Combo deal deleted successfully.');
    }
}
