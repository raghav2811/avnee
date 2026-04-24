@extends('layouts.front.' . ($theme ?? 'studio'))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-700';
    $bgColor = $isDark ? 'bg-[#0f0a14]' : 'bg-[#F8C8DC]';
    $cardBg = $isDark ? 'bg-[#1a161d]' : 'bg-white/80';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $btnBg = $isDark ? 'bg-[#7C3AED]' : 'bg-[#b87333]';
    $lineColor = $isDark ? 'border-white/10' : 'border-black/5';
@endphp

<div class="min-h-screen py-20 px-4 {{ $bgColor }} relative overflow-hidden">
    <!-- Luxury Background Decor -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] {{ $isDark ? 'bg-purple-900/10' : 'bg-orange-100/30' }} blur-[150px] rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] {{ $isDark ? 'bg-pink-900/10' : 'bg-pink-100/20' }} blur-[150px] rounded-full -ml-48 -mb-48"></div>

    <div class="max-w-[1280px] mx-auto relative z-10">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-heading font-normal {{ $textColor }} tracking-[0.18em] uppercase mb-4">Contact Us</h1>
            <p class="text-xs {{ $mutedColor }} font-black uppercase tracking-[0.36em]">Connect with our curated design team</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Contact Info -->
            <div class="space-y-12">
                <div class="space-y-6">
                    <h2 class="text-3xl font-heading font-normal {{ $textColor }} uppercase tracking-[0.08em] leading-snug">
                        Whether it's a sizing enquiry or a bespoke commission, our team is at your disposal.
                    </h2>
                    <p class="text-base {{ $mutedColor }} leading-loose italic max-w-lg">
                        AVNEE offers a personalized shopping experience. Reach out for styling advice, product details, or assistance with your recent luxury purchase.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $accentColor }}">Enquiries</span>
                        <p class="text-base {{ $textColor }} font-bold">studio@avneecollections.com</p>
                        <p class="text-base {{ $textColor }} font-bold">avnee.collections@gmail.com</p>
                    </div>
                    <div class="space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $accentColor }}">Personal Shopper</span>
                        <p class="text-base {{ $textColor }} font-bold">+91 908671144</p>
                    </div>
                    <div class="col-span-full space-y-3 pt-6 border-t {{ $lineColor }}">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $accentColor }}">Atelier Address</span>
                        <p class="text-base {{ $textColor }} font-bold leading-relaxed capitalize">
                            AVNEE luxury studio, 4th floor, heritage building,<br>
                            design district, hyderabad, india - 500033
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="{{ $cardBg }} backdrop-blur-xl border {{ $lineColor }} p-8 sm:p-12 rounded-[2px] shadow-2xl">
                @if(session('success'))
                    <div class="mb-10 p-6 {{ $isDark ? 'bg-green-500/10 border-green-500/30' : 'bg-green-50 border-green-100' }} border text-green-600 text-[10px] font-black uppercase tracking-widest leading-loose text-center">
                        <span class="material-symbols-outlined align-middle mr-2 text-sm italic">verified</span>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('front.contact.submit') }}" method="POST" class="space-y-10">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} group-focus-within:{{ $textColor }} transition-colors">Full Name</label>
                            <input type="text" name="name" required class="w-full bg-transparent border-b {{ $lineColor }} py-3 text-base {{ $textColor }} focus:outline-none focus:border-current transition-all tracking-widest placeholder-gray-700" placeholder="Required">
                        </div>
                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} group-focus-within:{{ $textColor }} transition-colors">Client Email</label>
                            <input type="email" name="email" required class="w-full bg-transparent border-b {{ $lineColor }} py-3 text-base {{ $textColor }} focus:outline-none focus:border-current transition-all tracking-widest placeholder-gray-700" placeholder="Required">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} group-focus-within:{{ $textColor }} transition-colors">Phone (Optional)</label>
                            <input type="text" name="phone" class="w-full bg-transparent border-b {{ $lineColor }} py-3 text-base {{ $textColor }} focus:outline-none focus:border-current transition-all tracking-widest placeholder-gray-700" placeholder="+91">
                        </div>
                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} group-focus-within:{{ $textColor }} transition-colors">Subject</label>
                            <select name="subject" class="w-full bg-transparent border-b {{ $lineColor }} py-3 text-base {{ $textColor }} focus:outline-none focus:border-current transition-all tracking-widest appearance-none">
                                <option value="Sizing Enquiry" class="bg-black text-white">Sizing Enquiry</option>
                                <option value="Shipping Status" class="bg-black text-white">Shipping Status</option>
                                <option value="Bespoke Request" class="bg-black text-white">Bespoke Request</option>
                                <option value="Other" class="bg-black text-white" selected>Other Enquiries</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2 group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} group-focus-within:{{ $textColor }} transition-colors">Message</label>
                        <textarea name="message" required rows="4" class="w-full bg-transparent border-b {{ $lineColor }} py-3 text-base {{ $textColor }} focus:outline-none focus:border-current transition-all tracking-widest placeholder-gray-700 resize-none" placeholder="How may we assist you?"></textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 {{ $btnBg }} text-white text-[11px] font-black uppercase tracking-[0.4em] hover:opacity-90 transition-all shadow-xl active:scale-[0.98]">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
