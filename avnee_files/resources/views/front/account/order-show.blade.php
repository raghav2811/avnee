@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
@php 
    $theme = session('theme', 'studio');
    $isDark = $theme === 'jewellery'; 
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#a8998a]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-white';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 {{ $textColor }} font-body">
    <!-- Header -->
    <div class="mb-12 flex flex-col md:flex-row items-center justify-between gap-6 pb-6 border-b {{ $borderColor }}">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <a href="{{ route('front.orders.index') }}" class="text-[10px] font-black uppercase tracking-widest text-[#baa98a] hover:{{ $accentColor }} transition-colors flex items-center gap-1 group">
                    <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Order History
                </a>
            </div>
            <h1 class="font-heading text-3xl sm:text-4xl uppercase tracking-[0.2em]">Order #{{ $order->order_number }}</h1>
            <p class="text-[11px] {{ $mutedColor }} font-bold uppercase tracking-[0.4em] mt-2">Placed on {{ $order->created_at->format('F d, Y') }}</p>
        </div>
        <div class="text-center md:text-right">
            <span class="px-6 py-2 text-[10px] font-black uppercase tracking-widest rounded-full 
                {{ $order->status === 'delivered' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 
                   ($order->status === 'cancelled' ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 'bg-blue-500/10 text-blue-500 border border-blue-500/20') }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Tracking Card -->
            @if($order->tracking_number)
            <div class="{{ $accentBg }}/5 border border-{{ $accentBg }}/20 p-8 rounded-sm animate-in slide-in-from-top duration-700">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-white/10 flex items-center justify-center rounded-full border border-{{ $accentBg }}/20">
                            <span class="material-symbols-outlined text-3xl {{ $accentColor }}">local_shipping</span>
                        </div>
                        <div>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#8a7a6a]">Track Shipment</h3>
                            <p class="text-lg font-bold tracking-tight">Status: <span class="uppercase text-{{ $accentColor }}">{{ $order->status }}</span></p>
                            <p class="text-xs {{ $mutedColor }} font-semibold tracking-wide">Tracking #: {{ $order->tracking_number }}</p>
                        </div>
                    </div>
                    <a href="https://shiprocket.co/tracking/{{ $order->tracking_number }}" target="_blank" class="px-10 py-3 {{ $accentBg }} text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl rounded-sm">
                        Track Online
                    </a>
                </div>
            </div>
            @endif

            <!-- Order Items -->
            <div class="{{ $cardBg }} border {{ $borderColor }} rounded-sm shadow-xl overflow-hidden">
                <div class="p-6 bg-gray-50/5 border-b {{ $borderColor }}">
                    <h3 class="text-xs font-black uppercase tracking-[0.3em]">Items in your order</h3>
                </div>
                <div class="divide-y {{ $borderColor }}">
                    @foreach($order->items as $item)
                        <div class="p-8 flex items-center gap-8 group">
                            <div class="w-24 aspect-[3/4] flex-shrink-0 bg-gray-100 dark:bg-gray-800 rounded-sm overflow-hidden border {{ $borderColor }}">
                                <img src="{{ asset('storage/'.($item->product->image ?? 'placeholder.jpg')) }}" class="w-full h-full object-cover object-top transition duration-700 group-hover:scale-110">
                            </div>
                            <div class="flex-1 space-y-2">
                                <h4 class="text-sm font-bold uppercase tracking-tight">{{ $item->product->name }}</h4>
                                <div class="flex gap-4">
                                    <p class="text-[10px] {{ $mutedColor }} uppercase font-bold tracking-widest"><span class="mr-1 opacity-50">VARIANT:</span> {{ $item->variant->size ?? 'ONE SIZE' }}</p>
                                    <p class="text-[10px] {{ $mutedColor }} uppercase font-bold tracking-widest"><span class="mr-1 opacity-50">QTY:</span> {{ $item->quantity }}</p>
                                </div>
                                <div class="pt-4">
                                    <p class="text-sm font-bold {{ $accentColor }}">₹{{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            <div class="text-right hidden md:block">
                                <p class="text-xs {{ $mutedColor }} font-bold mb-1">Subtotal</p>
                                <p class="text-lg font-heading font-black">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Summary Footer -->
                <div class="p-8 bg-gray-50/5 border-t {{ $borderColor }} space-y-4">
                    <div class="flex justify-between text-xs font-bold {{ $mutedColor }} uppercase tracking-widest">
                        <span>Bag Total</span>
                        <span class="{{ $textColor }}">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-xs font-bold text-green-500 uppercase tracking-widest">
                        <span>Promotional Discount</span>
                        <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-xs font-bold {{ $mutedColor }} uppercase tracking-widest">
                        <span>Logistics Cost</span>
                        <span class="{{ $textColor }}">{{ $order->shipping_cost > 0 ? '₹'.number_format($order->shipping_cost) : 'Free' }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-black uppercase tracking-widest pt-4 border-t {{ $borderColor }}">
                        <span>Amount Paid</span>
                        <span class="{{ $accentColor }}">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Return Section -->
            @if($order->status === 'delivered' && !$order->return_status)
                 <div class="p-8 border border-yellow-500/20 bg-yellow-500/5 rounded-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="material-symbols-outlined text-yellow-500 text-3xl">assignment_return</span>
                        <h3 class="text-xs font-black uppercase tracking-[0.3em]">Easy Returns</h3>
                    </div>
                    <p class="text-[13px] {{ $mutedColor }} leading-relaxed mb-6 italic">Not fully satisfied? Request a return within our return window. Our logistics partner will pick it up from your address.</p>
                    <form action="{{ route('front.orders.return', $order->order_number) }}" method="POST" class="space-y-4">
                        @csrf
                        <textarea name="reason" rows="3" required placeholder="Tell us why you'd like to return these items..." class="w-full text-xs p-4 bg-transparent border {{ $borderColor }} focus:border-yellow-500 outline-none rounded-sm transition-all"></textarea>
                        <button type="submit" class="px-10 py-3 bg-black text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-yellow-600 transition-all rounded-sm shadow-xl">Request Return</button>
                    </form>
                 </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-8">
            <!-- Shipping Info -->
            <div class="{{ $cardBg }} border {{ $borderColor }} p-8 rounded-sm shadow-xl">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                    Shipping Address
                </h4>
                @if($order->shipping_address)
                    @php $ship = $order->shipping_address; @endphp
                    <div class="text-[13px] leading-relaxed space-y-1">
                        <p class="font-black uppercase tracking-widest mb-2">{{ $ship['first_name'] }} {{ $ship['last_name'] }}</p>
                        <p class="{{ $mutedColor }}">{{ $ship['address'] }}</p>
                        <p class="{{ $mutedColor }}">{{ $ship['city'] }}, {{ $ship['state'] }} - {{ $ship['pincode'] }}</p>
                        <div class="pt-4 flex items-center gap-2 text-xs font-bold">
                            <span class="material-symbols-outlined text-sm">phone</span>
                            {{ $ship['phone'] ?? $order->customer_phone }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Payment Info -->
            <div class="{{ $cardBg }} border {{ $borderColor }} p-8 rounded-sm shadow-xl">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[14px]">payments</span>
                    Payment Summary
                </h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="{{ $mutedColor }} font-bold uppercase tracking-widest">Protocol</span>
                        <span class="font-black uppercase tracking-tighter">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="{{ $mutedColor }} font-bold uppercase tracking-widest">Status</span>
                        <span class="px-3 py-1 font-black text-[9px] uppercase tracking-widest rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-600 font-black' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Help Contact -->
            <div class="p-8 flex flex-col items-center text-center">
                <p class="text-[10px] {{ $mutedColor }} font-black uppercase tracking-[0.2em] mb-4">Concierge Desk</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="w-10 h-10 border {{ $borderColor }} flex items-center justify-center rounded-full hover:{{ $accentColor }} transition-all"><span class="material-symbols-outlined text-lg">mail</span></a>
                    <a href="#" class="w-10 h-10 border {{ $borderColor }} flex items-center justify-center rounded-full hover:{{ $accentColor }} transition-all"><span class="material-symbols-outlined text-lg">call</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
