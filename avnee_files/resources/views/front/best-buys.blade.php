@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
  @php
    $bestBuyProductIds = \App\Models\Product::query()
      ->whereIn('slug', collect($bestBuyCards)->pluck('slug')->all())
      ->pluck('id', 'slug');
  @endphp
  <section id="best-buys-page" class="min-h-screen bg-[#ffe5f1] text-[#1f1f1f]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="mb-8 text-sm uppercase tracking-[0.32em] text-[#9c2e8d]">Home / Best Sellers</div>

      <div class="mb-8 rounded-[2rem] border border-[#f4c0db] bg-white/90 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div class="space-y-3">
            <p class="text-sm uppercase tracking-[0.28em] text-[#8d2c7d] font-semibold">Wedding Invite Edit</p>
            <h1 class="font-heading text-4xl sm:text-5xl text-[#1f1f1f]">Best Sellers</h1>
            <p class="max-w-2xl text-sm sm:text-base text-[#5b3b59]">Explore our curated collection of best buy dresses and guest ensemble picks in a vibrant, easy-to-shop layout.</p>
          </div>
          <div class="rounded-full bg-[#fde7f3] px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-[#9c2e8d] border border-[#f4c0db] shadow-sm">24 Items</div>
        </div>

        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div class="rounded-full bg-[#fce9f2] px-4 py-3 text-sm text-[#6d2c63] border border-[#f3c4db]">Shop any 2 showstopper guest ensembles @ ₹34,999/-</div>
          <div class="inline-flex items-center gap-2 rounded-full bg-[#fbe5f0] px-4 py-2 text-sm font-semibold text-[#8d2c7d] border border-[#f3c4db]">
            <span class="uppercase tracking-[0.18em]">Sort By</span>
            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-[#8d2c7d]">Price High to Low</span>
          </div>
        </div>
      </div>

      <div class="grid gap-6 lg:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="space-y-6 rounded-[2rem] border border-[#f4c0db] bg-white/90 p-6 shadow-sm">
          <div class="space-y-3">
            <h2 class="text-sm uppercase tracking-[0.28em] text-[#9c2e8d] font-semibold">Select Gallery</h2>
            <div class="space-y-2 text-sm text-[#5b3b59]">
              <button class="w-full rounded-full border border-[#f3c4db] bg-[#fff0f7] px-4 py-2 text-left font-semibold text-[#8d2c7d]">All Collections</button>
              <button class="w-full rounded-full border border-transparent bg-white px-4 py-2 text-left text-[#5b3b59] hover:border-[#f3c4db] hover:bg-[#fff0f7]">Jewellery</button>
              <button class="w-full rounded-full border border-transparent bg-white px-4 py-2 text-left text-[#5b3b59] hover:border-[#f3c4db] hover:bg-[#fff0f7]">Trinkets</button>
              <button class="w-full rounded-full border border-transparent bg-white px-4 py-2 text-left text-[#5b3b59] hover:border-[#f3c4db] hover:bg-[#fff0f7]">Fun Trinkets</button>
              <button class="w-full rounded-full border border-transparent bg-white px-4 py-2 text-left text-[#5b3b59] hover:border-[#f3c4db] hover:bg-[#fff0f7]">Infant Sets</button>
            </div>
          </div>
          <div class="space-y-3">
            <h2 class="text-sm uppercase tracking-[0.28em] text-[#9c2e8d] font-semibold">Available Sizes</h2>
            <div class="flex flex-wrap gap-2">
              <span class="rounded-full border border-[#f3c4db] bg-[#fff0f7] px-3 py-2 text-xs font-semibold text-[#8d2c7d]">All</span>
              <span class="rounded-full border border-[#f3c4db] bg-white px-3 py-2 text-xs text-[#5b3b59]">Free Size</span>
            </div>
          </div>
          <div class="space-y-3">
            <h2 class="text-sm uppercase tracking-[0.28em] text-[#9c2e8d] font-semibold">Price Range</h2>
            <div class="grid gap-3">
              <input type="text" placeholder="Min" class="w-full rounded-xl border border-[#f3c4db] bg-[#fff0f7] px-4 py-3 text-sm text-[#5b3b59]" />
              <input type="text" placeholder="Max" class="w-full rounded-xl border border-[#f3c4db] bg-[#fff0f7] px-4 py-3 text-sm text-[#5b3b59]" />
              <button class="w-full rounded-full bg-[#9c2e8d] px-4 py-3 text-sm font-semibold text-white">Apply Filters</button>
            </div>
          </div>
        </aside>

        <div class="space-y-8">
          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach($bestBuyCards as $card)
              <article id="{{ $card['slug'] }}" class="scroll-mt-28 overflow-hidden rounded-2xl bg-white border border-[#f3c4db] shadow-sm transition-transform duration-300 hover:-translate-y-0.5">
                <a href="{{ route('front.product.detail', $card['slug']) }}" class="relative block overflow-hidden">
                  <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy" class="w-full h-[280px] object-cover transition-transform duration-500 hover:scale-105" />
                  @if(isset($bestBuyProductIds[$card['slug']]))
                    <button
                      type="button"
                      class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white"
                      data-product-id="{{ $bestBuyProductIds[$card['slug']] }}"
                      aria-label="Add to wishlist"
                      title="Add to wishlist"
                    >
                      <svg class="wishlist-icon mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                      </svg>
                    </button>
                  @endif
                </a>
                <div class="p-4">
                  <a href="{{ route('front.product.detail', $card['slug']) }}" class="block">
                    <h2 class="text-sm font-semibold text-[#1f1f1f] mb-2 line-clamp-2">{{ $card['title'] }}</h2>
                  </a>
                  <span class="text-lg font-black text-[#1f1f1f]">₹{{ number_format($card['price'], 0) }}</span>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
