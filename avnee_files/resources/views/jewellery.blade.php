@extends('layouts.front.jewellery')
@section('content')

  <div class="jewellery-home-sequence">

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- HERO SLIDER                                    --}}
  {{-- ═══════════════════════════════════════════════ --}}
  <section id="hero-slider" class="relative w-full px-4 sm:px-6 lg:px-8 pt-4">
    <div class="max-w-[1440px] mx-auto">
      <div class="swiper hero-swiper bg-[#2B003A] aspect-[21/10] overflow-hidden border border-[#f3d9ff]/20">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href="{{ route('front.products.collection', ['collection' => 'sale']) }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/1.png') }}" alt="Jewellery Sale" class="w-full h-full object-cover" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="{{ route('front.products.index', ['category' => 'hair-accessories']) }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/2.png') }}" alt="Hair Accessories Sale" class="w-full h-full object-cover" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/3.png') }}" alt="Kids Jewellery Sale" class="w-full h-full object-cover" />
          </a>
        </div>
      </div>
      <div class="swiper-button-prev" id="hero-prev"></div>
      <div class="swiper-button-next" id="hero-next"></div>
      <div class="swiper-pagination" id="hero-pagination"></div>
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- FIRST SALE 3-BLOCK RAIL                        --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $featuredCollectionCards = [
      [
        'slug' => 'anti-tarnish',
        'title' => 'Anti Tarnish',
        'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=900&q=80',
      ],
      [
        'slug' => 'korean',
        'title' => 'Korean',
        'image' => 'https://images.unsplash.com/photo-1611085583191-a3b181a88401?auto=format&fit=crop&w=900&q=80',
      ],
      [
        'slug' => 'temple-traditional',
        'title' => 'Temple/Traditional',
        'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=900&q=80',
      ],
      [
        'slug' => 'meenakari',
        'title' => 'Meenakari',
        'image' => 'https://images.unsplash.com/photo-1535632787350-4e68ef0ac584?auto=format&fit=crop&w=900&q=80',
      ],
      [
        'slug' => 'kundan',
        'title' => 'Kundan',
        'image' => 'https://images.unsplash.com/photo-1600721391776-b5cd0e0048f9?auto=format&fit=crop&w=900&q=80',
      ],
    ];
  @endphp
  <section id="home-featured-collections" class="py-10 sm:py-14 bg-[#ececec] border-y border-[#d5d5d5]">
    <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#2B003A] font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-[#2B003A]/30 underline underline-offset-[12px]">Our Collections</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 lg:gap-4">
        @foreach($featuredCollectionCards as $card)
          <a href="{{ route('front.jewellery.collection.show', $card['slug']) }}" class="group block border border-[#d2cad2] bg-white p-1.5 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-[3/4]">
              <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
            </div>
            <div class="px-2 py-3 text-center bg-[#f1edf1]">
              <h3 class="text-sm sm:text-base font-semibold text-[#4b3043] tracking-wide">{{ $card['title'] }}</h3>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- TRENDING NOW (STATIC GUARANTEED)               --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $trendingNowProducts = collect(optional($activeFlashSale)->products ?? [])
      ->take(4)
      ->values();

    if ($trendingNowProducts->count() < 4) {
      $fallbackTrending = collect($popularPieces ?? [])->merge(collect($newArrivals ?? []))
        ->unique('id')
        ->take(4 - $trendingNowProducts->count());
      $trendingNowProducts = $trendingNowProducts->concat($fallbackTrending)->take(4)->values();
    }

    $onlineTrendingCards = collect([
      [
        'name' => 'Aurora Drop Pendant',
        'price' => 1299,
        'compare_price' => 1699,
        'discount' => 24,
        'image' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?auto=format&fit=crop&w=900&q=80',
        'link' => route('front.products.index', ['category' => 'necklace']),
      ],
      [
        'name' => 'Royal Ruby Earrings',
        'price' => 999,
        'compare_price' => 1399,
        'discount' => 29,
        'image' => 'https://images.unsplash.com/photo-1635767798638-3e25273a8236?auto=format&fit=crop&w=900&q=80',
        'link' => route('front.products.index', ['category' => 'earrings']),
      ],
      [
        'name' => 'Celeste Pearl Set',
        'price' => 1499,
        'compare_price' => 1999,
        'discount' => 25,
        'image' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=900&q=80',
        'link' => route('front.products.index', ['category' => 'necklace-set']),
      ],
      [
        'name' => 'Midnight Halo Studs',
        'price' => 899,
        'compare_price' => 1199,
        'discount' => 25,
        'image' => 'https://images.unsplash.com/photo-1620656798579-1984d6b0a56f?auto=format&fit=crop&w=900&q=80',
        'link' => route('front.products.index', ['category' => 'earrings']),
      ],
    ]);

    $trendingSlides = $trendingNowProducts->map(function ($product) {
      $safeCompare = (float) ($product->compare_price ?? 0);
      $safePrice = (float) ($product->price ?? 0);
      $discountPct = ($safeCompare > $safePrice && $safeCompare > 0)
        ? round((($safeCompare - $safePrice) / $safeCompare) * 100)
        : (int) ($product->discount ?? 0);

      return [
        'name' => $product->name,
        'price' => $safePrice,
        'compare_price' => $safeCompare,
        'discount' => $discountPct,
        'image' => asset('storage/' . $product->image),
        'link' => route('front.product.detail', $product->slug),
        'is_product' => true,
        'product_id' => $product->id,
        'is_wishlisted' => (bool) $product->is_wishlisted,
      ];
    })->concat($onlineTrendingCards->map(function ($card) {
      return [
        'name' => $card['name'],
        'price' => (float) $card['price'],
        'compare_price' => (float) $card['compare_price'],
        'discount' => (int) $card['discount'],
        'image' => $card['image'],
        'link' => $card['link'],
        'is_product' => false,
        'product_id' => null,
        'is_wishlisted' => false,
      ];
    }))->values();
  @endphp
  <section id="trending-now-static" class="py-12 sm:py-16 bg-[#efefef] border-y border-[#d5d5d5]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#1f1f1f] font-normal tracking-[0.12em] mb-10 sm:mb-14">Trending Now</h2>
      <div class="relative group">
        <button id="trending-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white border border-[#bdbdbd] rounded-full shadow-md hover:shadow-lg hover:border-[#2B003A] transition-all duration-200 text-[#2B003A] opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="trending-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white border border-[#bdbdbd] rounded-full shadow-md hover:shadow-lg hover:border-[#2B003A] transition-all duration-200 text-[#2B003A] opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
        <div class="swiper trending-now-swiper overflow-hidden px-1">
          <div class="swiper-wrapper">
            @foreach($trendingSlides as $slide)
            <div class="swiper-slide h-auto">
              <article class="bg-white border border-[#bdbdbd] p-2 sm:p-3 h-[450px] flex flex-col relative">
                <a href="{{ $slide['link'] }}" class="block relative bg-[#f8f8f8] h-[280px] overflow-hidden border border-[#d8d8d8]">
                  @if($slide['discount'] > 0)
                <span class="absolute top-2 left-2 z-10 bg-[#8a1f1f] text-white text-xs px-3 py-1">Sale</span>
                  @endif
                  <img src="{{ $slide['image'] }}" alt="{{ $slide['name'] }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy" />
                </a>
                @if($slide['is_product'] && $slide['product_id'])
                  <button
                    type="button"
                    class="wishlist-btn absolute top-5 right-5 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $slide['is_wishlisted'] ? 'text-red-500' : '' }}"
                    data-product-id="{{ $slide['product_id'] }}"
                    aria-label="Add to wishlist"
                    title="Add to wishlist"
                  >
                    <svg class="wishlist-icon mx-auto h-4 w-4 {{ $slide['is_wishlisted'] ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>
                @endif
                <div class="pt-4 px-2 pb-2 text-center flex-1 flex flex-col">
                  <a href="{{ $slide['link'] }}" class="block">
                    <h3 class="font-heading text-xl sm:text-2xl leading-[1.2] text-[#272727] line-clamp-2 h-[2.4rem] flex items-center justify-center">{{ $slide['name'] }}</h3>
                  </a>
                  <div class="mt-3 flex items-center justify-center gap-2 flex-wrap">
                    <span class="text-[#8a1f2f] text-2xl sm:text-3xl font-semibold">Rs{{ number_format($slide['price'], 2) }}</span>
                    @if($slide['compare_price'] > $slide['price'])
                      <span class="text-[#444] text-xl sm:text-2xl line-through">Rs{{ number_format($slide['compare_price'], 2) }}</span>
                    @endif
                  </div>
                  @if($slide['discount'] > 0)
                    <p class="text-[#222] text-lg sm:text-xl mt-2 font-medium">{{ $slide['discount'] }}% OFF</p>
                  @endif
                  <div class="mt-auto pt-4">
                    <a href="{{ $slide['link'] }}" class="inline-flex items-center justify-center w-full h-11 bg-[#1f1115] text-white text-lg sm:text-xl tracking-[0.08em] uppercase rounded-[3px] hover:bg-[#2a1a1e] transition-colors">Shop Now</a>
                  </div>
                </div>
              </article>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- SHOP BY PRICE                                  --}}
  {{-- ═══════════════════════════════════════════════ --}}
  <section id="shop-by-price-static" class="py-12 sm:py-16 bg-white">
    <div class="max-w-[1320px] mx-auto px-3 sm:px-4 lg:px-6">
      <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#2B003A] font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-[#2B003A]/30 underline underline-offset-[12px]">Shop by Price</h2>
      <div class="flex flex-wrap justify-center gap-6 sm:gap-10 lg:gap-16">
        @foreach([
          ['label' => 'Under', 'price' => '399', 'url' => route('front.products.index', ['max_price' => 399])],
          ['label' => 'Under', 'price' => '599', 'url' => route('front.products.index', ['min_price' => 400, 'max_price' => 599])],
          ['label' => 'Under', 'price' => '999', 'url' => route('front.products.index', ['min_price' => 600, 'max_price' => 999])],
          ['label' => 'Under', 'price' => '1999', 'url' => route('front.products.index', ['min_price' => 1000])],
        ] as $band)
        <a href="{{ $band['url'] }}" class="price-badge-wrap group relative flex shrink-0 items-center justify-center">
          <svg class="absolute inset-0 w-full h-full drop-shadow-xl badge-svg transition-transform duration-500 group-hover:scale-110" viewBox="0 0 200 200" preserveAspectRatio="xMidYMid meet">
            <path class="scallop-fill fill-mulberry" d="M100,12 A88,88 0 1,1 99.99,12 Z" />
            <path class="scallop-stroke fill-none stroke-pastel-pink/30" stroke-width="1.5" d="M100,21 A79,79 0 1,1 99.99,21 Z" />
          </svg>
          <div class="relative z-10 flex min-w-0 w-full flex-col items-center justify-center px-1 text-center">
            <span class="font-heading italic text-[#F8C8DC]/80 text-[10px] sm:text-xs lg:text-base uppercase tracking-[0.2em] mb-0 sm:mb-1">{{ $band['label'] }}</span>
            <span class="font-heading text-2xl sm:text-3xl lg:text-4xl font-bold tabular-nums text-pastel-pink tracking-wider whitespace-nowrap leading-tight">₹{{ $band['price'] }}</span>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- SHOP BY CATEGORY                               --}}
  {{-- ═══════════════════════════════════════════════ --}}
  <section id="shop-by-style-static" class="py-12 sm:py-16 bg-[#FADADD]">
    <div class="w-full px-3 sm:px-4 lg:px-8 xl:px-10">
      <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#2B003A] font-normal tracking-[0.2em] mb-10 uppercase">Shop by Category</h2>
      @php
        $styleCards = [
          ['label' => 'Sets', 'slug' => 'necklace-set', 'image' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?auto=format&fit=crop&w=900&q=80'],
          ['label' => 'Earrings', 'slug' => 'earrings', 'image' => 'images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-FLA-C45/AVN-JW-HAN-FLA-C45-01.png'],
          ['label' => 'Rings', 'slug' => 'rings', 'image' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=900&q=80'],
          ['label' => 'Bangles & Bracelet', 'slug' => 'bangles-bracelet', 'image' => 'images/bangles-bracelet/Bangles/ChatGPT Image Apr 6, 2026, 02_10_37 AM.png'],
          ['label' => 'Necklaces', 'slug' => 'necklace', 'image' => 'images/jewellery/Necklace/17850103560573191.webp'],
          ['label' => 'Mangalsutra', 'slug' => 'necklace-set', 'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=900&q=80'],
          ['label' => 'Hair Accessory', 'slug' => 'hair-accessories', 'image' => 'images/hair-accessories/ha-src-10.jpeg'],
        ];
      @endphp
      <div class="grid w-full grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-x-5 sm:gap-x-7 lg:gap-x-10 xl:gap-x-12 gap-y-5 sm:gap-y-6">
        @foreach($styleCards as $styleCard)
          @php
            $isRemoteStyleImage = str_starts_with($styleCard['image'], 'http://') || str_starts_with($styleCard['image'], 'https://');
            $styleImageSrc = $isRemoteStyleImage ? $styleCard['image'] : asset($styleCard['image']);
            if (!$isRemoteStyleImage) {
              $styleImagePath = public_path($styleCard['image']);
              $styleImageVersion = file_exists($styleImagePath) ? filemtime($styleImagePath) : now()->timestamp;
              $styleImageSrc .= '?v=' . $styleImageVersion;
            }
          @endphp
          <a href="{{ route('front.products.index', ['category' => $styleCard['slug']]) }}" class="group block text-center">
            <div class="aspect-[4/5] bg-white overflow-hidden shadow-sm border border-[#2B003A]/10 hover:shadow-lg transition-all duration-300">
              <img src="{{ $styleImageSrc }}" alt="{{ $styleCard['label'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
            </div>
            <p class="mt-2 text-sm sm:text-base text-[#2B003A] font-medium tracking-wide">{{ $styleCard['label'] }}</p>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- FLASH SALE SECTION                             --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if($activeFlashSale && $activeFlashSale->products->isNotEmpty())
  <section id="flash-sale" class="py-12 sm:py-16 bg-[#2B003A] border-y border-[#4f006a]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
        <div class="flex items-center gap-4">
          <svg class="w-10 h-10 text-[#f3d9ff] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          <div>
            <h2 class="font-heading text-2xl sm:text-3xl font-normal tracking-[0.1em] text-white uppercase decoration-[#f3d9ff]/30 underline underline-offset-[8px]">{{ $activeFlashSale->title }}</h2>
            <p class="text-[#e9d5ff] text-sm font-medium">Limited time offers end in:</p>
          </div>
        </div>
        <div class="flex gap-4 sm:gap-6" id="flash-countdown" data-expire="{{ $activeFlashSale->end_time->toIso8601String() }}">
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-[#350047] border border-[#4f006a] text-white px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-days">00</span>
            <span class="text-[10px] uppercase font-bold text-[#e9d5ff] mt-1 tracking-widest">Days</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-[#350047] border border-[#4f006a] text-white px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-hours">00</span>
            <span class="text-[10px] uppercase font-bold text-[#e9d5ff] mt-1 tracking-widest">Hours</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-[#350047] border border-[#4f006a] text-white px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-mins">00</span>
            <span class="text-[10px] uppercase font-bold text-[#e9d5ff] mt-1 tracking-widest">Mins</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-[#f3d9ff] text-[#2B003A] px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-secs">00</span>
            <span class="text-[10px] uppercase font-bold text-[#e9d5ff] mt-1 tracking-widest">Secs</span>
          </div>
        </div>
      </div>
      <div class="relative group">
        <button id="flash-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="flash-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
        <div class="swiper flash-swiper overflow-hidden px-1">
          <div class="swiper-wrapper">
            @foreach($activeFlashSale->products as $product)
            <div class="swiper-slide">
              <div class="group bg-[#350047] rounded-sm overflow-hidden border border-[#4f006a] hover:border-[#f3d9ff] transition-all shadow-lg">
                  <a href="{{ route('front.product.detail', $product->slug) }}" class="relative block bg-[#230030] aspect-[3/4]">
                      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                      @php $discountPct = $product->pivot->discount_percentage ?? $product->discount; @endphp
                      @if($discountPct > 0)
                      <div class="absolute top-2 left-2 bg-[#f3d9ff] text-[#2B003A] text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider">
                          {{ $discountPct }}% OFF
                      </div>
                      @endif
                  </a>
                  <button
                      type="button"
                      class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                      data-product-id="{{ $product->id }}"
                      aria-label="Add to wishlist"
                      title="Add to wishlist"
                  >
                      <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                      </svg>
                  </button>
                  <div class="p-3">
                      <h3 class="text-xs font-medium text-[#e9d5ff] line-clamp-1 mb-2 hover:text-[#f3d9ff] transition-colors">{{ $product->name }}</h3>
                      <div class="flex items-center gap-2">
                          <span class="text-sm font-bold text-[#f3d9ff]">₹{{ number_format($product->price, 2) }}</span>
                          @if($product->compare_price > $product->price)
                          <span class="text-xs text-[#c0a0c0] line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                          @endif
                      </div>
                  </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="swiper-pagination !-bottom-2 mt-8"></div>
        </div>
      </div>
    </div>
  </section>
  @endif

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- COMBO DEALS SECTION                            --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if(isset($combos) && $combos->count() > 0)
  <section id="combo-deals" class="py-16 sm:py-24 bg-[#230030] border-b border-[#4f006a]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-14 gap-8 text-center md:text-left">
            <div class="max-w-xl">
                <span class="text-[11px] font-bold uppercase tracking-[0.4em] text-[#f3d9ff] mb-3 block">Artisanal Pairings</span>
                <h2 class="font-heading text-2xl sm:text-4xl text-center md:text-left text-white font-normal tracking-[0.2em] mb-12 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">Combo Sets</h2>
                <p class="text-[#e9d5ff] text-base leading-relaxed">Exquisite jewelry sets curated by our master stylists for a complete, harmonious aesthetic.</p>
            </div>
            <a href="{{ route('front.products.index') }}" class="group flex items-center gap-4 text-xs font-bold uppercase tracking-[0.3em] text-white hover:text-[#f3d9ff] transition-all">
                The Full Collection
                <div class="w-10 h-10 rounded-full border border-[#4f006a] flex items-center justify-center group-hover:border-[#f3d9ff] transition-colors">
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </a>
        </div>
        <div class="relative group">
            <button id="combo-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button id="combo-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div class="swiper combo-swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($combos as $combo)
                    <div class="swiper-slide h-auto pb-4">
                        <div class="group relative flex flex-col bg-[#2B003A] rounded-sm overflow-hidden border border-[#4f006a] hover:border-[#f3d9ff]/30 transition-all duration-700 h-full shadow-2xl mx-1">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if($combo->image)
                                    <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" />
                                @else
                                    <img src="{{ asset('storage/' . $combo->products->first()->image) }}" alt="{{ $combo->title }}" class="w-full h-full object-cover brightness-[0.8] transition-transform duration-[2s] group-hover:scale-110" />
                                @endif
                                @if($combo->original_price > $combo->price)
                                <div class="absolute top-0 left-0 bg-[#f3d9ff] text-[#2B003A] px-5 py-2 text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl">
                                    Exclusive Value
                                </div>
                                @endif
                                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-[#2B003A] to-transparent"></div>
                            </div>
                            <div class="px-8 pb-8 flex-1 flex flex-col -mt-10 relative z-10">
                                <div class="mb-8 flex-1">
                                    <h3 class="font-heading text-2xl text-white mb-5 group-hover:text-[#f3d9ff] transition-colors uppercase tracking-widest leading-tight line-clamp-2">{{ $combo->title }}</h3>
                                    <div class="flex items-center gap-4">
                                        <div class="flex -space-x-4 overflow-hidden">
                                            @foreach($combo->products->take(4) as $cp)
                                                <div class="inline-block h-14 w-14 rounded-full ring-4 ring-[#2B003A] overflow-hidden border border-[#4f006a]">
                                                    <img src="{{ asset('storage/' . $cp->image) }}" class="h-full w-full object-cover" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <span class="text-[10px] font-bold text-[#a8998a] uppercase tracking-[0.2em]">{{ $combo->products->count() }} Piece Set</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-8 border-t border-[#4f006a]">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-3xl font-bold text-white tracking-tighter">₹{{ number_format($combo->price, 0) }}</span>
                                            @if($combo->original_price > $combo->price)
                                                <span class="text-[10px] bg-red-900/40 text-red-400 px-2 py-0.5 rounded uppercase font-bold tracking-tight">SAVE ₹{{ number_format($combo->original_price - $combo->price, 0) }}</span>
                                            @endif
                                        </div>
                                        @if($combo->original_price)
                                            <span class="text-xs text-[#c0a0c0] line-through tracking-wider">MSRP: ₹{{ number_format($combo->original_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" onclick="openComboModal('{{ $combo->id }}', '{{ number_format($combo->price, 2) }}');"
                                    class="mt-8 w-full inline-flex items-center justify-center bg-[#d4af37] text-white px-8 py-4 text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-[#f3d9ff] hover:text-black transition-all rounded-sm shadow-sm active:scale-95 group/btn">
                                    Buy Now
                                    <svg class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 17L17 7m0 0H8m9 0v9"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
  </section>
  @endif

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- DYNAMIC HOME SECTIONS --}}
  @php $loopSections = $homeSections->sortBy('sort_order'); @endphp
  @foreach($loopSections as $section)
    {{-- JUST IN --}}
    @if(($section->section_id === 'just_in_jewellery' || $section->section_id === 'just_in') && $section->is_active)
      <section id="just-in" class="py-10 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto">
        <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#f3d9ff] font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
          {{ $section->title }}
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
          @foreach($justInExperiences->take(4) as $exp)
          <a href="{{ $exp->button_link }}" class="group relative block overflow-hidden aspect-[4/5] bg-[#350047] rounded-sm border border-[#4f006a]">
            <img src="{{ asset('storage/' . $exp->image) }}" alt="{{ $exp->title }}" class="w-full h-full object-cover object-top transition-transform duration-700 ease-in-out group-hover:scale-110" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
            <div class="absolute bottom-0 inset-x-0 p-3 text-center">
              <p class="font-heading text-base sm:text-lg font-semibold text-white tracking-wide truncate">{{ $exp->title }}</p>
              <span class="inline-block mt-2 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] bg-[#f3d9ff] text-[#2B003A] opacity-0 group-hover:opacity-100 transition-opacity duration-300">Quick View</span>
            </div>
          </a>
          @endforeach
        </div>
      </section>
    @endif

    {{-- SHOP BY PRICE --}}
    @if(($section->section_id === 'shop_by_price_jewellery' || $section->section_id === 'shop_by_price') && $section->is_active)
      @php
        $renderPriceBands = $priceBands->isNotEmpty()
            ? $priceBands->map(function ($band) {
                return [
                    'label' => $band->label ?: 'Under',
                    'price' => (string) $band->price_limit,
                    'url' => $band->redirect_url ?: route('front.products.index', ['max_price' => $band->price_limit]),
                ];
            })->values()->all()
            : [
                ['label' => 'Under', 'price' => '399', 'url' => route('front.products.index', ['max_price' => 399])],
                ['label' => 'Under', 'price' => '599', 'url' => route('front.products.index', ['min_price' => 400, 'max_price' => 599])],
                ['label' => 'Under', 'price' => '999', 'url' => route('front.products.index', ['min_price' => 600, 'max_price' => 999])],
                ['label' => 'Under', 'price' => '1999', 'url' => route('front.products.index', ['min_price' => 1000])],
            ];
      @endphp
      <section id="shop-by-price" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto bg-white">
        <h2 class="font-heading text-2xl sm:text-4xl text-center text-mulberry font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-mulberry/30 underline underline-offset-[12px]">
          {{ $section->title }}
        </h2>
        <div class="flex flex-wrap justify-center gap-6 sm:gap-10 lg:gap-16">
          @foreach($renderPriceBands as $band)
          <a href="{{ $band['url'] }}" class="price-badge-wrap group relative flex shrink-0 items-center justify-center">
            <svg class="absolute inset-0 w-full h-full drop-shadow-xl badge-svg transition-transform duration-500 group-hover:scale-110" viewBox="0 0 200 200" preserveAspectRatio="xMidYMid meet">
              <path class="scallop-fill fill-mulberry" d="M100,12 A88,88 0 1,1 99.99,12 Z" />
              <path class="scallop-stroke fill-none stroke-pastel-pink/30" stroke-width="1.5" d="M100,21 A79,79 0 1,1 99.99,21 Z" />
            </svg>
            <div class="relative z-10 flex min-w-0 w-full flex-col items-center justify-center px-1 text-center">
              <span class="font-heading italic text-[#F8C8DC]/80 text-[10px] sm:text-xs lg:text-base uppercase tracking-[0.2em] mb-0 sm:mb-1">{{ $band['label'] }}</span>
              <span class="font-heading text-2xl sm:text-3xl lg:text-4xl font-bold tabular-nums text-pastel-pink tracking-wider whitespace-nowrap leading-tight">₹{{ preg_replace('/[^0-9]/', '', (string) $band['price']) ?: $band['price'] }}</span>
            </div>
          </a>
          @endforeach
        </div>
      </section>
    @endif

    {{-- SHOP BY STYLE --}}
    @if($section->section_id === 'shop_by_style' && $section->is_active)
      <section id="shop-by-style" class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto bg-[#2B003A]">
        <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#f3d9ff] font-normal tracking-[0.2em] mb-12 sm:mb-20 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
          {{ $section->title }}
        </h2>
        <div class="relative group">
          <button id="style-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#2B003A] border border-[#4f006a]/30 rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button id="style-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#2B003A] border border-[#4f006a]/30 rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
          <div class="swiper style-swiper overflow-hidden">
            <div class="swiper-wrapper">
              @foreach($homeStyles as $style)
              <div class="swiper-slide px-1">
                <div class="flex flex-col items-center group text-center">
                  <a href="{{ $style->redirect_url }}" class="relative w-full aspect-square overflow-hidden rounded-sm bg-white mb-4 transition-all duration-500 hover:shadow-2xl shadow-lg p-4 group/img border border-gray-100/50">
                    <img src="{{ asset('storage/' . $style->image) }}" alt="{{ $style->title }}" class="w-full h-full object-cover rounded-sm transition-transform duration-700 group-hover/img:scale-105" />
                  </a>
                  <h3 class="text-[10px] sm:text-xs font-bold text-[#f3d9ff] uppercase tracking-[0.2em] group-hover:text-white transition-colors leading-tight px-1">{{ $style->title }}</h3>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- BEST BUYS --}}
    @if(($section->section_id === 'best_buys_jewellery' || $section->section_id === 'best_buys') && $section->is_active)
      <section id="best-buys" class="py-12 sm:py-16 max-w-[1440px] mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex items-center justify-center mb-10 sm:mb-14">
          <h2 class="font-heading text-2xl sm:text-4xl text-[#f3d9ff] font-normal tracking-[0.2em] uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
            {{ $section->title }}
          </h2>
        </div>
        <div class="relative">
          <button id="best-buys-prev" class="absolute -left-1 sm:-left-4 top-[42%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] hover:text-[#f3d9ff]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button id="best-buys-next" class="absolute -right-1 sm:-right-4 top-[42%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] hover:text-[#f3d9ff]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
          <div class="swiper best-buys-swiper overflow-hidden px-1">
            <div class="swiper-wrapper">
              @php
                $bestBuyProducts = $section->products->take(8);
              @endphp
              @foreach($bestBuyProducts as $product)
              <div class="swiper-slide">
                <div class="group bg-[#350047]">
                  <a href="{{ route('front.product.detail', $product->slug) }}" class="relative block overflow-hidden bg-[#f5ede0]" style="aspect-ratio: 3/4;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" />
                  </a>
                  <button
                    type="button"
                    class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                    data-product-id="{{ $product->id }}"
                    aria-label="Add to wishlist"
                    title="Add to wishlist"
                  >
                    <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>
                  <div class="pt-3 pb-1 px-1">
                    <a href="{{ route('front.product.detail', $product->slug) }}">
                      <p class="text-xs text-[#e9d5ff] leading-snug line-clamp-2 mb-2 hover:text-[#f3d9ff] transition-colors">{{ $product->name }}</p>
                    </a>
                    <div class="flex items-center gap-2 flex-wrap">
                      <span class="text-sm font-semibold text-[#f3d9ff]">₹{{ number_format($product->price, 0) }}</span>
                      @if($product->compare_price > $product->price)
                      <span class="text-[10px] text-[#c0a0c0] line-through">₹{{ number_format($product->compare_price, 0) }}</span>
                      <span class="text-[9px] font-black text-white bg-red-600 px-1 rounded-sm">{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="mt-6 flex justify-center">
          <a href="{{ route('front.products.index') }}" class="px-6 py-2 text-[10px] sm:text-xs font-bold uppercase tracking-[0.2em] bg-[#f3d9ff] text-[#2B003A] hover:bg-white transition-colors rounded-full">View All</a>
        </div>
      </section>
    @endif

    {{-- SHOP THE LOOK (Premium Slider) --}}
    @if(($section->section_id === 'shop_the_look_jewellery' || $section->section_id === 'shop_the_look') && $section->is_active)
      <section id="shop-the-look" class="py-12 sm:py-24 bg-[#2B003A] overflow-hidden relative">
        <div class="max-w-[1440px] mx-auto px-4">
            <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#f3d9ff] font-normal tracking-[0.2em] mb-12 sm:mb-20 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
              {{ $section->title }}
            </h2>
        </div>

        <div class="relative max-w-[1600px] mx-auto px-4 sm:px-10 lg:px-20 group">
          <!-- Custom Navigation -->
          <button id="look-prev" class="absolute left-4 sm:left-10 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full border border-[#230030]/20 bg-white/80 hover:bg-[#230030] text-[#230030] hover:text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" /></svg>
          </button>

          <div id="shop-look-swiper" class="swiper pb-20">
            <div class="swiper-wrapper">
              @php $items = $section->products->take($section->limit); @endphp
              {{-- Render slide loop twice to ensure enough items for Swiper loop mode --}}
              @foreach($items->concat($items) as $product)
              <div class="swiper-slide">
                <div class="look-card bg-white/5 rounded-[40px] overflow-hidden p-3 sm:p-5 border border-white/10 backdrop-blur-md transition-all duration-500 scale-[0.65] opacity-20 [.swiper-slide-active_&]:scale-100 [.swiper-slide-active_&]:opacity-100 [.swiper-slide-prev_&]:scale-[0.80] [.swiper-slide-prev_&]:opacity-70 [.swiper-slide-next_&]:scale-[0.80] [.swiper-slide-next_&]:opacity-70">
                  <div class="relative aspect-[4/5] rounded-[32px] overflow-hidden group">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-1000 group-hover:scale-110" />
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#d4af37]/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <button
                      type="button"
                      class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                      data-product-id="{{ $product->id }}"
                      aria-label="Add to wishlist"
                      title="Add to wishlist"
                    >
                      <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                      </svg>
                    </button>
                  </div>
                  <div class="mt-6 text-center space-y-4 pb-2">
                    <h3 class="text-xl sm:text-2xl font-normal text-[#f3d9ff] tracking-tight line-clamp-1 truncate px-4">{{ $product->name }}</h3>
                    <div class="flex justify-center">
                      <a href="{{ route('front.product.detail', $product->slug) }}" class="inline-block bg-[#d4af37] text-[#1a0023] text-[11px] font-bold uppercase tracking-[0.2em] px-10 py-3 rounded-full hover:scale-105 active:scale-95 transition-all">
                        View
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <!-- Custom Pagination -->
            <div class="swiper-pagination !bottom-4 flex justify-center gap-2"></div>
          </div>

          <button id="look-next" class="absolute right-4 sm:right-10 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full border border-[#230030]/20 bg-white/80 hover:bg-[#230030] text-[#230030] hover:text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </section>
    @endif

    {{-- TOP COLLECTIONS --}}
    @if(($section->section_id === 'top_collections_jewellery' || $section->section_id === 'top_collections') && $section->is_active)
      <section id="top-collections" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto">
        <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#f3d9ff] font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
          {{ $section->title }}
        </h2>
        <div class="relative group">
          <button id="top-col-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button id="top-col-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
          <div class="swiper top-col-swiper overflow-hidden">
            <div class="swiper-wrapper">
              @foreach($section->products->take($section->limit) as $product)
              <div class="swiper-slide px-1">
                <a href="{{ route('front.product.detail', $product->slug) }}" class="top-col-card block group bg-[#f2ebe5] relative overflow-hidden" style="aspect-ratio: 1/1.1;">
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" />
                  <div class="top-col-overlay absolute inset-0 flex flex-col justify-end p-6 sm:p-8">
                    <h3 class="font-heading text-2xl sm:text-3xl font-semibold text-white mb-1 uppercase tracking-wider">{{ $product->name }}</h3>
                    <div class="top-col-btn inline-block bg-[#350047] text-white text-[10px] sm:text-xs font-semibold tracking-widest uppercase px-6 py-3 w-max border border-transparent group-hover:bg-[#d4af37]">EXPLORE COLLECTION</div>
                  </div>
                </a>
                <button
                  type="button"
                  class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                  data-product-id="{{ $product->id }}"
                  aria-label="Add to wishlist"
                  title="Add to wishlist"
                >
                  <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                </button>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- BESTSELLING STYLES --}}
    @if(($section->section_id === 'popular_pieces_jewellery' || $section->section_id === 'popular_pieces') && $section->is_active)
      <section id="bestselling-styles" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto overflow-hidden">
        <h2 class="font-heading text-2xl sm:text-4xl text-center text-[#f3d9ff] font-normal tracking-[0.2em] mb-10 sm:mb-14 uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
          {{ $section->title }}
        </h2>
        <div class="relative group">
          <button id="popular-prev" class="absolute -left-1 sm:-left-4 top-[40%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button id="popular-next" class="absolute -right-1 sm:-right-4 top-[40%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-md hover:shadow-lg hover:border-[#f3d9ff] transition-all duration-200 text-[#e8b3ff] opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
          <div class="swiper bestsell-swiper overflow-visible">
            <div class="swiper-wrapper">
              @foreach($section->products->take($section->limit) as $product)
              <div class="swiper-slide">
                <div class="group relative">
                    <a href="{{ route('front.product.detail', $product->slug) }}" class="block aspect-[3/4] bg-[#350047] overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                    </a>
                    <button
                        type="button"
                        class="wishlist-btn absolute top-3 right-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                        data-product-id="{{ $product->id }}"
                        aria-label="Add to wishlist"
                        title="Add to wishlist"
                    >
                        <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                    <div class="pt-4 px-1">
                        <h3 class="text-[11px] font-bold text-white uppercase tracking-wider mb-1 truncate">{{ $product->name }}</h3>
                        <p class="text-xs font-bold text-[#f3d9ff]">₹{{ number_format($product->price, 0) }}</p>
                    </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif
  @endforeach

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- CRAFTED LOVE VIDEO BANNER                      --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $craftedVideoProduct = collect($popularPieces ?? [])->merge(collect($newArrivals ?? []))
      ->first(fn($p) => !empty($p->video));

    $craftedVideoSrc = $craftedVideoProduct && !empty($craftedVideoProduct->video)
      ? asset('storage/' . $craftedVideoProduct->video)
      : '';

    $craftedVideoPoster = $craftedVideoProduct && !empty($craftedVideoProduct->image)
      ? asset('storage/' . $craftedVideoProduct->image)
      : asset('images/hero-slider/1.png');
  @endphp
  <section id="crafted-love-video" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8" style="background: radial-gradient(circle at 20% 20%, rgba(255,180,120,0.22), transparent 30%), radial-gradient(circle at 80% 20%, rgba(255,180,120,0.2), transparent 28%), radial-gradient(circle at 20% 80%, rgba(255,180,120,0.16), transparent 30%), radial-gradient(circle at 80% 80%, rgba(255,180,120,0.18), transparent 32%), linear-gradient(180deg, #4a0f47 0%, #2d0037 50%, #3a003f 100%);">
    <div class="max-w-[1200px] mx-auto text-center">
      <h2 class="font-heading text-3xl sm:text-5xl text-[#f7d7aa] leading-tight mb-3">Crafted with Love, Made for You ✨</h2>
      <p class="font-heading text-xl sm:text-3xl text-[#f2d8b6] mb-8">A glimpse into the artistry behind Avnee Collections</p>

      <div class="relative rounded-3xl overflow-hidden border-4 border-[#f0b77d] shadow-[0_0_40px_rgba(255,180,110,0.35)]">
        <img src="{{ $craftedVideoPoster }}" alt="Crafted with Love" class="w-full aspect-[16/9] object-cover" />
        <div class="absolute inset-0 bg-black/25"></div>
        <button type="button" id="crafted-video-play" data-video-src="{{ $craftedVideoSrc }}" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 inline-flex items-center gap-4 rounded-full border-2 border-[#f0c58f] bg-[#2a0e34]/70 px-6 sm:px-10 py-3 sm:py-4 text-[#f8d9aa] font-heading text-2xl sm:text-5xl uppercase tracking-[0.03em] hover:bg-[#3a1545]/80 transition-colors">
          <span class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#f0c58f] text-[#2a0e34] flex items-center justify-center text-lg sm:text-xl">▶</span>
          <span>Play Video</span>
        </button>
      </div>

      <p class="mt-8 font-heading text-2xl sm:text-5xl leading-[1.3] text-[#f2d8b6] max-w-[1100px] mx-auto">
        From delicate jewellery to adorable kidswear, every piece is thoughtfully curated to bring joy, beauty, and confidence into everyday moments.
      </p>
      <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="mt-7 inline-flex items-center justify-center rounded-lg border border-[#f0c58f] bg-[#f0c58f] px-8 sm:px-14 py-3 text-[#4a1d22] font-heading text-2xl sm:text-4xl tracking-[0.03em] uppercase hover:bg-[#ffd9a8] transition-colors">
        Shop Collection
      </a>
    </div>
  </section>

  <div id="crafted-video-modal" class="fixed inset-0 z-[260] hidden">
    <div id="crafted-video-backdrop" class="absolute inset-0 bg-black/80"></div>
    <div class="relative z-10 h-full w-full flex items-center justify-center p-4 sm:p-8">
      <div class="w-full max-w-[1100px] bg-black rounded-lg overflow-hidden border border-white/20">
        <div class="flex items-center justify-between px-4 py-3 bg-black/80">
          <p class="text-sm sm:text-base text-white tracking-[0.14em] uppercase">Crafted with Love</p>
          <button type="button" id="crafted-video-close" class="text-white text-sm sm:text-base uppercase tracking-[0.14em]">Close</button>
        </div>
        <video id="crafted-video-player" class="w-full aspect-video bg-black" controls playsinline></video>
      </div>
    </div>
  </div>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- SHOP THE LOOK (STUDIO-STYLE)                   --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $jewelleryLookbookVideos = collect($popularPieces ?? [])
      ->merge(collect($newArrivals ?? []))
      ->unique('id')
      ->take(8)
      ->map(function ($p) {
        return [
          'title' => $p->name,
          'cta' => route('front.product.detail', $p->slug),
          'src' => !empty($p->video) ? asset('storage/' . $p->video) : null,
          'poster' => !empty($p->image) ? asset('storage/' . $p->image) : asset('images/hero-slider/1.png'),
        ];
      })
      ->values();

    if ($jewelleryLookbookVideos->isEmpty()) {
      $jewelleryLookbookVideos = collect([
        ['title' => 'Jewellery Look 1', 'cta' => route('front.products.index', ['category' => 'jewellery-gallery']), 'src' => null, 'poster' => asset('images/hero-slider/1.png')],
        ['title' => 'Jewellery Look 2', 'cta' => route('front.products.index', ['category' => 'hair-accessories']), 'src' => null, 'poster' => asset('images/hero-slider/2.png')],
        ['title' => 'Jewellery Look 3', 'cta' => route('front.products.index', ['category' => 'jewellery-gallery']), 'src' => null, 'poster' => asset('images/hero-slider/3.png')],
      ]);
    }
  @endphp
  <section id="home-lookbook-jewellery" class="py-10 sm:py-14 bg-[#f2f2f2] border-t border-b border-gray-200">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="font-heading text-2xl sm:text-5xl text-center text-[#111827] font-normal tracking-tight mb-8">Shop The Look</h2>
    </div>

    <div class="relative max-w-[1060px] mx-auto px-2 sm:px-8" id="lookbook-stage-wrap-jw">
      <button id="lookbook-prev-jw" class="absolute left-0 sm:left-3 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/30">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
      </button>

      <div id="lookbook-stage-jw" class="lookbook-stage-jw pb-8">
        @foreach([-2, -1, 0, 1, 2] as $slot)
          <article class="look-slot-jw" data-slot="{{ $slot }}">
            <div class="look-slot-inner-jw relative overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
              <img class="lookbook-poster-jw absolute inset-0 w-full h-full object-cover" src="" alt="lookbook" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/10 to-transparent"></div>
              <div class="absolute left-3 right-3 bottom-3 text-center">
                <p class="lookbook-title-jw text-white text-xl sm:text-3xl font-semibold mb-2 truncate"></p>
                <a class="lookbook-link-jw inline-flex px-8 py-2 bg-black text-white text-xl font-semibold rounded-sm hover:bg-[#1f1f1f] transition-colors" href="#">View</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <button id="lookbook-next-jw" class="absolute right-0 sm:right-3 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/30">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
      </button>
    </div>

    <style>
      .lookbook-stage-jw {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        align-items: end;
        gap: 14px;
        padding: 8px 20px 18px;
      }
      .look-slot-jw,
      .look-slot-inner-jw {
        transition: transform 0.5s ease, opacity 0.5s ease;
      }
      .look-slot-inner-jw {
        min-height: 560px;
      }
      .look-slot-jw[data-slot="-2"] .look-slot-inner-jw,
      .look-slot-jw[data-slot="2"] .look-slot-inner-jw {
        transform: scale(0.9);
        opacity: 0.36;
        z-index: 1;
      }
      .look-slot-jw[data-slot="-1"] .look-slot-inner-jw,
      .look-slot-jw[data-slot="1"] .look-slot-inner-jw {
        transform: scale(0.94);
        opacity: 0.72;
        z-index: 4;
      }
      .look-slot-jw[data-slot="0"] .look-slot-inner-jw {
        transform: scale(1.08);
        opacity: 1;
        z-index: 10;
      }
      #lookbook-stage-jw.is-swapping .look-slot-inner-jw {
        transition-duration: 0.28s;
      }
      @media (max-width: 767px) {
        #home-lookbook-jewellery { padding-top: 2.25rem; padding-bottom: 2.25rem; }
        #home-lookbook-jewellery h2 { font-size: 2rem; margin-bottom: 1.1rem; }
        #lookbook-stage-wrap-jw { padding-left: 0.6rem; padding-right: 0.6rem; }
        .lookbook-stage-jw { grid-template-columns: repeat(3, minmax(0, 1fr)); padding: 8px 4px 14px; gap: 10px; }
        .look-slot-inner-jw { min-height: 360px; }
        .look-slot-jw[data-slot="-2"], .look-slot-jw[data-slot="2"] { display: none; }
        #lookbook-prev-jw, #lookbook-next-jw { width: 42px; height: 42px; top: 52%; }
        #lookbook-prev-jw { left: -4px; }
        #lookbook-next-jw { right: -4px; }
        .lookbook-title-jw { font-size: 1.1rem; }
        .lookbook-link-jw { font-size: 1.1rem; padding: 0.35rem 1.5rem; }
      }
    </style>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- BRAND EXPERIENCES (EDITORIAL SLIDER)           --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if(isset($brandExperiences) && $brandExperiences->isNotEmpty())
  <section id="brand-experiences" class="py-0 max-w-[1440px] mx-auto px-0 relative group bg-[#2B003A]">
    <div class="overflow-visible">
    <div class="swiper brand-experience-swiper h-full">
      <div class="swiper-wrapper h-full">
        @foreach($brandExperiences as $exp)
        <div class="swiper-slide h-auto flex items-center justify-center py-8">
          <div class="bg-[#2B003A] w-full max-w-[1240px] mx-auto p-6 sm:p-12 lg:p-16 relative">
            <h2 class="font-heading text-xl sm:text-2xl text-center text-[#f3d9ff]/50 font-normal tracking-[0.3em] mb-6 sm:mb-10 uppercase">{{ $exp->title }}</h2>
            @if($exp->layout_type == 'layout_1')
              {{-- LAYOUT 1: LEFT LARGE, MIDDLE STACKED, RIGHT TEXT --}}
              <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
                <!-- Col 1: Large Image (Decreased) -->
                <div class="lg:col-span-4">
                  <div class="relative group/img overflow-hidden rounded-sm shadow-2xl border border-[#4f006a]">
                    <img src="{{ asset('storage/'.$exp->image_1) }}" class="w-full aspect-[3/4] object-cover transition-transform duration-1000 group-hover/img:scale-105" />
                    @if($exp->image_1_label)
                      <p class="mt-4 text-center text-sm font-medium text-[#f3d9ff] tracking-wide uppercase">{{ $exp->image_1_label }}</p>
                    @endif
                  </div>
                </div>

                <!-- Col 2: Stacked Images (Decreased) -->
                <div class="lg:col-span-3 space-y-8">
                  @if($exp->image_2)
                    <div class="relative group/img overflow-hidden rounded-sm shadow-xl border border-[#4f006a]">
                      <img src="{{ asset('storage/'.$exp->image_2) }}" class="w-full aspect-square object-cover transition-transform duration-1000 group-hover/img:scale-105" />
                      @if($exp->image_2_label)
                        <p class="mt-3 text-center text-xs font-medium text-[#e9d5ff]/70 uppercase">{{ $exp->image_2_label }}</p>
                      @endif
                    </div>
                  @endif
                  @if($exp->image_3)
                    <div class="relative group/img overflow-hidden rounded-sm shadow-xl border border-[#4f006a]">
                      <img src="{{ asset('storage/'.$exp->image_3) }}" class="w-full aspect-[4/3] object-cover transition-transform duration-1000 group-hover/img:scale-105" />
                      @if($exp->image_3_label)
                        <p class="mt-3 text-center text-xs font-medium text-[#e9d5ff]/70 uppercase">{{ $exp->image_3_label }}</p>
                      @endif
                    </div>
                  @endif
                </div>

                <!-- Col 3: Content (Increased) -->
                <div class="lg:col-span-5 text-left lg:pl-8 flex flex-col justify-center">
                  <h3 class="font-heading text-4xl sm:text-5xl font-normal text-white mb-6 leading-tight drop-shadow-lg">{{ $exp->content_title }}</h3>
                  <p class="text-[#e9d5ff] text-base leading-relaxed mb-10 font-light italic">{{ $exp->content_description }}</p>
                  <a href="{{ $exp->button_link }}" class="group/btn inline-flex items-center gap-4 bg-[#f3d9ff] text-[#2B003A] text-[10px] font-black tracking-[0.3em] uppercase px-12 py-5 hover:bg-white transition-all shadow-xl rounded-sm">
                    {{ $exp->button_text }}
                    <span class="material-symbols-outlined text-sm transition-transform group-hover/btn:translate-x-1">north_east</span>
                  </a>
                </div>
              </div>
            @elseif($exp->layout_type == 'layout_2')
              {{-- LAYOUT 2: LEFT TEXT, RIGHT GRID 4 --}}
              <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Col 1: Content -->
                <div class="lg:col-span-7 text-left order-2 lg:order-1 flex flex-col justify-center py-10">
                   <h3 class="font-heading text-4xl sm:text-5xl font-normal text-white mb-6 leading-tight drop-shadow-lg">{{ $exp->content_title }}</h3>
                   <p class="text-[#e9d5ff] text-base leading-relaxed mb-10 font-light italic">{{ $exp->content_description }}</p>
                   <a href="{{ $exp->button_link }}" class="group/btn inline-flex items-center gap-4 bg-[#f3d9ff] text-[#2B003A] text-[10px] font-black tracking-[0.3em] uppercase px-12 py-5 hover:bg-white transition-all shadow-xl rounded-sm w-max">
                     {{ $exp->button_text }}
                     <span class="material-symbols-outlined text-sm transition-transform group-hover/btn:translate-x-1">north_east</span>
                   </a>
                </div>

                <!-- Col 2: Grid of 4 -->
                <div class="lg:col-span-5 grid grid-cols-2 gap-6 sm:gap-8 order-1 lg:order-2">
                  @foreach(['image_1', 'image_2', 'image_3', 'image_4'] as $idx)
                    @php $imgField = $idx; $labelField = $idx.'_label'; @endphp
                    @if($exp->$imgField)
                    <div class="space-y-3">
                      <div class="relative overflow-hidden rounded-sm shadow-xl border border-[#4f006a] group/img">
                         <img src="{{ asset('storage/'.$exp->$imgField) }}" class="w-full aspect-square object-cover transition-transform duration-1000 group-hover/img:scale-110" />
                      </div>
                      @if($exp->$labelField)
                        <p class="text-[8px] sm:text-[10px] font-bold text-[#e9d5ff]/50 uppercase tracking-widest text-center mt-3">{{ $exp->$labelField }}</p>
                      @endif
                    </div>
                    @endif
                  @endforeach
                </div>
              </div>
            @else
              {{-- LAYOUT 3: SPLIT GRID (ORIGINAL STYLE) --}}
              <div class="flex flex-col lg:flex-row items-stretch h-full overflow-hidden">
                <!-- Images Area (58%) -->
                <div class="w-full lg:w-[58%] p-0 lg:pr-10 h-auto">
                  <div class="grid grid-cols-[3.8fr_5fr] gap-3 sm:gap-4 lg:gap-5 h-full">
                    <div class="relative bg-black overflow-hidden rounded-sm min-h-[300px]">
                      @if($exp->image_1 && (str_ends_with($exp->image_1, '.mp4') || str_ends_with($exp->image_1, '.mov')))
                        <video src="{{ asset('storage/'.$exp->image_1) }}" class="absolute inset-0 w-full h-full object-cover object-top" autoplay muted loop playsinline></video>
                      @else
                        <img src="{{ asset('storage/'.$exp->image_1) }}" class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-1000 hover:scale-110" />
                      @endif
                    </div>
                    <div class="flex flex-col gap-3 sm:gap-4 lg:gap-5">
                      <div class="relative w-full pb-[80%] bg-black overflow-hidden rounded-sm">
                        @if($exp->image_2)
                          <img src="{{ asset('storage/'.$exp->image_2) }}" class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-1000 hover:scale-110" />
                        @endif
                      </div>
                      <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:gap-5 flex-1">
                        @if($exp->image_3)
                        <div class="relative w-full bg-black overflow-hidden rounded-sm min-h-[150px]">
                          <img src="{{ asset('storage/'.$exp->image_3) }}" class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-1000 hover:scale-110" />
                        </div>
                        @endif
                        @if($exp->image_4)
                        <div class="relative w-full bg-black overflow-hidden rounded-sm min-h-[150px]">
                          <img src="{{ asset('storage/'.$exp->image_4) }}" class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-1000 hover:scale-110" />
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Content Area (42%) -->
                <div class="w-full lg:w-[42%] flex flex-col items-center lg:items-start justify-center p-8 lg:p-14 text-center lg:text-left">
                  <p class="font-heading italic text-2xl text-[#f3d9ff] mb-2 opacity-80 underline underline-offset-8 decoration-[#f3d9ff]/30">{{ $exp->content_title }}</p>
                  <h3 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-normal tracking-[0.1em] text-white uppercase mb-6 leading-tight">{{ $exp->title }}</h3>
                  <p class="text-[#e9d5ff] text-base leading-relaxed mb-10 max-w-sm font-light italic">{{ $exp->content_description }}</p>
                  <a href="{{ $exp->button_link }}" class="group/btn inline-flex items-center gap-4 bg-[#f3d9ff] text-[#2B003A] text-[10px] font-black tracking-[0.3em] uppercase px-12 py-5 hover:bg-white transition-all rounded-sm shadow-xl">
                      {{ $exp->button_text }}
                      <span class="material-symbols-outlined text-sm transition-transform group-hover/btn:translate-x-1">north_east</span>
                  </a>
                </div>
              </div>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination !-bottom-12"></div>
    </div>
    </div>

    <!-- Navigation Buttons -->
    <button id="exp-prev" class="absolute -left-2 sm:left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-2xl text-[#f3d9ff] hover:border-[#f3d9ff] transition-all opacity-0 group-hover:opacity-100">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button id="exp-next" class="absolute -right-2 sm:right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 flex items-center justify-center bg-[#350047] border border-[#4f006a] rounded-full shadow-2xl text-[#f3d9ff] hover:border-[#f3d9ff] transition-all opacity-0 group-hover:opacity-100">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
  </section>
  @endif

  <div id="jewellery-explore-more">
    @include('partials.front.explore-grid', ['theme' => 'jewellery'])
  </div>
  <div id="jewellery-read-blog">
    @include('partials.front.blog-section')
  </div>
  <div id="jewellery-reviews">
    @include('partials.front.reviews')
  </div>
  <div id="jewellery-about-story">
    @include('partials.front.about_story')
  </div>

  </div>

  <style>
    .jewellery-home-sequence {
      --jw-top: #4B0082;
      --jw-body: #300E54;
      --jw-text: #A47DAB;
      color: var(--jw-text);
      background: var(--jw-body);
    }

    .jewellery-home-sequence {
      display: flex;
      flex-direction: column;
    }

    .jewellery-home-sequence section {
      background-color: var(--jw-body) !important;
      color: var(--jw-text) !important;
      border-color: rgba(164, 125, 171, 0.25) !important;
      border-bottom: 1px solid rgba(212, 175, 55, 0.45) !important;
    }

    .jewellery-home-sequence h1,
    .jewellery-home-sequence h2,
    .jewellery-home-sequence h3,
    .jewellery-home-sequence h4,
    .jewellery-home-sequence p,
    .jewellery-home-sequence span,
    .jewellery-home-sequence a {
      color: var(--jw-text) !important;
    }

    /* Keep ordering deterministic for all direct blocks */
    .jewellery-home-sequence > * { order: 50; }

    .jewellery-home-sequence > #hero-slider { order: 0; }

    /* Requested jewellery homepage sequence */
    .jewellery-home-sequence > #just-in-launches { order: 1; }         /* Just in */
    .jewellery-home-sequence > #shop-by-price-static { order: 2; }     /* Shop By Price */
    .jewellery-home-sequence > #flash-sale { order: 3; }               /* Sale */
    .jewellery-home-sequence > #shop-by-style-static { order: 4; }     /* Shop by Category */
    .jewellery-home-sequence > #home-featured-collections { order: 5; } /* Our Collections */
    .jewellery-home-sequence > #trending-now-static { order: 6; }      /* Trending Now */
    .jewellery-home-sequence > #crafted-love-video { order: 7; }       /* Video */
    .jewellery-home-sequence > #home-lookbook-jewellery { order: 8; }  /* Shop by look */
    .jewellery-home-sequence > #shop-the-look { order: 26; }           /* Admin Shop by look */
    .jewellery-home-sequence > #brand-experiences { order: 9; }        /* Handcrafted */
    .jewellery-home-sequence > #jewellery-explore-more { order: 10; }  /* Explore More */
    .jewellery-home-sequence > #jewellery-read-blog { order: 11; }     /* Read our Blog */

    /* Remaining sections kept after requested flow */
    .jewellery-home-sequence > #top-collections { order: 20; }
    .jewellery-home-sequence > #combo-deals { order: 21; }
    .jewellery-home-sequence > #just-in { order: 22; }
    .jewellery-home-sequence > #shop-by-price { order: 23; }
    .jewellery-home-sequence > #shop-by-style { order: 24; }
    .jewellery-home-sequence > #bestselling-styles { order: 25; }
    .jewellery-home-sequence > #jewellery-reviews { order: 30; }
    .jewellery-home-sequence > #jewellery-about-story { order: 31; }
  </style>

@endsection

@push('scripts')
<script>
  window.__AVNEE_CUSTOM_SWIPERS__ = true;

    document.addEventListener('DOMContentLoaded', function() {
        const Swiper = window.Swiper;
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper bundle did not load; skipping jewellery sliders.');
            return;
        }

        const bestBuysEl = document.querySelector('.best-buys-swiper');
        if (bestBuysEl && bestBuysEl.swiper) {
            bestBuysEl.swiper.destroy(true, true);
        }

        const heroEl = document.querySelector('.hero-swiper');
        if (heroEl) {
          if (heroEl.swiper) {
            heroEl.swiper.destroy(true, true);
          }

          new Swiper('.hero-swiper', {
            loop: heroEl.querySelectorAll('.swiper-slide').length > 1,
            speed: 800,
            autoplay: {
              delay: 5000,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            navigation: {
              prevEl: '#hero-prev',
              nextEl: '#hero-next',
            },
            pagination: {
              el: '#hero-pagination',
              clickable: true,
            },
          });
        }

        new Swiper('.best-buys-swiper', {
            loop: true,
            speed: 600,
            slidesPerView: 1.2,
            spaceBetween: 12,
            centeredSlides: false,
            watchOverflow: true,
            autoplay: {
              delay: 2600,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            },
            navigation: { nextEl: '#best-buys-next', prevEl: '#best-buys-prev' },
            breakpoints: {
              640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 16 },
              768: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 20 },
              1024: { slidesPerView: 4, slidesPerGroup: 4, spaceBetween: 20 }
            }
        });
        new Swiper('.trending-now-swiper', {
            loop: true,
            speed: 3800,
            slidesPerView: 1.1,
            spaceBetween: 14,
            navigation: { nextEl: '#trending-next', prevEl: '#trending-prev' },
            watchOverflow: true,
            allowTouchMove: true,
            autoplay: {
              delay: 0,
              disableOnInteraction: false,
              pauseOnMouseEnter: false,
            },
            breakpoints: {
              640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 16 },
              1024: { slidesPerView: 4, slidesPerGroup: 1, spaceBetween: 20 }
            }
        });
        new Swiper('.flash-swiper', {
            slidesPerView: 2, spaceBetween: 12,
            navigation: { nextEl: '#flash-next', prevEl: '#flash-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 3, spaceBetween: 15 }, 1024: { slidesPerView: 5, spaceBetween: 20 } }
        });
        if (document.querySelector('.just-in-swiper')) {
          new Swiper('.just-in-swiper', {
            loop: true,
            speed: 650,
            slidesPerView: 1,
            spaceBetween: 12,
            autoplay: {
              delay: 4200,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            },
            navigation: {
              prevEl: '#just-in-prev',
              nextEl: '#just-in-next',
            },
            pagination: {
              el: '#just-in-pagination',
              clickable: true,
            },
            breakpoints: {
              640: { slidesPerView: 2, spaceBetween: 14 },
              1024: { slidesPerView: 2, spaceBetween: 18 }
            },
          });
        }
        const lookbookStageJw = document.getElementById('lookbook-stage-jw');
        const lookbookPrevJw = document.getElementById('lookbook-prev-jw');
        const lookbookNextJw = document.getElementById('lookbook-next-jw');
        if (lookbookStageJw && lookbookPrevJw && lookbookNextJw) {
          const lookbookItemsJw = @json($jewelleryLookbookVideos);
          const slotsJw = Array.from(lookbookStageJw.querySelectorAll('.look-slot-jw'));
          const offsetsJw = [-2, -1, 0, 1, 2];
          let centerIndexJw = Math.min(2, Math.max(0, lookbookItemsJw.length - 1));
          let isSwappingJw = false;

          const modJw = (n, m) => ((n % m) + m) % m;

          const renderSlotsJw = () => {
            slotsJw.forEach((slot, slotIndex) => {
              const offset = offsetsJw[slotIndex];
              const data = lookbookItemsJw[modJw(centerIndexJw + offset, lookbookItemsJw.length)];
              const posterEl = slot.querySelector('.lookbook-poster-jw');
              const titleEl = slot.querySelector('.lookbook-title-jw');
              const linkEl = slot.querySelector('.lookbook-link-jw');

              slot.setAttribute('data-slot', String(offset));
              posterEl.src = data.poster;
              posterEl.alt = data.title;
              titleEl.textContent = data.title;
              linkEl.setAttribute('href', data.cta);
            });
          };

          const swapJw = (direction) => {
            if (isSwappingJw || lookbookItemsJw.length < 2) return;
            isSwappingJw = true;
            lookbookStageJw.classList.add('is-swapping');

            setTimeout(() => {
              centerIndexJw = modJw(centerIndexJw + direction, lookbookItemsJw.length);
              renderSlotsJw();
            }, 120);

            setTimeout(() => {
              lookbookStageJw.classList.remove('is-swapping');
              isSwappingJw = false;
            }, 320);
          };

          lookbookPrevJw.addEventListener('click', () => swapJw(-1));
          lookbookNextJw.addEventListener('click', () => swapJw(1));

          let touchStartXJw = 0;
          let touchEndXJw = 0;
          lookbookStageJw.addEventListener('touchstart', (event) => {
            touchStartXJw = event.changedTouches[0].clientX;
          }, { passive: true });
          lookbookStageJw.addEventListener('touchend', (event) => {
            touchEndXJw = event.changedTouches[0].clientX;
            const delta = touchEndXJw - touchStartXJw;
            if (Math.abs(delta) < 28) return;
            if (delta > 0) swapJw(-1);
            if (delta < 0) swapJw(1);
          }, { passive: true });

          renderSlotsJw();
        }

        const craftedPlayBtn = document.getElementById('crafted-video-play');
        const craftedModal = document.getElementById('crafted-video-modal');
        const craftedBackdrop = document.getElementById('crafted-video-backdrop');
        const craftedClose = document.getElementById('crafted-video-close');
        const craftedPlayer = document.getElementById('crafted-video-player');

        const closeCraftedModal = () => {
          if (!craftedModal || !craftedPlayer) return;
          craftedModal.classList.add('hidden');
          craftedPlayer.pause();
          craftedPlayer.removeAttribute('src');
          craftedPlayer.load();
        };

        if (craftedPlayBtn && craftedModal && craftedPlayer) {
          craftedPlayBtn.addEventListener('click', () => {
            const src = craftedPlayBtn.getAttribute('data-video-src') || '';
            if (!src) return;
            craftedPlayer.src = src;
            craftedModal.classList.remove('hidden');
            craftedPlayer.play().catch(() => {});
          });
        }

        if (craftedBackdrop) {
          craftedBackdrop.addEventListener('click', closeCraftedModal);
        }
        if (craftedClose) {
          craftedClose.addEventListener('click', closeCraftedModal);
        }

        if (document.querySelector('#shop-look-swiper')) {
          new Swiper('#shop-look-swiper', {
              grabCursor: true,
              centeredSlides: true,
              loop: true,
              loopedSlides: 2,
              slidesPerView: 3,
            spaceBetween: 18,
              breakpoints: {
              640: {
                slidesPerView: 3,
                spaceBetween: 18,
              },
              768: {
                slidesPerView: 3,
                spaceBetween: 20,
              },
                  1024: {
                slidesPerView: 5,
                spaceBetween: 24,
              },
              },
              navigation: { nextEl: '#look-next', prevEl: '#look-prev' },
              pagination: { el: '.swiper-pagination', clickable: true },
          });
        }
        new Swiper('.combo-swiper', {
            slidesPerView: 1, spaceBetween: 16,
            navigation: { nextEl: '#combo-next', prevEl: '#combo-prev' },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 2, spaceBetween: 20 }, 1024: { slidesPerView: 3, spaceBetween: 30 } }
        });
        new Swiper('.style-swiper', {
            slidesPerView: 2, spaceBetween: 16,
            navigation: { nextEl: '#style-next', prevEl: '#style-prev' },
            watchOverflow: true,
            breakpoints: { 480: { slidesPerView: 3, spaceBetween: 20 }, 768: { slidesPerView: 4, spaceBetween: 24 }, 1024: { slidesPerView: 4, spaceBetween: 30 } }
        });
        new Swiper('.style-static-swiper', {
          slidesPerView: 1.2, spaceBetween: 12,
          navigation: { nextEl: '#style-static-next', prevEl: '#style-static-prev' },
          watchOverflow: true,
          breakpoints: { 640: { slidesPerView: 2.2, spaceBetween: 16 }, 1024: { slidesPerView: 4, spaceBetween: 20 } }
        });
        new Swiper('.top-col-swiper', {
            slidesPerView: 1, spaceBetween: 16,
            navigation: { nextEl: '#top-col-next', prevEl: '#top-col-prev' },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 2, spaceBetween: 20 }, 1024: { slidesPerView: 3, spaceBetween: 30 } }
        });
        new Swiper('.bestsell-swiper', {
            slidesPerView: 2, spaceBetween: 12,
            navigation: { nextEl: '#popular-next', prevEl: '#popular-prev' },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 3, spaceBetween: 16 }, 1024: { slidesPerView: 5, spaceBetween: 20 } }
        });
        new Swiper('.brand-experience-swiper', {
            slidesPerView: 1,
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: { nextEl: '#exp-next', prevEl: '#exp-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
        });

        document.querySelectorAll('.hover-video').forEach((videoEl) => {
          videoEl.addEventListener('mouseenter', () => videoEl.play());
          videoEl.addEventListener('mouseleave', () => videoEl.pause());
        });
    });
</script>
@endpush
