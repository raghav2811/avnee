@extends($layout ?? 'layouts.front.studio')

@section('title', 'Track Your Order')

@section('content')
@php
    $isJewellery = isset($theme) && $theme === 'jewellery';
    $primaryBg = $isJewellery ? 'bg-[#2B003A]' : 'bg-[#F8C8DC]';
    $cardBg = $isJewellery ? 'bg-[#350047]/80' : 'bg-white/80';
    $textTitle = $isJewellery ? 'text-[#d4af37]' : 'text-mulberry';
    $textBody = $isJewellery ? 'text-[#e9d5ff]' : 'text-gray-900';
    $accentColor = $isJewellery ? 'bg-[#d4af37]' : 'bg-mulberry';
    $accentText = $isJewellery ? 'text-[#1a0023]' : 'text-pastel-pink';
    $inputBg = $isJewellery ? 'bg-[#230030]/50' : 'bg-[#F8C8DC]/20';
    $inputBorder = $isJewellery ? 'border-[#d4af37]/20' : 'border-mulberry/10';
    $inputFocus = $isJewellery ? 'focus:ring-[#d4af37]/30' : 'focus:ring-mulberry/30';
@endphp

<div class="{{ $primaryBg }} min-h-screen py-16 px-4 sm:px-6 lg:px-8 transition-colors duration-700">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-heading text-4xl sm:text-5xl font-bold {{ $textTitle }} mb-4">Track Order</h1>
            <p class="{{ $isJewellery ? 'text-[#f3d9ff]/60' : 'text-mulberry/60' }} text-sm tracking-widest uppercase">Stay updated on your shipment</p>
        </div>

        <!-- Feedback Messages -->
        @if(session('error'))
        <div class="mb-8 bg-black/20 border-l-4 border-red-500 p-4 rounded-r-xl backdrop-blur-sm">
            <p class="text-red-400 text-sm font-medium">{{ session('error') }}</p>
        </div>
        @endif

        <!-- Tracking Form -->
        <div class="{{ $cardBg }} backdrop-blur-md rounded-[40px] p-8 sm:p-12 shadow-xl border border-white/10 mb-12 transform hover:scale-[1.01] transition-all duration-500">
            <form action="{{ route('front.track_order') }}" method="GET" class="space-y-8">
                <input type="hidden" name="theme" value="{{ $theme }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="order_number" class="block text-[11px] font-bold {{ $textTitle }} uppercase tracking-[0.2em] ml-1">Order Number</label>
                        <input type="text" name="order_number" id="order_number" required placeholder="e.g. AVN-12345" 
                            value="{{ request('order_number') }}"
                            class="w-full {{ $inputBg }} {{ $inputBorder }} rounded-2xl px-6 py-4 text-sm {{ $isJewellery ? 'text-white' : 'text-mulberry' }} focus:outline-none focus:ring-2 {{ $inputFocus }} focus:border-transparent transition-all placeholder:{{ $isJewellery ? 'text-[#c0a0c0]/30' : 'text-mulberry/30' }}">
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="block text-[11px] font-bold {{ $textTitle }} uppercase tracking-[0.2em] ml-1">Email Address</label>
                        <input type="email" name="email" id="email" required placeholder="email@example.com"
                            value="{{ request('email') }}"
                            class="w-full {{ $inputBg }} {{ $inputBorder }} rounded-2xl px-6 py-4 text-sm {{ $isJewellery ? 'text-white' : 'text-mulberry' }} focus:outline-none focus:ring-2 {{ $inputFocus }} focus:border-transparent transition-all placeholder:{{ $isJewellery ? 'text-[#c0a0c0]/30' : 'text-mulberry/30' }}">
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="{{ $accentColor }} {{ $accentText }} text-[12px] font-bold tracking-[0.25em] uppercase px-12 py-5 rounded-full hover:scale-105 active:scale-95 transition-all shadow-lg shadow-black/20">
                        Track Shipment
                    </button>
                </div>
            </form>
        </div>

        <!-- Result Section -->
        @if($order)
        <div class="{{ $isJewellery ? 'bg-[#350047]/90' : 'bg-white/90' }} backdrop-blur-md rounded-[40px] overflow-hidden shadow-2xl border border-white/10 animate-fade-in">
            <!-- Order Header -->
            <div class="{{ $accentColor }} p-8 {{ $accentText }} flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-[11px] font-medium tracking-[0.3em] uppercase opacity-70 mb-1">Tracking Order</h2>
                    <p class="text-2xl font-bold tracking-wider">{{ $order->order_number }}</p>
                </div>
                <div class="text-center sm:text-right">
                    <span class="inline-block px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest {{ 
                        $order->status === 'delivered' ? 'bg-green-500 text-white' : 
                        ($order->status === 'cancelled' ? 'bg-red-500 text-white' : ($isJewellery ? 'bg-white text-black' : 'bg-pastel-pink text-mulberry'))
                    }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="p-8 sm:p-12">
                <div class="relative">
                    <!-- Progress Line -->
                    <div class="absolute left-[15px] top-4 bottom-4 w-0.5 {{ $isJewellery ? 'bg-[#d4af37]/30' : 'bg-[#F8C8DC]' }}"></div>

                    <!-- Steps -->
                    <div class="space-y-12">
                        <!-- Placed -->
                        <div class="relative flex items-center gap-8 pl-12 group">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 {{ $isJewellery ? 'border-[#d4af37]' : 'border-mulberry' }} bg-white z-10 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-lg shadow-black/10">
                                <div class="w-3 h-3 rounded-full {{ $isJewellery ? 'bg-[#d4af37]' : 'bg-mulberry' }}"></div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold {{ $isJewellery ? 'text-[#d4af37]' : 'text-mulberry' }} uppercase tracking-widest mb-1">Order Placed</h3>
                                <p class="text-[11px] {{ $isJewellery ? 'text-[#e9d5ff]/50' : 'text-mulberry/50' }}">{{ $order->created_at->format('M d, Y | h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Processing -->
                        @if(!in_array($order->status, ['pending']))
                        <div class="relative flex items-center gap-8 pl-12 group">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 {{ $isJewellery ? 'border-[#d4af37]' : 'border-mulberry' }} bg-white z-10 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-lg shadow-black/10">
                                <div class="w-3 h-3 rounded-full {{ $isJewellery ? 'bg-[#d4af37]' : 'bg-mulberry' }}"></div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold {{ $isJewellery ? 'text-[#d4af37]' : 'text-mulberry' }} uppercase tracking-widest mb-1">Processing & Packed</h3>
                                <p class="text-[11px] {{ $isJewellery ? 'text-[#e9d5ff]/50' : 'text-mulberry/50' }}">Your order is being prepared for shipment.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Shipped -->
                        @if(in_array($order->status, ['shipped', 'out_for_delivery', 'delivered']))
                        <div class="relative flex items-center gap-8 pl-12 group">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 {{ $isJewellery ? 'border-[#d4af37]' : 'border-mulberry' }} bg-white z-10 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-lg shadow-black/10">
                                <div class="w-3 h-3 rounded-full {{ $isJewellery ? 'bg-[#d4af37]' : 'bg-mulberry' }}"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-sm font-bold {{ $isJewellery ? 'text-[#d4af37]' : 'text-mulberry' }} uppercase tracking-widest mb-1">Shipped</h3>
                                    @if($order->tracking_number)
                                    <span class="text-[10px] {{ $isJewellery ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-pastel-pink text-mulberry' }} px-3 py-1 rounded-full font-bold">Track: {{ $order->tracking_number }}</span>
                                    @endif
                                </div>
                                <p class="text-[11px] {{ $isJewellery ? 'text-[#e9d5ff]/50' : 'text-mulberry/50' }}">In transit via our courier partner.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Delivered -->
                        @if($order->status === 'delivered')
                        <div class="relative flex items-center gap-8 pl-12 group">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 border-green-500 bg-white z-10 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-lg shadow-green-100">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-green-500 uppercase tracking-widest mb-1">Delivered</h3>
                                <p class="text-[11px] text-green-500/70">Order successfully handed over at destination.</p>
                            </div>
                        </div>
                        @elseif($order->status === 'cancelled')
                        <div class="relative flex items-center gap-8 pl-12 group">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 border-red-500 bg-white z-10 flex items-center justify-center group-hover:scale-110">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-500 uppercase tracking-widest mb-1">Cancelled</h3>
                                <p class="text-[11px] text-red-500/70">This shipment has been cancelled.</p>
                            </div>
                        </div>
                        @else
                         <div class="relative flex items-center gap-8 pl-12 opacity-30">
                            <div class="absolute left-0 w-8 h-8 rounded-full border-2 {{ $isJewellery ? 'border-[#d4af37]/30' : 'border-[#F8C8DC]' }} bg-white z-10 flex items-center justify-center">
                                <div class="w-3 h-3 rounded-full {{ $isJewellery ? 'bg-[#d4af37]/30' : 'bg-[#F8C8DC]' }}"></div>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold {{ $isJewellery ? 'text-white' : 'text-mulberry' }} uppercase tracking-widest mb-1">Delivered</h3>
                                <p class="text-[11px] {{ $isJewellery ? 'text-[#e9d5ff]/50' : 'text-mulberry/50' }}">Parcel awaiting final delivery.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Summary -->
                <div class="mt-12 pt-8 border-t {{ $isJewellery ? 'border-white/10' : 'border-mulberry/5' }} flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl {{ $isJewellery ? 'bg-white/5' : 'bg-mulberry/5' }} flex items-center justify-center">
                            <svg class="w-6 h-6 {{ $isJewellery ? 'text-[#d4af37]' : 'text-mulberry' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold {{ $isJewellery ? 'text-[#d4af37]/60' : 'text-mulberry/40' }} uppercase tracking-widest">Expected by</p>
                            <p class="text-sm font-bold {{ $isJewellery ? 'text-white' : 'text-mulberry' }} tracking-wide">{{ $order->expected_delivery_date ? \Carbon\Carbon::parse($order->expected_delivery_date)->format('D, M d') : 'Calculating...' }}</p>
                        </div>
                    </div>
                    <a href="{{ $isJewellery ? route('front.jewellery') : route('front.home') }}" class="text-[11px] font-bold {{ $isJewellery ? 'text-[#d4af37]' : 'text-mulberry' }} uppercase tracking-[0.2em] hover:text-white transition-colors flex items-center gap-2">
                        ← Back to Shopping
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
}
</style>
@endsection
