<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceBand;
use App\Models\Brand;
use Illuminate\Http\Request;

class PriceBandController extends Controller
{
    public function index()
    {
        $bands = PriceBand::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();
        return view('admin.price_bands.index', compact('bands'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.price_bands.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'label' => 'required|string|max:50',
            'price_limit' => 'required|integer',
            'redirect_url' => 'nullable|string',
            'sort_order' => 'integer'
        ]);

        PriceBand::create($request->all());

        return redirect()->route('admin.price-bands.index')->with('success', 'Price band established.');
    }

    public function edit(PriceBand $priceBand)
    {
        $brands = Brand::all();
        return view('admin.price_bands.edit', compact('priceBand', 'brands'));
    }

    public function update(Request $request, PriceBand $priceBand)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'label' => 'required|string|max:50',
            'price_limit' => 'required|integer',
            'redirect_url' => 'nullable|string',
            'sort_order' => 'integer'
        ]);

        $priceBand->update($request->all());

        return redirect()->route('admin.price-bands.index')->with('success', 'Price band refined.');
    }

    public function destroy(PriceBand $priceBand)
    {
        $priceBand->delete();
        return redirect()->route('admin.price-bands.index')->with('success', 'Price band archived.');
    }
}
