@extends('layouts.front.' . ($theme ?? 'studio'))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-500';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-white/5' : 'bg-white';
    $lineColor = $isDark ? 'border-white/10' : 'border-black/5';
@endphp

<div class="min-h-screen py-20 px-4 {{ $isDark ? 'bg-[#0a050a]' : 'bg-gray-50' }}">
    <div class="max-w-[800px] mx-auto">
        <div class="flex items-center justify-between mb-16 pb-6 border-b {{ $lineColor }}">
            <div>
                <h1 class="text-3xl font-heading font-normal {{ $textColor }} tracking-[.2em] uppercase mb-1">Order Summary</h1>
                <p class="text-[10px] {{ $mutedColor }} font-black uppercase tracking-[.4em]">Tracking #{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('front.track_order', ['theme' => $isDark ? 'jewellery' : 'studio']) }}" class="text-[10px] {{ $mutedColor }} font-black uppercase tracking-[.3em] flex items-center gap-2 hover:{{ $textColor }} transition-colors">
                <span class="material-symbols-outlined text-xs">arrow_back</span> Track New Order
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Order Status Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="backdrop-blur-xl {{ $isDark ? 'bg-white/5' : 'bg-white' }} p-10 rounded-[2px] border {{ $lineColor }} shadow-xl">
                    <div class="flex items-center justify-between mb-12">
                        <span class="text-[10px] font-black uppercase tracking-[.4em] {{ $mutedColor }}">Status Cycle</span>
                        <span class="px-5 py-2 {{ $isDark ? 'bg-white/10' : 'bg-black/5' }} rounded-full text-[9px] font-black uppercase tracking-[.3em] {{ $textColor }}">{{ $order->status }}</span>
                    </div>

                    {{-- Visual Luxury Tracker --}}
                    <div class="relative flex justify-between items-center mb-16">
                        <div class="absolute left-0 right-0 h-[1.5px] {{ $isDark ? 'bg-white/10' : 'bg-black/5' }} top-[22px]"></div>
                        @php
                            $stages = [
                                'pending' => ['label' => 'Received', 'icon' => 'inventory_2', 'order' => 1],
                                'processing' => ['label' => 'Packaging', 'icon' => 'inventory', 'order' => 2],
                                'shipped' => ['label' => 'Airborne', 'icon' => 'local_shipping', 'order' => 3],
                                'delivered' => ['label' => 'Received', 'icon' => 'home_pin', 'order' => 4],
                            ];
                            $currentOrder = $stages[$order->status]['order'] ?? 1;
                        @endphp

                        @foreach($stages as $status => $stage)
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full border transition-all duration-700 {{ $currentOrder >= $stage['order'] ? 'bg-black text-white border-black shadow-lg scale-110' : ($isDark ? 'bg-gray-800 text-gray-400 border-gray-700' : 'bg-gray-100 text-gray-300 border-gray-200') }}">
                                <span class="material-symbols-outlined text-lg">{{ $stage['icon'] }}</span>
                            </div>
                            <span class="mt-4 text-[9px] font-black uppercase tracking-[.3em] {{ $currentOrder >= $stage['order'] ? $textColor : $mutedColor }}">{{ $stage['label'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-6 pt-10 border-t {{ $lineColor }}">
                         <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-{{ $isDark ? 'white/5' : 'gray-100' }} border {{ $lineColor }}">
                                <span class="material-symbols-outlined text-sm {{ $accentColor }}">local_shipping</span>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-[.2em] {{ $textColor }} mb-1">Standard Logistics</h4>
                                <p class="text-[11px] {{ $mutedColor }} tracking-widest leading-relaxed italic">Dispatched within 24 hours of confirmation. Delivery expected in 4-6 business days.</p>
                            </div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Client Info Cards -->
            <div class="space-y-8">
                <div class="backdrop-blur-xl {{ $isDark ? 'bg-white/5' : 'bg-white' }} p-8 border {{ $lineColor }} shadow-lg">
                    <h3 class="text-[10px] font-black uppercase tracking-[.4em] {{ $mutedColor }} mb-6 pb-3 border-b {{ $lineColor }}">Client Profile</h3>
                    <div class="space-y-4">
                        <p class="text-xs font-bold {{ $textColor }} tracking-widest">{{ $order->shipping_address['first_name'] ?? 'Guest' }} {{ $order->shipping_address['last_name'] ?? '' }}</p>
                        <p class="text-[11px] {{ $mutedColor }} tracking-widest">{{ $order->customer_email }}</p>
                        <p class="text-[11px] {{ $mutedColor }} tracking-widest italic">{{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="backdrop-blur-xl {{ $isDark ? 'bg-white/5' : 'bg-white' }} p-8 border {{ $lineColor }} shadow-lg">
                    <h3 class="text-[10px] font-black uppercase tracking-[.4em] {{ $mutedColor }} mb-6 pb-3 border-b {{ $lineColor }}">Financials</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between text-xs tracking-wider">
                            <span class="{{ $mutedColor }}">Value</span>
                            <span class="font-bold {{ $textColor }}">₹{{ number_format($order->total_amount) }}</span>
                        </div>
                        <div class="flex justify-between text-xs tracking-wider">
                            <span class="{{ $mutedColor }}">Payment</span>
                            <span class="font-black {{ $accentColor }} uppercase">{{ $order->payment_method }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="backdrop-blur-xl {{ $isDark ? 'bg-white/5' : 'bg-white' }} p-10 rounded-[2px] border {{ $lineColor }} shadow-2xl">
            <h3 class="text-[10px] font-black uppercase tracking-[.5em] {{ $mutedColor }} mb-10 pb-4 border-b {{ $lineColor }}">Manifest Content</h3>
            <div class="space-y-8">
                @foreach($order->items as $item)
                <div class="flex items-center gap-8 group">
                    <div class="w-20 h-28 bg-black/5 overflow-hidden rounded-[2px] border {{ $lineColor }}">
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover transition-transform group-hover:scale-105 duration-700">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold {{ $textColor }} tracking-wide uppercase mb-2">{{ $item->product->name }}</h4>
                        <div class="flex items-center gap-6">
                            <span class="text-[10px] {{ $mutedColor }} font-bold uppercase tracking-widest">Qty: {{ $item->quantity }}</span>
                            <span class="text-[10px] {{ $accentColor }} font-black uppercase tracking-widest">₹{{ number_format($item->price) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
