@extends('layouts.front.' . $theme)

@section('content')
@php 
    $isDark = $theme === 'jewellery'; 
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#a8998a]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-gray-50';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
    $accentHoverBg = $isDark ? 'hover:bg-[#6d28d9]' : 'hover:bg-[#9a5a1f]';
@endphp

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 {{ $textColor }} font-body text-center flex flex-col items-center">
    
    <div class="w-20 h-20 mb-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-500 dark:text-green-400">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    
    <h1 class="font-heading text-3xl sm:text-4xl font-normal tracking-wide mb-4">Thank you for your order!</h1>
    
    <p class="text-lg {{ $mutedColor }} mb-8">
        Your order <span class="font-bold {{ $textColor }}">{{ $order->order_number }}</span> has been placed successfully.
    </p>
    
    <div class="{{ $cardBg }} border {{ $borderColor }} p-6 sm:p-8 rounded-sm w-full mb-10 text-left">
        <h2 class="font-heading text-xl font-medium tracking-wide mb-4 border-b {{ $borderColor }} pb-2">Order Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <h3 class="font-semibold mb-2">Contact</h3>
                <p class="{{ $mutedColor }}">{{ $order->customer_email }}</p>
                <p class="{{ $mutedColor }}">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Shipping Address</h3>
                <p class="{{ $mutedColor }}">
                    {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                    {{ $order->shipping_address['address'] }}<br>
                    @if(!empty($order->shipping_address['apartment']))
                        {{ $order->shipping_address['apartment'] }}<br>
                    @endif
                    {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['pincode'] }}
                </p>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Payment Method</h3>
                <p class="{{ $mutedColor }}">{{ strtoupper($order->payment_method) }}</p>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Order Total</h3>
                <p class="{{ $mutedColor }} font-bold text-lg">₹{{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>
    </div>
    
    <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="inline-block px-10 py-4 {{ $accentBg }} {{ $accentHoverBg }} text-white text-sm font-bold tracking-[0.2em] uppercase rounded-sm transition-colors shadow-md">
        Continue Shopping
    </a>
</div>
@endsection
