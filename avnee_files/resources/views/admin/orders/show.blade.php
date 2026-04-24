<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Order Details: {{ $order->order_number }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.orders.invoice', $order) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <span class="material-symbols-outlined text-sm mr-2">download</span>
                    Download Invoice
                </a>
                <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    &larr; Back to Orders
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Main Order Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Items Table -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Order Items</h3>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Details</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Price</th>
                                    <th class="px-4 py-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center">
                                                @if($item->product && $item->product->images->count() > 0)
                                                    <img src="{{ Storage::url($item->product->images->first()->path) }}" alt="{{ $item->product_name }}" class="w-10 h-10 object-cover rounded mr-3">
                                                @endif
                                                <div class="font-medium text-gray-900 dark:text-white">
                                                    {{ $item->product_name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-xs">
                                            {{ $item->variant_details }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            ₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-4 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                            ₹{{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right font-medium">Subtotal</td>
                                    <td class="px-4 py-3 text-right font-semibold">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->coupon_code)
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-right font-medium text-green-600 dark:text-green-400">Coupon ({{ $order->coupon_code }})</td>
                                        <td class="px-4 py-3 text-right font-semibold text-green-600 dark:text-green-400">-₹{{ number_format($order->discount_amount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right font-medium">Shipping</td>
                                    <td class="px-4 py-3 text-right font-semibold">₹{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr class="bg-indigo-50 dark:bg-indigo-900/20">
                                    <td colspan="4" class="px-4 py-3 text-right font-bold text-lg text-indigo-700 dark:text-indigo-300">Total</td>
                                    <td class="px-4 py-3 text-right font-bold text-lg text-indigo-700 dark:text-indigo-300">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Customer & Address Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-semibold uppercase text-gray-400 dark:text-gray-500 mb-4 tracking-wider">Customer Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Name</p>
                                <p class="text-sm font-medium">{{ ($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-medium">{{ $order->customer_email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Phone</p>
                                <p class="text-sm font-medium">{{ $order->customer_phone }}</p>
                            </div>
                            @if($order->user)
                                <div>
                                    <p class="text-xs text-gray-500">User Account</p>
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">#{{ $order->user->id }} {{ $order->user->name }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-semibold uppercase text-gray-400 dark:text-gray-500 mb-4 tracking-wider">Shipping Address</h3>
                        <div class="text-sm space-y-1">
                            <p>{{ ($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '') }}</p>
                            <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                            @if(!empty($order->shipping_address['apartment']))
                                <p>{{ $order->shipping_address['apartment'] }}</p>
                            @endif
                            <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['pincode'] ?? '' }}</p>
                            <p>{{ $order->shipping_address['country'] ?? 'India' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Status Update Card -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-4">Manage Order</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label for="status" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Order Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label for="payment_status" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Update Order
                        </button>
                    </form>
                </div>

                <!-- Payment Details Card -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-semibold uppercase text-gray-400 dark:text-gray-500 mb-4 tracking-wider">Payment Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs text-gray-500">Method:</span>
                            <span class="text-sm font-medium uppercase">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-gray-500">Status:</span>
                            <span class="text-sm font-semibold capitalize {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-500' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        @if($order->payment_method === 'razorpay')
                            <div class="pt-2 border-t dark:border-gray-700 space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500">Razorpay Order ID</p>
                                    <p class="text-[10px] font-mono whitespace-nowrap overflow-x-auto">{{ $order->razorpay_order_id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Payment ID</p>
                                    <p class="text-[10px] font-mono whitespace-nowrap overflow-x-auto">{{ $order->razorpay_payment_id ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Internal Notes (Optional placeholder) -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg text-xs text-gray-500">
                    <p class="mb-2 uppercase font-semibold text-gray-400">Merchant Notes</p>
                    <p>{{ $order->notes ?? 'No internal notes found for this order.' }}</p>
                </div>
            </div>

        </div>

        @if($order->return_status)
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-orange-200 dark:border-orange-900/50 overflow-hidden">
                <div class="px-6 py-4 bg-orange-50 dark:bg-orange-900/20 border-b border-orange-100 dark:border-orange-900/50">
                    <h3 class="text-lg font-bold text-orange-900 dark:text-orange-300 flex items-center">
                        <span class="material-symbols-outlined mr-2">assignment_return</span>
                        Return Request Management
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Request Details</p>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Status:</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    {{ ucfirst($order->return_status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Reason for Return:</span>
                                <p class="mt-1 p-3 bg-gray-50 dark:bg-gray-900 rounded text-sm text-gray-700 dark:text-gray-300 italic">
                                    "{{ $order->return_reason }}"
                                </p>
                            </div>
                            @if($order->refund_amount > 0)
                                <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-100 dark:border-green-900/50">
                                    <span class="text-sm font-bold text-green-800 dark:text-green-300">Refunded Amount:</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">₹{{ number_format($order->refund_amount, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-4">Process Action</p>
                        <form action="{{ route('admin.orders.return-status', $order) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update Status</label>
                                <select name="return_status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="approved" {{ $order->return_status === 'approved' ? 'selected' : '' }}>Approve Request</option>
                                    <option value="rejected" {{ $order->return_status === 'rejected' ? 'selected' : '' }}>Reject Request</option>
                                    <option value="completed" {{ $order->return_status === 'completed' ? 'selected' : '' }}>Mark as Completed (Refunded)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Refund Amount (Optional)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">₹</span>
                                    <input type="number" name="refund_amount" step="0.01" value="{{ $order->refund_amount ?? $order->total_amount }}"
                                        class="w-full pl-7 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Internal Notes</label>
                                <textarea name="return_notes" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Add any internal processing notes here...">{{ $order->return_notes }}</textarea>
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Return Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
