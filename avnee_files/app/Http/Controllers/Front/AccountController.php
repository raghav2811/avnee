<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private const RETURN_WINDOW_DAYS = 7;

    /**
     * Display the user's order history.
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('front.account.orders', compact('orders'));
    }

    /**
     * Display a specific order's details.
     */
    public function showOrder($orderNumber)
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        return view('front.account.order-show', compact('order'));
    }

    /**
     * Request a return for an order.
     */
    public function requestReturn(Request $request, $orderNumber)
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Security/Business Logic: Only delivered orders can be returned
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Only delivered orders can be returned.');
        }

        if ((string) $order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Only paid orders are eligible for return requests.');
        }

        if (in_array((string) $order->status, ['cancelled', 'returned'], true)) {
            return redirect()->back()->with('error', 'This order is not eligible for returns.');
        }

        // Only allow request if no return has been requested yet
        if ($order->return_status) {
            return redirect()->back()->with('error', 'A return has already been requested or processed for this order.');
        }

        $deliveredAt = $order->updated_at;
        if ($deliveredAt && now()->greaterThan($deliveredAt->copy()->addDays(self::RETURN_WINDOW_DAYS))) {
            return redirect()->back()->with('error', 'Return window has expired for this order.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $order->update([
            'return_status' => 'requested',
            'return_reason' => $request->reason,
            'return_requested_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Your return request has been submitted successfully.');
    }

    /**
     * Track an order status.
     * Accessible by guests as well via order number and email match.
     */
    public function trackOrder(Request $request)
    {
        $order = null;
        if ($request->has('order_number') && $request->has('email')) {
            $order = Order::where('order_number', $request->order_number)
                ->where('customer_email', $request->email)
                ->with(['items.product'])
                ->first();

            if (!$order) {
                return redirect()->route('front.track_order', ['theme' => $request->theme])->with('error', 'Order not found. Please verify your order number and email.');
            }
        }

        // Determine layout based on theme parameter
        $layout = $request->theme === 'jewellery' ? 'layouts.front.jewellery' : 'layouts.front.studio';
        $theme = $request->theme ?? 'studio';

        return view('front.account.track_order', compact('order', 'layout', 'theme'));
    }
}
