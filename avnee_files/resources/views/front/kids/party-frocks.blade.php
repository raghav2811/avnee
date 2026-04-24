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
            <span class="text-gray-900">Party Frocks</span>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="font-heading text-4xl sm:text-5xl font-normal tracking-tight text-gray-900 uppercase mb-4">
                Party Frocks
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Make every celebration memorable with our stunning party frocks collection. Designed for comfort and style, these outfits will make your little one shine at any special occasion.
            </p>
        </div>

        <!-- Hero Section -->
        <div class="mb-12 relative rounded-2xl overflow-hidden">
            <img src="{{ asset('images/shop-by-style/party-frocks.png') }}" alt="Party Frocks Collection" class="w-full h-64 sm:h-96 object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end">
                <div class="p-8 text-white">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Party Ready Collection</h2>
                    <p class="text-sm sm:text-base opacity-90">Stunning designs for birthdays, celebrations, and special moments</p>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Premium Fabrics</h3>
                <p class="text-sm text-gray-600">Soft, breathable materials that keep your child comfortable all day long</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Beautiful Designs</h3>
                <p class="text-sm text-gray-600">Trendy patterns and colors that make every party special</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Easy Care</h3>
                <p class="text-sm text-gray-600">Machine washable fabrics that maintain their beauty wash after wash</p>
            </div>
        </div>

        <!-- Shop by Age -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Shop by Age</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('front.products.index', ['category' => '2-4-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="text-2xl font-bold text-pink-600 mb-2 group-hover:scale-110 transition-transform">2-4</div>
                    <p class="text-sm text-gray-600">Years</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => '4-6-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="text-2xl font-bold text-pink-600 mb-2 group-hover:scale-110 transition-transform">4-6</div>
                    <p class="text-sm text-gray-600">Years</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => '6-14-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="text-2xl font-bold text-pink-600 mb-2 group-hover:scale-110 transition-transform">6-14</div>
                    <p class="text-sm text-gray-600">Years</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => 'infant-sets']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="text-2xl font-bold text-pink-600 mb-2 group-hover:scale-110 transition-transform">0-2</div>
                    <p class="text-sm text-gray-600">Years</p>
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Featured Party Frocks</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $featuredProducts = [
                        ['name' => 'Princess Pink Party Dress', 'price' => 1299, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Royal Blue Party Gown', 'price' => 1599, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Floral Party Frocks', 'price' => 1199, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Rainbow Party Dress', 'price' => 999, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Sparkle Party Outfit', 'price' => 1399, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Elegant Party Wear', 'price' => 1499, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Birthday Special Dress', 'price' => 1099, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Celebration Party Outfit', 'price' => 1699, 'image' => asset('images/shop-by-style/party-frocks.png')],
                    ];
                @endphp
                @foreach($featuredProducts as $index => $product)
                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                        <p class="text-lg font-bold text-pink-600">₹{{ number_format($product['price'], 0) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Shop All Button -->
        <div class="text-center">
            <a href="{{ route('front.products.index', ['category' => 'party-frocks']) }}" class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors text-lg">
                Shop All Party Frocks
            </a>
        </div>

    </div>
</div>
@endsection
