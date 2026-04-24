<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;

class CheckoutPricingService
{
    public function __construct(private readonly ShiprocketService $shiprocket)
    {
    }

    public function calculateSubtotal(Cart $cart): float
    {
        return (float) collect($cart->items)->sum(function ($item) {
            return (float) $item->price * (int) $item->quantity;
        });
    }

    public function resolveCouponDiscount(?string $couponCode, float $subtotal): array
    {
        $normalizedCode = $couponCode ? trim($couponCode) : null;
        if (!$normalizedCode) {
            return ['discount' => 0.0, 'coupon_code' => null];
        }

        $coupon = Coupon::where('code', $normalizedCode)->first();
        if (!$coupon || !$coupon->isValid($subtotal)) {
            return ['discount' => 0.0, 'coupon_code' => null];
        }

        return [
            'discount' => (float) $coupon->calculateDiscount($subtotal),
            'coupon_code' => $coupon->code,
        ];
    }

    public function resolveShippingCost(string $pincode, Cart $cart, float $subtotal): float
    {
        $normalizedPincode = preg_replace('/\D+/', '', $pincode) ?? '';
        if (strlen($normalizedPincode) !== 6) {
            throw ValidationException::withMessages([
                'pincode' => ['Please enter a valid 6-digit pincode.'],
            ]);
        }

        $weight = (float) collect($cart->items)->sum(function ($item) {
            $weightGrams = (float) ($item->product->weight_grams ?? 0);
            $effectiveWeight = $weightGrams > 0 ? ($weightGrams / 1000) : 0.5;
            return $effectiveWeight * (int) $item->quantity;
        });

        if ($weight <= 0) {
            $weight = 0.5;
        }

        $details = $this->shiprocket->checkServiceability($normalizedPincode, $weight, $subtotal);
        $couriers = $details['data']['available_courier_companies'] ?? [];
        $recommended = $couriers[0] ?? null;

        if ($recommended) {
            $rate = $recommended['rate']
                ?? $recommended['freight_charge']
                ?? $recommended['courier_charge']
                ?? null;

            if (is_numeric($rate)) {
                return (float) $rate;
            }
        }

        return $this->fallbackShippingCost($subtotal);
    }

    private function fallbackShippingCost(float $subtotal): float
    {
        $settings = Setting::whereIn('key', ['default_shipping_cost', 'free_shipping_threshold'])
            ->pluck('value', 'key');

        $defaultShipping = (float) ($settings['default_shipping_cost'] ?? 0);
        $freeShippingThreshold = (float) ($settings['free_shipping_threshold'] ?? 1499);

        if ($subtotal >= $freeShippingThreshold) {
            return 0.0;
        }

        return max(0.0, $defaultShipping);
    }
}
