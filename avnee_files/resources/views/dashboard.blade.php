@extends('layouts.front.studio')

@section('content')
<div class="bg-[#fdfaf6] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Dashboard Header -->
        <div class="mb-12">
            <h1 class="font-heading text-3xl uppercase tracking-[0.2em] text-icon-dark">My Account</h1>
            <p class="text-[#baa98a] text-sm mt-2 uppercase tracking-widest font-medium">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-[#e0d4c3] p-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-widest bg-black text-white hover:bg-[#b87333] transition-all">
                        Dashboard
                    </a>
                    <a href="{{ route('front.orders.index') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-widest text-icon-dark hover:bg-gray-50 transition-all border-b border-gray-50">
                        My Orders
                    </a>
                    <a href="{{ route('front.wishlist.index') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-widest text-icon-dark hover:bg-gray-50 transition-all border-b border-gray-50">
                        Wishlist
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-widest text-icon-dark hover:bg-gray-50 transition-all border-b border-gray-0.5">
                        Profile Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-4">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold uppercase tracking-widest text-red-600 hover:bg-red-50 transition-all">
                            Log Out
                        </button>
                    </form>
                </div>

            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-[#e0d4c3] p-8 text-center group hover:border-[#b87333] transition-all duration-500">
                        <span class="material-symbols-outlined text-4xl text-[#baa98a] group-hover:text-[#b87333] transition-colors mb-4">shopping_bag</span>
                        <h3 class="text-[10px] font-bold text-[#baa98a] uppercase tracking-widest mb-1">Active Orders</h3>
                        <p class="text-3xl font-heading text-icon-dark">0</p>
                    </div>
                    <div class="bg-white border border-[#e0d4c3] p-8 text-center group hover:border-[#b87333] transition-all duration-500">
                        <span class="material-symbols-outlined text-4xl text-[#baa98a] group-hover:text-[#b87333] transition-colors mb-4">favorite</span>
                        <h3 class="text-[10px] font-bold text-[#baa98a] uppercase tracking-widest mb-1">Wishlist Items</h3>
                        <p class="text-3xl font-heading text-icon-dark js-wishlist-count">0</p>
                    </div>
                    <div class="bg-white border border-[#e0d4c3] p-8 text-center group hover:border-[#b87333] transition-all duration-500">
                        <span class="material-symbols-outlined text-4xl text-[#baa98a] group-hover:text-[#b87333] transition-colors mb-4">Balance</span>
                        <h3 class="text-[10px] font-bold text-[#baa98a] uppercase tracking-widest mb-1">Avnee Credits</h3>
                        <p class="text-3xl font-heading text-icon-dark">₹0</p>
                    </div>
                </div>

                <!-- Recent Orders Preview -->
                <div class="bg-white border border-[#e0d4c3] overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-white">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-icon-dark">Recent Orders</h3>
                        <a href="{{ route('front.orders.index') }}" class="text-[10px] font-bold text-[#b87333] uppercase tracking-widest hover:underline">View All</a>
                    </div>
                    <div class="p-12 text-center text-gray-400">
                         <span class="material-symbols-outlined text-6xl mb-4 opacity-20">history</span>
                         <p class="text-sm font-body italic tracking-wide">You haven't placed any orders yet.</p>
                         <a href="{{ route('front.products.index') }}" class="inline-block mt-6 px-8 py-3 bg-black text-white text-[10px] font-bold uppercase tracking-widest hover:bg-[#b87333] transition-all">Start Shopping</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
