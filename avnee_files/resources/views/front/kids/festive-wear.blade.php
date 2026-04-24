@extends('layouts.front.studio')

@section('content')
<div class="bg-[#F8C8DC] min-h-screen">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6 flex items-center gap-2 text-[10px] font-bold tracking-[0.24em] uppercase text-gray-600" aria-label="Breadcrumb">
            <a href="{{ route('front.home') }}" class="hover:text-gray-900 transition-colors">Home</a>
            <span class="opacity-40">&gt;&gt;</span>
            <a href="{{ route('front.home') }}" class="hover:text-gray-900 transition-colors">Studio</a>
            <span class="opacity-40">&gt;&gt;</span>
            <a href="{{ route('front.kids.all-girls') }}" class="hover:text-gray-900 transition-colors">Kids</a>
            <span class="opacity-40">&gt;&gt;</span>
            <span class="text-gray-900">Festive Wear</span>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="font-heading text-4xl sm:text-5xl font-normal tracking-tight text-gray-900 uppercase mb-4">
                Festive Wear
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Celebrate traditions in style with our festive wear collection. Rich colors, intricate designs, and premium fabrics perfect for weddings, festivals, and special occasions.
            </p>
        </div>

        <!-- Hero Section -->
        <div class="mb-12 relative rounded-2xl overflow-hidden">
            <img src="{{ asset('images/shop-by-style/festive-wear.png') }}" alt="Festive Wear Collection" class="w-full h-64 sm:h-96 object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end">
                <div class="p-8 text-white">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Traditional Elegance</h2>
                    <p class="text-sm sm:text-base opacity-90">Authentic designs for modern celebrations</p>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Rich Colors</h3>
                <p class="text-sm text-gray-600">Vibrant hues that celebrate traditional Indian culture</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Intricate Work</h3>
                <p class="text-sm text-gray-600">Handcrafted details and traditional embroidery</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Premium Fabrics</h3>
                <p class="text-sm text-gray-600">Silk, cotton blends perfect for festive occasions</p>
            </div>
        </div>

        <!-- Shop by Occasion -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Shop by Occasion</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('front.products.index', ['category' => 'festive-wear']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Weddings</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => 'festive-wear']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Festivals</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => 'festive-wear']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Pujas</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => 'festive-wear']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Family Functions</p>
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Featured Festive Wear</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $featuredProducts = [
                        ['name' => 'Traditional Silk Lehenga', 'price' => 2499, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Embroidered Party Dress', 'price' => 1899, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Festive Ethnic Set', 'price' => 2199, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Designer Festive Wear', 'price' => 2999, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Classic Festive Outfit', 'price' => 1699, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Royal Festive Dress', 'price' => 1999, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Wedding Special Lehenga', 'price' => 3499, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Festival Celebration Wear', 'price' => 2799, 'image' => asset('images/shop-by-style/festive-wear.png')],
                    ];
                @endphp
                @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                        <p class="text-lg font-bold text-red-600">₹{{ number_format($product['price'], 0) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Shop All Button -->
        <div class="text-center">
            <a href="{{ route('front.products.index', ['category' => 'festive-wear']) }}" class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors text-lg">
                Shop All Festive Wear
            </a>
        </div>

    </div>
</div>
@endsection
