<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ShiprocketService;
use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ShiprocketController extends Controller
{
    protected $shiprocket;

    public function __construct(ShiprocketService $shiprocket)
    {
        $this->shiprocket = $shiprocket;
    }

    /**
     * Get shipping rates and ETAs based on pincode
     */
    public function getShippingDetails(Request $request)
    {
        $request->validate(['pincode' => 'required|string']);
        $normalizedPincode = preg_replace('/\D+/', '', (string) $request->pincode) ?? '';
        if (strlen($normalizedPincode) !== 6) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid 6-digit pincode']);
        }

        // Get total weight from cart
        $cart = $this->getCart()->load('items.product');
        $weight = collect($cart->items)->sum(function($item) {
            $weightGrams = (float) ($item->product->weight_grams ?? 0);
            $effectiveWeight = $weightGrams > 0 ? ($weightGrams / 1000) : 0.5;
            return $effectiveWeight * $item->quantity;
        });

        $subtotal = collect($cart->items)->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $details = $this->shiprocket->checkServiceability($normalizedPincode, $weight, $subtotal);

        // Get the cheapest/recommended courier
        $recommendation = $details['data']['available_courier_companies'][0] ?? null;
        if ($recommendation) {
            $rate = $recommendation['rate']
                ?? $recommendation['freight_charge']
                ?? $recommendation['courier_charge']
                ?? null;

            if (is_numeric($rate)) {
                return response()->json([
                    'success' => true,
                    'shipping_cost' => (float) $rate,
                    'etd' => $recommendation['etd'] ?? '3-5 days',
                    'courier' => $recommendation['courier_name'] ?? 'Standard',
                ]);
            }
        }

        // Fallback when courier API is unavailable or returns no options.
        $settings = Setting::whereIn('key', ['default_shipping_cost', 'free_shipping_threshold'])
            ->pluck('value', 'key');
        $defaultShipping = (float) ($settings['default_shipping_cost'] ?? 0);
        $freeShippingThreshold = (float) ($settings['free_shipping_threshold'] ?? 1499);
        $fallbackShipping = $subtotal >= $freeShippingThreshold ? 0.0 : max(0.0, $defaultShipping);

        return response()->json([
            'success' => true,
            'shipping_cost' => $fallbackShipping,
            'etd' => '3-7 days',
            'courier' => 'Standard'
        ]);
    }

    protected function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }
}
