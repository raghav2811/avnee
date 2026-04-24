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
    <div class="mb-12">
        <h1 class="font-heading text-3xl sm:text-4xl uppercase tracking-[0.2em] mb-3">Order History</h1>
        <p class="text-[11px] {{ $accentColor }} font-bold uppercase tracking-[0.4em]">Track and manage your past purchases</p>
    </div>

    <div class="bg-white/5 backdrop-blur-sm border {{ $borderColor }} rounded-sm overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left {{ $textColor }}">
                <thead class="text-[10px] font-black uppercase tracking-[0.2em] {{ $cardBg }} border-b {{ $borderColor }} {{ $mutedColor }}">
                    <tr>
                        <th class="px-8 py-5">Order Reference</th>
                        <th class="px-8 py-5">Purchase Date</th>
                        <th class="px-8 py-5">Delivery Status</th>
                        <th class="px-8 py-5">Total Value</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y {{ $borderColor }}">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/5 transition-colors">
                            <td class="px-8 py-6 font-bold tracking-tight">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-8 py-6 {{ $mutedColor }}">
                                {{ $order->created_at->format('F d, Y') }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full 
                                    {{ $order->status === 'delivered' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 
                                       ($order->status === 'cancelled' ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 'bg-blue-500/10 text-blue-500 border border-blue-500/20') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 font-semibold">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('front.orders.show', $order->order_number) }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest {{ $accentColor }} hover:underline group">
                                    View Details
                                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-5xl {{ $mutedColor }} opacity-20 mb-4 text-center">shopping_bag</span>
                                <p class="{{ $mutedColor }} italic tracking-wide">You haven't placed any orders with us yet.</p>
                                <a href="{{ route('front.products.index') }}" class="mt-6 px-10 py-3 bg-black text-white text-[10px] font-bold uppercase tracking-widest hover:bg-[#b87333] transition-all">Start Shopping</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="px-8 py-6 border-t {{ $borderColor }} bg-gray-50/5">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
