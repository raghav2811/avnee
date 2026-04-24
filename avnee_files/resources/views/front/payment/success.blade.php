@extends('layouts.front.' . (session('theme', 'studio')))

@section('title', 'Order Confirmation - AVNEE')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
                <p class="text-lg text-gray-600 mb-6">Thank you for your purchase. Your order has been successfully placed.</p>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $order->order_number }}</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('front.product.detail', $order->items->first()->product->slug) }}"
                       class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Continue Shopping
                    </a>
                    <a href="{{ route('payment.order.history') }}"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        View Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-semibold mb-6">Order Details</h2>

            <!-- Customer Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Customer Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-medium">{{ $order->customer_name }}</p>
                        <p class="text-gray-600">{{ $order->customer_email }}</p>
                        <p class="text-gray-600">{{ $order->customer_phone }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Shipping Address</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="whitespace-pre-line">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600 mt-2">PIN: {{ $order->pincode }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Items Ordered</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-600">
                                    SKU: {{ $item->variant->sku }}
                                    @if($item->variant->colour) | {{ $item->variant->colour }} @endif
                                    @if($item->variant->size) | {{ $item->variant->size }} @endif
                                </p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">Rs{{ number_format($item->total, 2) }}</p>
                                <p class="text-sm text-gray-600">Rs{{ number_format($item->price, 2) }} each</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t pt-4">
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total Amount</span>
                    <span class="text-indigo-600">Rs{{ number_format($order->amount, 2) }}</span>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    <p>Payment Method: Razorpay</p>
                    <p>Order Status: <span class="font-medium text-green-600">{{ ucfirst($order->status) }}</span></p>
                    <p>Order Date: {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">What's Next?</h3>
            <ul class="space-y-2 text-blue-800">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>You will receive an order confirmation email at {{ $order->customer_email }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Your order will be processed within 1-2 business days</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>You can track your order status using the order number: {{ $order->order_number }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Estimated delivery: 5-7 business days (subject to location)</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
