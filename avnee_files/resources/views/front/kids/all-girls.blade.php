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
            <a href="{{ route('front.kids.all-girls') }}" class="text-gray-900">Kids</a>
            <span class="opacity-40">&gt;&gt;</span>
            <span class="text-gray-900">All Girls</span>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="font-heading text-4xl sm:text-5xl font-normal tracking-tight text-gray-900 uppercase mb-4">
                All Girls
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Discover our complete collection for girls of all ages. From playful party outfits to comfortable daily wear, find everything your little one needs.
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
            <a href="{{ route('front.kids.party-frocks') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                <div class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100">
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-pink-200 rounded-full flex items-center justify-center mb-3 mx-auto">
                                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Party Frocks</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 text-center">Stylish party wear for special occasions</p>
                </div>
            </a>

            <a href="{{ route('front.kids.dailywear') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                <div class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-blue-100 to-green-100">
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center mb-3 mx-auto">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Dailywear</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 text-center">Comfortable outfits for everyday wear</p>
                </div>
            </a>

            <a href="{{ route('front.kids.festive-wear') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                <div class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-yellow-100 to-red-100">
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-200 rounded-full flex items-center justify-center mb-3 mx-auto">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Festive Wear</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 text-center">Traditional outfits for celebrations</p>
                </div>
            </a>

            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 opacity-75">
                <div class="aspect-[4/5] overflow-hidden bg-gradient-to-br from-purple-100 to-pink-100">
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-200 rounded-full flex items-center justify-center mb-3 mx-auto">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">More Coming</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 text-center">New collections arriving soon</p>
                </div>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Featured All Girls Collection</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $featuredProducts = [
                        ['name' => 'Floral Party Dress', 'price' => 899, 'image' => asset('images/shop-by-style/party-frocks.png')],
                        ['name' => 'Cotton Daily Set', 'price' => 699, 'image' => asset('images/shop-by-style/girls-dresses.png')],
                        ['name' => 'Festive Ethnic Wear', 'price' => 1299, 'image' => asset('images/shop-by-style/festive-wear.png')],
                        ['name' => 'Casual Summer Outfit', 'price' => 799, 'image' => asset('images/shop-by-style/2-4-years.png')],
                    ];
                @endphp
                @foreach($featuredProducts as $product)
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

        <!-- Call to Action -->
        <div class="text-center bg-white rounded-2xl p-8 shadow-sm border border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Need Help Choosing?</h3>
            <p class="text-gray-600 mb-6">Our stylists are here to help you find the perfect outfit for your little one.</p>
            <a href="{{ route('front.contact') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                Contact Stylist
            </a>
        </div>

    </div>
</div>
@endsection
