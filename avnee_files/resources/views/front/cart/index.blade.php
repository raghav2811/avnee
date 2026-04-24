@extends('layouts.front.' . $theme)

@section('content')
@php 
    $isDark = $theme === 'jewellery'; 
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#a8998a]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $bgColor = $isDark ? 'bg-[#2B003A]' : 'bg-white';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
    $accentHoverBg = $isDark ? 'hover:bg-[#6d28d9]' : 'hover:bg-[#9a5a1f]';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-gray-50';
    
    $subtotal = 0;
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16 {{ $textColor }} font-body">
    <h1 class="font-heading text-3xl sm:text-4xl font-normal tracking-wide text-center mb-10">Your Cart</h1>
    
    @if(session('success'))
    <div class="mb-8 p-4 bg-green-100/10 border border-green-500/30 text-green-600 dark:text-green-400 rounded-sm text-sm text-center">
        {{ session('success') }}
    </div>
    @endif

    @if($cart->items->count() == 0)
    <div class="text-center py-16">
        <svg class="w-16 h-16 mx-auto {{ $mutedColor }} mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        <p class="text-xl mb-6">Your cart is currently empty.</p>
        <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="inline-block px-8 py-3 {{ $accentBg }} {{ $accentHoverBg }} text-white text-sm font-bold tracking-[0.2em] uppercase rounded-sm transition-colors">Continue Shopping</a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Cart Items List -->
        <div class="w-full lg:w-2/3">
            <div class="hidden sm:grid grid-cols-12 gap-4 pb-4 border-b {{ $borderColor }} text-sm font-semibold tracking-wider uppercase {{ $mutedColor }}">
                <div class="col-span-6">Product</div>
                <div class="col-span-3 text-center">Quantity</div>
                <div class="col-span-3 text-right">Total</div>
            </div>
            
            <div class="mt-4 space-y-6">
                @foreach($cart->items as $item)
                @php
                    $itemPrice = $item->product->price;
                    $itemTotal = $itemPrice * $item->quantity;
                    $subtotal += $itemTotal;
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 py-4 border-b {{ $borderColor }} group p-2 hover:{{ $cardBg }} transition-colors">
                    <!-- Image & Name -->
                    <div class="flex items-center gap-4 sm:w-1/2">
                        <a href="{{ route('front.product.detail', $item->product->slug ?? $item->product->id) }}" class="flex-shrink-0 w-20 sm:w-24 aspect-[3/4] overflow-hidden {{ $borderColor }} border rounded-sm">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover object-top" />
                        </a>
                        <div class="flex-1">
                            <a href="{{ route('front.product.detail', $item->product->slug ?? $item->product->id) }}" class="text-sm sm:text-base font-semibold hover:{{ $accentColor }} transition-colors block mb-1">
                                {{ $item->product->name }}
                            </a>
                            <div class="text-sm {{ $mutedColor }} space-y-1">
                                <p>₹{{ number_format($itemPrice, 2) }}</p>
                                @if($item->variant)
                                <p>Size: {{ $item->variant->size }}</p>
                                @endif
                                <!-- Mobile Only remove -->
                                <form action="{{ route('front.cart.remove', $item->id) }}" method="POST" class="sm:hidden mt-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs tracking-wider uppercase text-red-500 hover:text-red-400">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quantity & Actions -->
                    <div class="flex items-center justify-between sm:w-1/2 mt-4 sm:mt-0">
                        <div class="flex items-center border {{ $borderColor }} rounded-sm sm:mx-auto">
                            <form action="{{ route('front.cart.update', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}" />
                                <button type="submit" class="px-3 py-1 text-lg hover:{{ $accentColor }} transition-colors" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                            </form>
                            <span class="px-2 text-sm font-semibold w-8 text-center">{{ $item->quantity }}</span>
                            <form action="{{ route('front.cart.update', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}" />
                                <button type="submit" class="px-3 py-1 text-lg hover:{{ $accentColor }} transition-colors">+</button>
                            </form>
                        </div>
                        
                        <div class="text-right flex items-center gap-4">
                            <span class="font-semibold sm:text-lg">₹{{ number_format($itemTotal, 2) }}</span>
                            <!-- Desktop Only Remove -->
                            <form action="{{ route('front.cart.remove', $item->id) }}" method="POST" class="hidden sm:block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#a8998a] hover:text-red-500 transition-colors p-2" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8 flex justify-between items-center bg-gray-50/5 dark:bg-[#350047]/30 p-4 rounded-sm border {{ $borderColor }}">
                <div class="flex items-center gap-2 {{ $mutedColor }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span class="text-sm">Secure checkout</span>
                </div>
                <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="text-sm tracking-wider uppercase font-semibold {{ $accentColor }} border-b border-current hover:opacity-80 transition-opacity">Continue Shopping</a>
            </div>
        </div>
        
        <!-- Order Summary Sidebar -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-24 {{ $cardBg }} border {{ $borderColor }} p-6 sm:p-8 rounded-sm">
                <h2 class="font-heading text-xl font-medium tracking-wide border-b {{ $borderColor }} pb-4 mb-6">Order Summary</h2>
                
                <div class="space-y-4 text-sm mb-6 border-b {{ $borderColor }} pb-6">
                    <div class="flex justify-between">
                        <span class="{{ $mutedColor }}">Subtotal</span>
                        <span class="font-semibold">₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="{{ $mutedColor }}">Shipping</span>
                        <span class="font-semibold">{{ $subtotal > 1499 ? 'Free' : 'Calculated at next step' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="{{ $mutedColor }}">Tax</span>
                        <span class="font-semibold">Included</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-end mb-8">
                    <span class="text-base font-semibold tracking-wider uppercase">Total</span>
                    <span class="text-2xl font-semibold {{ $accentColor }}">₹{{ number_format($subtotal, 2) }}</span>
                </div>
                
                <a href="{{ route('front.checkout.index') }}" class="block w-full {{ $accentBg }} {{ $accentHoverBg }} text-white text-center py-4 text-sm font-bold tracking-[0.2em] uppercase rounded-sm transition-colors shadow-md">
                    Proceed to Checkout
                </a>
                
                <p class="text-xs {{ $mutedColor }} text-center mt-4">Safe & secure payments. 100% authentic products.</p>
                <div class="flex justify-center gap-2 mt-4 opacity-70">
                    <div class="w-8 h-5 bg-white rounded-sm"></div>
                    <div class="w-8 h-5 bg-white rounded-sm"></div>
                    <div class="w-8 h-5 bg-white rounded-sm"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
