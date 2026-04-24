<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::withCount('items')->latest()->paginate(10);
        return view('admin.flash_sales.index', compact('flashSales'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.flash_sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.discount_percentage' => 'nullable|integer|min:1|max:100',
        ]);

        $data = $request->only(['title', 'start_time', 'end_time', 'is_active']);
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('flash_sales', 'public');
        }

        $flashSale = FlashSale::create($data);

        foreach ($request->products as $pData) {
            FlashSaleProduct::create([
                'flash_sale_id' => $flashSale->id,
                'product_id' => $pData['id'],
                'discount_percentage' => $pData['discount_percentage'] ?? null,
                'sort_order' => $pData['sort_order'] ?? 0,
            ]);
        }

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale created successfully.');
    }

    public function edit(FlashSale $flashSale)
    {
        $flashSale->load('items.product');
        $products = Product::where('is_active', true)->get();
        return view('admin.flash_sales.edit', compact('flashSale', 'products'));
    }

    public function update(Request $request, FlashSale $flashSale)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'products' => 'required|array',
        ]);

        $data = $request->only(['title', 'start_time', 'end_time']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($flashSale->image) {
                Storage::disk('public')->delete($flashSale->image);
            }
            $data['image'] = $request->file('image')->store('flash_sales', 'public');
        } elseif ($request->has('remove_image')) {
            if ($flashSale->image) {
                Storage::disk('public')->delete($flashSale->image);
            }
            $data['image'] = null;
        }

        $flashSale->update($data);

        // Simple sync for pivot (delete old, add new for demo simplicity, or use syncProducts helper)
        $flashSale->items()->delete();
        foreach ($request->products as $pData) {
            FlashSaleProduct::create([
                'flash_sale_id' => $flashSale->id,
                'product_id' => $pData['id'],
                'discount_percentage' => $pData['discount_percentage'] ?? null,
                'sort_order' => $pData['sort_order'] ?? 0,
            ]);
        }

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale updated successfully.');
    }

    public function destroy(FlashSale $flashSale)
    {
        if ($flashSale->image) {
            Storage::disk('public')->delete($flashSale->image);
        }
        $flashSale->delete();
        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale deleted successfully.');
    }
}
