@extends('layouts.front.' . ($theme ?? 'studio'))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-500';
    $bgColor = $isDark ? 'bg-[#0a050a]' : 'bg-gray-50';
    $cardBg = $isDark ? 'bg-white/5' : 'bg-white';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $btnBg = $isDark ? 'bg-[#7C3AED]' : 'bg-[#b87333]';
@endphp

<div class="min-h-[80vh] py-20 px-4 {{ $bgColor }} relative overflow-hidden">
    <!-- Luxury Background Decor -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] {{ $isDark ? 'bg-purple-900/10' : 'bg-orange-100/50' }} blur-[150px] rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] {{ $isDark ? 'bg-pink-900/10' : 'bg-pink-100/30' }} blur-[150px] rounded-full -ml-48 -mb-48"></div>

    <div class="max-w-[480px] mx-auto relative z-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-heading font-normal {{ $textColor }} tracking-[0.2em] uppercase mb-4">Track Order</h1>
            <p class="text-xs {{ $mutedColor }} font-bold uppercase tracking-[0.3em]">Monitor your luxury delivery</p>
        </div>

        <div class="backdrop-blur-xl {{ $cardBg }} border {{ $isDark ? 'border-white/10' : 'border-black/5' }} p-8 sm:p-12 rounded-[2px] shadow-2xl">
            @if($errors->any())
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-500 text-xs font-bold uppercase tracking-widest text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('front.track_order') }}" method="GET" class="space-y-8">
                <input type="hidden" name="theme" value="{{ $isDark ? 'jewellery' : 'studio' }}">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }}">Order Number</label>
                    <input type="text" name="order_number" value="{{ old('order_number') }}" placeholder="e.g. ORD-12345" required
                        class="w-full bg-transparent border-b {{ $isDark ? 'border-white/20' : 'border-black/10' }} py-3 text-sm {{ $textColor }} placeholder-gray-500 focus:outline-none focus:border-current transition-all tracking-widest">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }}">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Used during checkout" required
                        class="w-full bg-transparent border-b {{ $isDark ? 'border-white/20' : 'border-black/10' }} py-3 text-sm {{ $textColor }} placeholder-gray-500 focus:outline-none focus:border-current transition-all tracking-widest">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 {{ $btnBg }} text-white text-[11px] font-black uppercase tracking-[0.4em] hover:opacity-90 transition-all shadow-xl active:scale-[0.98]">
                        Verify & Track
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-[10px] {{ $mutedColor }} italic tracking-widest leading-loose">
                Need help? <a href="{{ route('front.contact') }}" class="{{ $accentColor }} border-b border-current font-bold not-italic">Contact Concierge</a>
            </p>
        </div>
    </div>
</div>
@endsection
