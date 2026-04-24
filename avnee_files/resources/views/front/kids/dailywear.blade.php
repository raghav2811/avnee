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
            <span class="text-gray-900">Dailywear</span>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="font-heading text-4xl sm:text-5xl font-normal tracking-tight text-gray-900 uppercase mb-4">
                Dailywear
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Comfort meets style in our dailywear collection. Perfect for school, play, and everyday adventures, these outfits keep your little one comfortable and looking great.
            </p>
        </div>

        <!-- Hero Section -->
        <div class="mb-12 relative rounded-2xl overflow-hidden">
            <img src="{{ asset('images/shop-by-style/girls-dresses.png') }}" alt="Dailywear Collection" class="w-full h-64 sm:h-96 object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end">
                <div class="p-8 text-white">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Everyday Comfort</h2>
                    <p class="text-sm sm:text-base opacity-90">Soft fabrics and practical designs for active kids</p>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">All-Day Comfort</h3>
                <p class="text-sm text-gray-600">Breathable fabrics perfect for active children</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Durable Quality</h3>
                <p class="text-sm text-gray-600">Built to withstand daily wear and tear</p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M21 3h2l-.4 2M8 21h8m-4 0v-4m0 4l-3-3m3 3l3-3"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Easy to Wash</h3>
                <p class="text-sm text-gray-600">Machine washable for busy parents</p>
            </div>
        </div>

        <!-- Shop by Category -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('front.products.index', ['category' => 'girls-dresses']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Dresses</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => '2-4-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Tops & Sets</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => '4-6-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Bottoms</p>
                </a>
                <a href="{{ route('front.products.index', ['category' => '6-14-years']) }}" class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition-all border border-gray-200 group">
                    <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m7 7v-3"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Accessories</p>
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Featured Dailywear</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $featuredProducts = [
                        ['name' => 'Cotton Summer Dress', 'price' => 799, 'image' => asset('images/shop-by-style/girls-dresses.png')],
                        ['name' => 'Casual Play Set', 'price' => 699, 'image' => asset('images/shop-by-style/2-4-years.png')],
                        ['name' => 'Comfortable Daily Outfit', 'price' => 899, 'image' => asset('images/shop-by-style/4-6-years.png')],
                        ['name' => 'School Ready Dress', 'price' => 999, 'image' => asset('images/shop-by-style/6-14-years.png')],
                        ['name' => 'Everyday Top', 'price' => 599, 'image' => asset('images/shop-by-style/girls-dresses.png')],
                        ['name' => 'Playtime Outfit', 'price' => 749, 'image' => asset('images/shop-by-style/2-4-years.png')],
                        ['name' => 'Weekend Casual Set', 'price' => 849, 'image' => asset('images/shop-by-style/4-6-years.png')],
                        ['name' => 'Active Wear Dress', 'price' => 1099, 'image' => asset('images/shop-by-style/6-14-years.png')],
                    ];
                @endphp
                @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                        <p class="text-lg font-bold text-blue-600">₹{{ number_format($product['price'], 0) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Shop All Button -->
        <div class="text-center">
            <a href="{{ route('front.products.index', ['category' => 'girls-dresses']) }}" class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors text-lg">
                Shop All Dailywear
            </a>
        </div>

    </div>
</div>
@endsection
