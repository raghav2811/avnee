<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'items.variant', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:unpaid,paid,failed,refunded'
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    /**
     * Download order invoice PDF.
     */
    /**
     * Update return status for an order.
     */
    public function updateReturnStatus(Request $request, Order $order)
    {
        $request->validate([
            'return_status' => 'required|in:approved,rejected,completed',
            'refund_amount' => 'nullable|numeric|min:0|max:' . $order->total_amount,
            'return_notes' => 'nullable|string',
        ]);

        $currentReturnStatus = (string) ($order->return_status ?? '');
        if ($currentReturnStatus === '') {
            return redirect()->back()->with('error', 'No return request exists for this order.');
        }

        if (in_array($currentReturnStatus, ['rejected', 'completed'], true)) {
            return redirect()->back()->with('error', 'This return request is already finalized.');
        }

        if ((string) $request->return_status === 'completed' && $currentReturnStatus !== 'approved') {
            return redirect()->back()->with('error', 'Return must be approved before completion.');
        }

        if ((string) $request->return_status === 'completed' && (string) $order->payment_status !== 'paid' && !$request->filled('refund_amount')) {
            return redirect()->back()->with('error', 'Provide a refund amount before completing this return.');
        }

        $data = [
            'return_status' => $request->return_status,
            'return_notes' => $request->return_notes,
        ];

        if ($request->filled('refund_amount')) {
            $data['refund_amount'] = $request->refund_amount;
            // If it's a full or partial refund, update payment status
            if ($request->return_status === 'completed') {
                $order->update(['payment_status' => 'refunded']);
            }
        }

        if ((string) $request->return_status === 'completed') {
            $data['return_completed_at'] = now();
            if ((string) $order->payment_status === 'paid') {
                $data['payment_status'] = 'refunded';
            }
        }

        $order->update($data);

        return redirect()->back()->with('success', 'Return status updated successfully.');
    }

    public function downloadInvoice(Order $order)
    {
        $order->load(['items.product', 'items.variant']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download('Invoice-' . $order->order_number . '.pdf');
    }
}
