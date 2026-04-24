<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Razorpay\Api\Api;
use App\Models\Setting;
use App\Services\CheckoutPricingService;
use App\Services\OrderPlacementService;
use App\Services\ShiprocketService;

class CheckoutController extends Controller
{
    private ?Api $razorpay = null;
    private string $razorpayKeyId = '';
    protected $shiprocket;
    private CheckoutPricingService $pricingService;
    private OrderPlacementService $orderPlacementService;

    public function __construct(
        ShiprocketService $shiprocket,
        CheckoutPricingService $pricingService,
        OrderPlacementService $orderPlacementService
    )
    {
        [$this->razorpayKeyId, $razorpaySecret] = $this->resolveRazorpayCredentials();

        if ($this->razorpayKeyId !== '' && $razorpaySecret !== '') {
            $this->razorpay = new Api($this->razorpayKeyId, $razorpaySecret);
        }

        $this->shiprocket = $shiprocket;
        $this->pricingService = $pricingService;
        $this->orderPlacementService = $orderPlacementService;
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
                'payment_method' => ['Online payments are temporarily unavailable. Please contact support.'],
            ]);
        }
    }

    private function isCodEnabled(): bool
    {
        return (string) (Setting::where('key', 'is_cod_enabled')->value('value') ?? '1') === '1';
    }
    /**
     * Get or create the active cart
     */
    protected function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        session()->start();
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }

    /**
     * Display the checkout page
     */
    public function index()
    {
        if (Auth::check() && (bool) Auth::user()->is_blocked) {
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Your account is currently blocked. Please contact support.',
            ]);
        }

        $cart = $this->getCart()->load('items.product', 'items.variant');

        if ($cart->items->isEmpty()) {
            return redirect()->route('front.cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->pricingService->calculateSubtotal($cart);
        $couponResolution = $this->pricingService->resolveCouponDiscount(session('applied_coupon'), $subtotal);
        $discount = $couponResolution['discount'];
        $couponCode = $couponResolution['coupon_code'];

        if (!$couponCode && session()->has('applied_coupon')) {
            session()->forget(['applied_coupon', 'coupon_discount']);
        }

        $theme = session('theme', 'studio');
        $isCodEnabled = $this->isCodEnabled();
        $isRazorpayAvailable = $this->razorpay !== null;

        if (!$isCodEnabled && !$isRazorpayAvailable) {
            return redirect()->route('front.cart.index')->with('error', 'No payment method is currently available. Please contact support.');
        }

        return view('front.checkout.index', compact('cart', 'theme', 'discount', 'couponCode', 'isCodEnabled', 'isRazorpayAvailable'));
    }

    /**
     * Apply a coupon to the checkout
     */
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cart = $this->getCart();
        $subtotal = $this->pricingService->calculateSubtotal($cart);

        $coupon = \App\Models\Coupon::where('code', $request->code)->where('status', true)->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        if (!$coupon->isValid($subtotal)) {
            if ($subtotal < $coupon->min_order_amount) {
                return back()->with('error', 'Minimum order amount for this coupon is ₹' . number_format($coupon->min_order_amount, 2));
            }
            return back()->with('error', 'This coupon is expired or has reached its usage limit.');
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session([
            'applied_coupon' => $coupon->code,
            'coupon_discount' => $discount
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    /**
     * Remove the applied coupon
     */
    public function removeCoupon()
    {
        session()->forget(['applied_coupon', 'coupon_discount']);
        return back()->with('success', 'Coupon removed.');
    }

    /**
     * Process checkout form and create order
     */
    public function process(Request $request)
    {
        if (Auth::check() && (bool) Auth::user()->is_blocked) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => false,
                'error' => 'Your account is currently blocked. Please contact support.',
            ], 403);
        }

        $idempotencyKey = trim((string) ($request->header('X-Idempotency-Key') ?? $request->input('idempotency_key', '')));
        $idempotencyOwner = Auth::check() ? ('user:' . Auth::id()) : ('session:' . session()->getId());
        $idempotencyCacheKey = $idempotencyKey !== ''
            ? ('checkout:idempotency:' . sha1($idempotencyOwner . '|' . $idempotencyKey))
            : null;

        if ($idempotencyCacheKey) {
            $existingOrderNumber = Cache::get($idempotencyCacheKey);
            if (is_string($existingOrderNumber) && $existingOrderNumber !== '') {
                $existingOrder = Order::where('order_number', $existingOrderNumber)->first();
                if ($existingOrder) {
                    if ($existingOrder->payment_method === 'razorpay') {
                        return response()->json([
                            'success' => true,
                            'payment_needed' => true,
                            'razorpay_order_id' => $existingOrder->razorpay_order_id,
                            'amount' => (float) $existingOrder->total_amount * 100,
                            'name' => 'AVNEE COLLECTIONS',
                            'description' => 'Order ' . $existingOrder->order_number,
                            'order_number' => $existingOrder->order_number,
                            'key' => $this->razorpayKeyId,
                            'customer' => [
                                'name' => trim((string) (($existingOrder->shipping_address['first_name'] ?? '') . ' ' . ($existingOrder->shipping_address['last_name'] ?? ''))),
                                'email' => $existingOrder->customer_email,
                                'contact' => $existingOrder->customer_phone,
                            ],
                        ]);
                    }

                    return response()->json([
                        'success' => true,
                        'payment_needed' => false,
                        'redirect_url' => route('front.checkout.success', $existingOrder->order_number),
                    ]);
                }
            }
        }

        $cart = $this->getCart()->load('items.product', 'items.variant');

        if ($cart->items->isEmpty()) {
            return redirect()->route('front.cart.index');
        }

        $isCodEnabled = $this->isCodEnabled();
        $isRazorpayAvailable = $this->razorpay !== null;
        $allowedPaymentMethods = [];

        if ($isRazorpayAvailable) {
            $allowedPaymentMethods[] = 'razorpay';
        }

        if ($isCodEnabled) {
            $allowedPaymentMethods[] = 'cod';
        }

        if (empty($allowedPaymentMethods)) {
            return response()->json([
                'success' => false,
                'message' => 'No payment method is currently available. Please contact support.',
            ], 422);
        }

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string',
            'payment_method' => ['required', Rule::in($allowedPaymentMethods)],
            'shipping_cost' => 'nullable|numeric'
        ]);

        if ($request->payment_method === 'cod') {
            if (!$isCodEnabled) {
                return response()->json(['success' => false, 'error' => 'Cash on Delivery is currently disabled.'], 422);
            }
        }

        try {
            $subtotal = $this->pricingService->calculateSubtotal($cart);
            $couponResolution = $this->pricingService->resolveCouponDiscount(session('applied_coupon'), $subtotal);
            $discount = $couponResolution['discount'];
            $couponCode = $couponResolution['coupon_code'];

            if (!$couponCode && session()->has('applied_coupon')) {
                session()->forget(['applied_coupon', 'coupon_discount']);
            }

            // Always compute shipping server-side to prevent client-side price tampering.
            $shipping = $this->pricingService->resolveShippingCost($request->pincode, $cart, $subtotal);
            $total = ($subtotal - $discount) + $shipping;

            $order = $this->orderPlacementService->createPendingOrder(
                $request,
                $cart,
                $subtotal,
                $discount,
                $couponCode,
                $shipping,
                $total
            );

            if ($request->payment_method === 'razorpay') {
                $this->ensureRazorpayConfigured();

                try {
                    // Create Razorpay Order
                    $razorpayAmount = (int) round($total * 100);
                    $razorpayOrder = $this->razorpay->order->create([
                        'receipt'         => $order->order_number,
                        'amount'          => $razorpayAmount, // amount in paise
                        'currency'        => 'INR'
                    ]);
                } catch (\Throwable $paymentError) {
                    Log::error('Razorpay order creation failed: ' . $paymentError->getMessage(), [
                        'order_number' => $order->order_number,
                        'user_id' => Auth::id(),
                    ]);

                    $isCodEnabled = Setting::where('key', 'is_cod_enabled')->value('value') == '1';
                    $paymentMessage = $isCodEnabled
                        ? 'Online payment is temporarily unavailable. Please try Cash on Delivery or retry later.'
                        : 'Online payment is temporarily unavailable. Please retry after some time.';

                    throw ValidationException::withMessages([
                        'payment_method' => [$paymentMessage],
                    ]);
                }

                $order->update(['razorpay_order_id' => $razorpayOrder['id']]);
                if ($idempotencyCacheKey) {
                    Cache::put($idempotencyCacheKey, $order->order_number, now()->addMinutes(15));
                }

                return response()->json([
                    'success' => true,
                    'payment_needed' => true,
                    'razorpay_order_id' => $razorpayOrder['id'],
                    'amount' => $razorpayAmount,
                    'name' => 'AVNEE COLLECTIONS',
                    'description' => 'Order ' . $order->order_number,
                    'order_number' => $order->order_number,
                    'key' => $this->razorpayKeyId,
                    'customer' => [
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'contact' => $request->phone
                    ]
                ]);
            }

            $this->orderPlacementService->finalizeCodOrder($order, $cart);
            if ($idempotencyCacheKey) {
                Cache::put($idempotencyCacheKey, $order->order_number, now()->addMinutes(15));
            }

            // Send Confirmation Email for COD
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            // Push to Shiprocket
            try {
                $this->shiprocket->createOrder($order->load('items'));
            } catch (\Throwable $e) {
                // Don't fail customer flow if courier API is temporarily down.
                Log::error('Shiprocket order push failed: ' . $e->getMessage(), ['order_number' => $order->order_number]);
            }

            return response()->json([
                'success' => true,
                'payment_needed' => false,
                'redirect_url' => route('front.checkout.success', $order->order_number)
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Checkout process failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to place order right now. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify Razorpay payment
     */
    public function razorpayVerify(Request $request)
    {
        if (Auth::check() && (bool) Auth::user()->is_blocked) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => false,
                'error' => 'Your account is currently blocked. Please contact support.',
            ], 403);
        }

        $request->validate([
            'razorpay_signature' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'order_number' => 'required|string',
        ]);

        $signature = $request->razorpay_signature;
        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;
        $orderNumber = $request->order_number;

        try {
            $this->ensureRazorpayConfigured();

            $attributes = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            $order = Order::where('razorpay_order_id', $orderId)
                ->where('order_number', $orderNumber)
                ->with('items.variant')
                ->firstOrFail();

            if ((string) $order->payment_status === 'paid') {
                if ((string) $order->razorpay_payment_id === (string) $paymentId) {
                    return response()->json(['success' => true]);
                }

                return response()->json(['success' => false, 'error' => 'Order already paid.'], 409);
            }

            if (Auth::check()) {
                if ((int) $order->user_id !== (int) Auth::id()) {
                    return response()->json(['success' => false, 'error' => 'Unauthorized order access.'], 403);
                }
            } elseif ($order->session_id !== session()->getId()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized order access.'], 403);
            }

            $cart = $this->getCart();
            $this->orderPlacementService->finalizePaidOrder($order, $cart, $paymentId);

            // Send Confirmation Email for Razorpay
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            // Push to Shiprocket
            try {
                $this->shiprocket->createOrder($order);
            } catch (\Throwable $e) {
                Log::error('Shiprocket order push failed: ' . $e->getMessage(), ['order_number' => $order->order_number]);
            }

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Razorpay verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Payment verification failed. Please contact support.'], 422);
        }
    }

    /**
     * Display order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where(function($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('session_id', session()->getId());
                }
            })
            ->with('items')
            ->firstOrFail();

        $theme = session('theme', 'studio');
        return view('front.checkout.success', compact('order', 'theme'));
    }
}
