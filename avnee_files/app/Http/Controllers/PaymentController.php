<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    private ?Api $razorpay = null;
    private string $razorpayKeyId = '';

    public function __construct()
    {
        [$this->razorpayKeyId, $secret] = $this->resolveRazorpayCredentials();

        if ($this->razorpayKeyId !== '' && $secret !== '') {
            $this->razorpay = new Api($this->razorpayKeyId, $secret);
        }
    }

    private function resolveRazorpayCredentials(): array
    {
        $settings = Setting::whereIn('key', ['razorpay_key_id', 'razorpay_key_secret'])->pluck('value', 'key');

        $keyId = trim((string) (
            $settings['razorpay_key_id']
            ?? config('services.razorpay.key')
            ?? ''
        ));

        $secret = trim((string) (
            $settings['razorpay_key_secret']
            ?? config('services.razorpay.secret')
            ?? ''
        ));

        return [$keyId, $secret];
    }

    private function ensureRazorpayConfigured(): void
    {
        if (!$this->razorpay) {
            throw ValidationException::withMessages([
                'payment' => ['Online payment is temporarily unavailable. Please try again later.'],
            ]);
        }
    }

    /**
     * Show payment page for a product
     */
    public function showPaymentPage($slug)
    {
        $product = Product::where('slug', $slug)->with(['variants', 'brand', 'category'])->firstOrFail();

        return view('front.payment.checkout', compact('product'));
    }

    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request)
    {
        $this->ensureRazorpayConfigured();

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15',
            'shipping_address' => 'required|string|max:500',
            'pincode' => 'required|string|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $product->variants()->findOrFail($request->variant_id);

        $subtotal = (float) $variant->price * (int) $request->quantity;
        $shippingCost = 0.0;
        $totalAmount = $subtotal + $shippingCost;
        $amount = (int) round($totalAmount * 100); // Convert to paise
        $receipt = 'order_' . Str::random(10);

        try {
            // Create Razorpay order
            $razorpayOrder = $this->razorpay->order->create([
                'receipt' => $receipt,
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            $customerName = trim((string) $request->customer_name);
            $nameParts = preg_split('/\s+/', $customerName, 2);
            $firstName = $nameParts[0] ?? 'Customer';
            $lastName = $nameParts[1] ?? '';

            $shippingAddress = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'address' => $request->shipping_address,
                'apartment' => null,
                'city' => null,
                'state' => null,
                'pincode' => $request->pincode,
                'country' => 'India',
            ];

            // Create order in database
            $order = Order::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : $request->session()->getId(),
                'order_number' => 'AVN' . strtoupper(Str::random(8)),
                'status' => 'pending',
                'payment_method' => 'razorpay',
                'payment_status' => 'unpaid',
                'razorpay_order_id' => $razorpayOrder->id,
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $shippingAddress,
                'billing_address' => $shippingAddress,
                'notes' => $request->notes ?? null
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'product_name' => $product->name,
                'variant_details' => trim(($variant->colour ? $variant->colour . ' ' : '') . ($variant->size ?? '')) ?: null,
                'quantity' => $request->quantity,
                'price' => $variant->price,
                'total' => $variant->price * $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $amount,
                'currency' => 'INR',
                'key' => $this->razorpayKeyId,
                'name' => $product->name,
                'description' => $variant->colour ? $variant->colour . ' - ' . $variant->size : $variant->size,
                'image' => asset('storage/' . $product->image),
                'prefill' => [
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'contact' => $request->customer_phone
                ],
                'notes' => [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $variant->id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle payment success
     */
    public function paymentSuccess(Request $request)
    {
        $this->ensureRazorpayConfigured();

        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string'
        ]);

        try {
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Update order status
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if ($order) {
                $order->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'paid_at' => now()
                ]);

                // Send confirmation email
                try {
                    Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
                }

                return redirect()->route('payment.success.page', ['order_id' => $order->id])
                    ->with('success', 'Payment successful! Your order has been placed.');
            }

            return redirect()->route('home')->with('error', 'Order not found.');

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment failure
     */
    public function paymentFailure(Request $request)
    {
        $razorpayOrderId = $request->razorpay_order_id;

        // Update order status to failed
        $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'notes' => 'Payment failed: ' . ($request->error_description ?? 'Unknown error')
            ]);
        }

        return redirect()->route('home')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Show payment success page
     */
    public function showSuccessPage($order_id)
    {
        $order = Order::with(['items.product', 'items.variant'])->findOrFail($order_id);

        // Verify this order belongs to the current user or is a guest order
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('front.payment.success', compact('order'));
    }

    /**
     * Show order history
     */
    public function orderHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to view your orders.');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'items.variant'])
            ->latest()
            ->paginate(10);

        return view('front.payment.order-history', compact('orders'));
    }
}
