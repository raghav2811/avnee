@extends('layouts.front.' . $theme)

@section('content')
@php 
    $isDark = $theme === 'jewellery'; 
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#a8998a]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-gray-50';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
    $accentHoverBg = $isDark ? 'hover:bg-[#6d28d9]' : 'hover:bg-[#9a5a1f]';
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16 {{ $textColor }} font-body">
    <div class="flex items-center justify-between mb-10 pb-4 border-b {{ $borderColor }}">
        <h1 class="font-heading text-2xl sm:text-3xl font-normal tracking-wide uppercase">My Wishlist</h1>
        <span class="text-xs sm:text-sm font-semibold tracking-wider uppercase {{ $mutedColor }}"><span id="wishlist-total">{{ $wishlistItems->count() }}</span> Items</span>
    </div>

    @if($wishlistItems->isEmpty())
    <div id="empty-wishlist" class="text-center py-20 flex flex-col items-center">
        <span class="material-symbols-outlined text-6xl {{ $mutedColor }} mb-6">heart_broken</span>
        <p class="text-xl mb-6 font-medium tracking-tight">Your wishlist is empty.</p>
        <p class="text-sm {{ $mutedColor }} mb-8 max-w-sm">Save your favorite pieces here while you decide. They will be waiting for you.</p>
        <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="inline-block px-10 py-3.5 {{ $accentBg }} {{ $accentHoverBg }} text-white text-xs font-bold tracking-[0.2em] uppercase rounded-sm transition-all shadow-sm">Discover Pieces</a>
    </div>
    @else
    <div id="wishlist-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
        @foreach($wishlistItems as $item)
        <div id="wishlist-item-{{ $item->id }}" class="group {{ $cardBg }} relative flex flex-col h-full transition-all duration-500 border {{ $borderColor }} hover:shadow-xl hover:border-transparent">
            <!-- Remove Button -->
            <button data-item-id="{{ $item->id }}" class="js-remove-wishlist absolute top-3 right-3 z-10 w-9 h-9 flex items-center justify-center bg-white/90 dark:bg-black/60 backdrop-blur-md rounded-full shadow-sm hover:bg-black hover:text-white dark:hover:bg-[#b87333] transition-all duration-300 transform hover:scale-110" title="Remove from wishlist">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>

            <!-- Image Link -->
            <a href="{{ route('front.product.detail', $item->product->slug ?? $item->product->id) }}" class="relative block overflow-hidden bg-gray-100 dark:bg-gray-800" style="aspect-ratio: 3/4;">
                @if($item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover object-top transition-transform duration-1000 group-hover:scale-110" loading="lazy" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <span class="material-symbols-outlined text-4xl">image</span>
                    </div>
                @endif
                
                @if($item->product->discount > 0)
                <div class="absolute top-4 left-0 bg-[#b87333] text-white text-[10px] font-bold px-3 py-1 tracking-[0.1em] uppercase shadow-sm">
                    -{{ $item->product->discount }}%
                </div>
                @endif
            </a>

            <!-- Content -->
            <div class="p-4 text-center flex-1 flex flex-col justify-between">
                <div>
                    <a href="{{ route('front.product.detail', $item->product->slug ?? $item->product->id) }}" class="block mb-3">
                        <h3 class="text-[11px] sm:text-[13px] font-bold tracking-tight {{ $textColor }} leading-tight line-clamp-2 uppercase min-h-[2.5rem] group-hover:{{ $accentColor }} transition-colors text-ellipsis overflow-hidden">{{ $item->product->name }}</h3>
                    </a>
                    <div class="flex items-center justify-center gap-3 mb-5">
                        <span class="text-sm sm:text-base font-bold {{ $textColor }}">₹{{ number_format($item->product->price) }}</span>
                        @if($item->product->discount > 0)
                        <span class="text-xs {{ $mutedColor }} line-through opacity-60">₹{{ number_format($item->product->compare_price) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Move to Cart -->
                <button 
                    data-item-id="{{ $item->id }}" 
                    data-product-id="{{ $item->product_id }}" 
                    data-variant-id="{{ $item->variant_id ?? 'null' }}"
                    class="js-move-to-cart wishlist-atc-btn w-full py-3.5 bg-black text-white text-[10px] font-bold tracking-[0.15em] uppercase hover:bg-[#b87333] transition-all rounded-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">shopping_bag</span>
                    <span>Move to Cart</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State (initially hidden) -->
    <div id="empty-state" class="hidden text-center py-20 flex flex-col items-center animate-in fade-in duration-700">
        <span class="material-symbols-outlined text-6xl {{ $mutedColor }} mb-6">heart_broken</span>
        <p class="text-xl mb-6 font-medium tracking-tight">Your wishlist is now empty.</p>
        <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="inline-block px-10 py-3.5 {{ $accentBg }} {{ $accentHoverBg }} text-white text-xs font-bold tracking-[0.2em] uppercase rounded-sm transition-all shadow-sm">Discover Pieces</a>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove from wishlist
        document.querySelectorAll('.js-remove-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                if (!confirm('Remove this item from your wishlist?')) return;

                const itemEl = document.getElementById(`wishlist-item-${itemId}`);
                itemEl.style.opacity = '0.5';
                itemEl.style.pointerEvents = 'none';

                fetch(`/wishlist/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    window.location.reload();
                })
                .catch(error => {
                    itemEl.style.opacity = '1';
                    itemEl.style.pointerEvents = 'auto';
                    console.error('Error removing item:', error);
                });
            });
        });

        // Move to Cart
        document.querySelectorAll('.js-move-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const productId = this.dataset.productId;
                const variantId = this.dataset.variantId === 'null' ? null : this.dataset.variantId;
                
                const btnEl = this;
                const originalContent = btnEl.innerHTML;
                
                btnEl.innerHTML = '<span class="animate-spin material-symbols-outlined text-sm">autorenew</span><span class="ml-1">Wait...</span>';
                btnEl.disabled = true;

                fetch(`/wishlist/move-to-cart/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error moving item to cart');
                    }
                })
                .catch(error => {
                    btnEl.innerHTML = originalContent;
                    btnEl.disabled = false;
                    console.error('Error moving item to cart:', error);
                });
            });
        });
    });

    function updateWishlistCount(decrement = false) {
        const countEl = document.getElementById('wishlist-total');
        if (decrement && countEl) {
            let current = parseInt(countEl.textContent);
            countEl.textContent = Math.max(0, current - 1);
            
            document.querySelectorAll('.js-wishlist-count').forEach(el => {
                el.textContent = Math.max(0, parseInt(el.textContent) - 1);
            });

            if (parseInt(countEl.textContent) === 0) {
                const grid = document.getElementById('wishlist-grid');
                if (grid) grid.classList.add('hidden');
                
                const emptyState = document.getElementById('empty-state') || document.getElementById('empty-wishlist');
                if (emptyState) emptyState.classList.remove('hidden');
            }
        }
    }
</script>
@endpush
@endsection
