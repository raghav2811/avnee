<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderPlacementService
{
    public function createPendingOrder(
        Request $request,
        Cart $cart,
        float $subtotal,
        float $discount,
        ?string $couponCode,
        float $shipping,
        float $total
    ): Order {
        return DB::transaction(function () use ($request, $cart, $subtotal, $discount, $couponCode, $shipping, $total) {
            $createdOrder = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : session()->getId(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'coupon_code' => $couponCode,
                'shipping_cost' => $shipping,
                'total_amount' => $total,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                    'country' => 'India',
                ],
                'billing_address' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                    'country' => 'India',
                ],
            ]);

            foreach ($cart->items as $item) {
                $variantDetails = $item->variant ? 'Size: ' . $item->variant->size : null;

                OrderItem::create([
                    'order_id' => $createdOrder->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name,
                    'variant_details' => $variantDetails,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            return $createdOrder->load('items.variant');
        });
    }

    public function finalizeCodOrder(Order $order, Cart $cart): void
    {
        DB::transaction(function () use ($order, $cart) {
            $this->decrementOrderStockOrFail($order->load('items.variant'));
            $order->update(['status' => 'processing']);

            if ($order->coupon_code) {
                Coupon::where('code', $order->coupon_code)->increment('used_count');
            }

            $cart->items()->delete();
            session()->forget(['applied_coupon', 'coupon_discount']);
        });
    }

    public function finalizePaidOrder(Order $order, Cart $cart, string $paymentId): void
    {
        DB::transaction(function () use ($order, $cart, $paymentId) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'razorpay_payment_id' => $paymentId,
            ]);

            if ($order->coupon_code) {
                Coupon::where('code', $order->coupon_code)->increment('used_count');
            }

            $this->decrementOrderStockOrFail($order->load('items.variant'));

            $cart->items()->delete();
            session()->forget(['applied_coupon', 'coupon_discount']);
        });
    }

    private function decrementOrderStockOrFail(Order $order): void
    {
        foreach ($order->items as $orderItem) {
            if (!$orderItem->variant_id) {
                continue;
            }

            $updatedRows = ProductVariant::where('id', $orderItem->variant_id)
                ->where('stock', '>=', $orderItem->quantity)
                ->decrement('stock', $orderItem->quantity);

            if ($updatedRows === 0) {
                throw ValidationException::withMessages([
                    'stock' => ["Insufficient stock for product: {$orderItem->product_name}"],
                ]);
            }
        }
    }
}
