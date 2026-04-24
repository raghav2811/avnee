@extends('layouts.front.studio')
@section('content')

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- HERO SLIDER                                    --}}
  {{-- ═══════════════════════════════════════════════ --}}
  <section id="hero-slider" class="relative w-full px-4 sm:px-6 lg:px-8 pt-4">
    <div class="max-w-[1440px] mx-auto">
      <div class="swiper hero-swiper bg-[#2B003A] aspect-[17/10] overflow-hidden">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href="{{ route('front.products.index', ['sort' => 'newest']) }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/summer-classics.png') }}" alt="Summer Classics" class="w-full h-full object-cover" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="{{ route('front.products.index') }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/birthday.png') }}" alt="Birthday Glam" class="w-full h-full object-cover" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="{{ route('front.products.index', ['sort' => 'newest']) }}" class="block w-full h-full">
            <img src="{{ asset('images/hero-slider/ugadi-sale.png') }}" alt="Ugadi Sale" class="w-full h-full object-cover" />
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
  {{-- JUST IN (NEW LAUNCHES SLIDER)                  --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $justInLaunchSlides = [
      [
        'image' => asset('images/just-in/Picture1.png'),
        'link' => route('front.sale'),
        'alt' => 'Just in new launches 1',
      ],
      [
        'image' => asset('images/just-in/Picture2.png'),
        'link' => route('front.sale'),
        'alt' => 'Just in new launches 2',
      ],
    ];
  @endphp
  <section id="just-in" class="relative w-full px-4 sm:px-6 lg:px-8 py-8 sm:py-10 bg-[#FCEFF5] border-y border-[#d5d5d5]">
    <div class="max-w-[1320px] mx-auto">
      <h2 class="studio-section-heading mb-6 sm:mb-8">Just in</h2>
      <div class="swiper just-in-swiper overflow-hidden">
        <div class="swiper-wrapper">
          @foreach($justInLaunchSlides as $slide)
            <div class="swiper-slide">
              <a href="{{ $slide['link'] }}" class="block w-full border border-[#2B003A]/25 bg-white shadow-sm overflow-hidden">
                <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] }}" class="w-full aspect-[16/10] object-cover" />
              </a>
            </div>
          @endforeach
        </div>
        <div class="swiper-button-prev" id="just-in-prev"></div>
        <div class="swiper-button-next" id="just-in-next"></div>
        <div class="swiper-pagination" id="just-in-pagination"></div>
      </div>
    </div>
  </section>


  {{-- ═══════════════════════════════════════════════ --}}
  {{-- BEST BUY (STATIC)                              --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $bestBuyCards = [
      [
        'title' => 'Shimmer Silver Party Dress',
        'description' => 'Elegant sleeveless shimmer dress with a soft pleated skirt',
        'price' => 699,
        'image' => asset('images/best-buy/shimmer-silver-party-dress.png'),
      ],
      [
        'title' => 'Glam Black Sequin Dress',
        'description' => 'Stylish sequin dress with a statement overlay and sling bag detail',
        'price' => 699,
        'image' => asset('images/best-buy/glam-black-sequin-dress.png'),
      ],
      [
        'title' => 'Casual Chic Denim Set',
        'description' => 'Trendy shirt & denim combo for everyday stylish looks',
        'price' => 699,
        'image' => asset('images/best-buy/casual-chic-denim-set.png'),
      ],
      [
        'title' => 'Ethnic Charm Festive Dress',
        'description' => 'Traditional printed dress with rich colors for festive wear',
        'price' => 599,
        'image' => asset('images/best-buy/ethnic-charm-festive-dress.png'),
      ],
      [
        'title' => 'Classic Peach Layered Frock',
        'description' => 'Elegant layered tulle dress for special occasions',
        'price' => 349,
        'image' => asset('images/best-buy/classic-peach-layered-frock.png'),
      ],
      [
        'title' => 'Floral Garden Party Dress',
        'description' => 'Soft printed frock perfect for outdoor playdates & birthdays',
        'price' => 449,
        'image' => asset('images/best-buy/floral-garden-party-dress.png'),
      ],
      [
        'title' => 'Twinkle Pink Party Dress',
        'description' => 'Charming dual-tone dress with a shimmer bodice and layered tulle skirt',
        'price' => 599,
        'image' => asset('images/best-buy/twinkle-pink-party-dress.png'),
      ],
      [
        'title' => 'Blush Bloom Ethnic Set',
        'description' => 'Elegant floral printed kurta set with soft frill detailing, perfect for festive and traditional wear',
        'price' => 699,
        'image' => asset('images/best-buy/blush-bloom-ethnic-set.png'),
      ],
    ];
    $bestBuyProductIds = \App\Models\Product::query()
      ->whereIn('slug', collect($bestBuyCards)->map(fn ($card) => \Illuminate\Support\Str::slug($card['title']))->all())
      ->pluck('id', 'slug');
  @endphp
  <section id="best-buy-static" class="py-10 sm:py-14 bg-[#FCEFF5] border-b border-gray-200">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col items-center justify-center text-center gap-3 mb-6">
        <h2 class="studio-section-heading">Best Buy</h2>
      </div>

      <div class="relative group">
        <button id="bestbuy-static-prev" class="absolute -left-2 sm:-left-5 top-[42%] -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/20">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="bestbuy-static-next" class="absolute -right-2 sm:-right-5 top-[42%] -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/20">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>

        <div class="swiper best-buy-static-swiper overflow-hidden rounded-xl">
          <div class="swiper-wrapper">
            @foreach($bestBuyCards as $card)
              @php $cardSlug = Illuminate\Support\Str::slug($card['title']); @endphp
              <div class="swiper-slide p-1">
                <article onclick="navigateToBestBuys('{{ $cardSlug }}')" class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-[520px] cursor-pointer transition-transform duration-200 hover:-translate-y-1 flex flex-col">
                  <div class="relative aspect-[3/4] overflow-hidden bg-gray-100 flex-shrink-0">
                    <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy" class="w-full h-full object-cover" />
                    @if(isset($bestBuyProductIds[$cardSlug]))
                      <button
                        type="button"
                        class="wishlist-btn absolute top-3 left-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white"
                        data-product-id="{{ $bestBuyProductIds[$cardSlug] }}"
                        aria-label="Add to wishlist"
                        title="Add to wishlist"
                      >
                        <svg class="wishlist-icon mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                      </button>
                    @endif
                  </div>
                  <div class="p-3 sm:p-4 flex-1 flex flex-col">
                    <h3 class="text-lg sm:text-xl font-bold text-[#141414] leading-tight line-clamp-2 mb-1">{{ $card['title'] }}</h3>
                    <p class="text-sm sm:text-base text-[#3b3b3b] leading-snug line-clamp-2 mb-2 flex-1">{{ $card['description'] }}</p>
                    <p class="text-sm font-semibold uppercase tracking-[0.14em] text-[#C75B6E]">Price</p>
                    <p class="text-2xl font-black text-[#C75B6E]">₹{{ number_format($card['price'], 0) }}</p>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    function navigateToBestBuys(slug) {
      if (!slug) return;
      window.location.href = '{{ route('front.best-buys') }}/' + encodeURIComponent(slug);
    }
  </script>


  {{-- ═══════════════════════════════════════════════ --}}
  {{-- SHOP THE LOOK (VIDEO SLIDER)                   --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $lookbookVideoFiles = [
      'ScreenRecorderProject588.mkv',
      'ScreenRecorderProject589.mkv',
      'ScreenRecorderProject590.mkv',
      'ScreenRecorderProject591.mkv',
      'ScreenRecorderProject592.mkv',
      'ScreenRecorderProject593.mkv',
      'ScreenRecorderProject594.mkv',
    ];
    $lookbookProducts = \App\Models\Product::query()
      ->whereNotNull('slug')
      ->orderByDesc('id')
      ->limit(count($lookbookVideoFiles))
      ->get(['slug', 'name', 'image'])
      ->values();
    $defaultLookbookPoster = asset('images/top-collections/summer-collections.png');
    $lookbookVideos = collect($lookbookVideoFiles)->map(function ($fileName, $idx) use ($lookbookProducts, $defaultLookbookPoster) {
      $product = $lookbookProducts->get($idx);
      $productImage = $product?->image;
      $poster = $productImage ? asset('storage/' . ltrim($productImage, '/')) : $defaultLookbookPoster;
      return [
        'title' => $product?->name ?? 'Shop The Look',
        'cta' => $product?->slug ? route('front.product.detail', $product->slug) : route('front.products.index', ['sort' => 'newest']),
        'src' => asset('videos/shop-the-look/' . $fileName),
        'poster' => $poster,
      ];
    })->all();
  @endphp
  <section id="home-lookbook" class="py-10 sm:py-14 bg-[#FCEFF5] border-t border-b border-gray-200">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="studio-section-heading mb-8">Shop The Look</h2>
    </div>

    <div class="relative max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8" id="lookbook-stage-wrap">
      <button id="lookbook-prev" class="absolute left-0 sm:left-3 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/30">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
      </button>

      <div id="lookbook-stage" class="lookbook-stage pb-8">
        @foreach([-2, -1, 0, 1, 2] as $slot)
          <article class="look-slot" data-slot="{{ $slot }}">
            <div class="look-slot-inner relative overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
              <video class="lookbook-video absolute inset-0 w-full h-full object-cover" muted loop playsinline preload="metadata" poster=""></video>
              <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/10 to-transparent"></div>
              <div class="absolute left-3 right-3 bottom-3 text-center">
                <p class="lookbook-title text-white text-xl sm:text-3xl font-semibold mb-2 truncate"></p>
                <a class="lookbook-link inline-flex px-8 py-2 bg-black text-white text-xl font-semibold rounded-sm hover:bg-[#1f1f1f] transition-colors" href="#">View</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <button id="lookbook-next" class="absolute right-0 sm:right-3 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/35 hover:bg-black text-white flex items-center justify-center transition-colors border border-white/30">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
      </button>
    </div>

    <style>
      .lookbook-stage {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        align-items: end;
        gap: 18px;
        padding: 8px 12px 18px;
      }
      .look-slot,
      .look-slot-inner {
        transition: transform 0.5s ease, opacity 0.5s ease;
      }
      .look-slot-inner {
        min-height: 560px;
      }
      .look-slot[data-slot="-2"] .look-slot-inner,
      .look-slot[data-slot="2"] .look-slot-inner {
        transform: scale(0.9);
        opacity: 0.36;
        z-index: 1;
      }
      .look-slot[data-slot="-1"] .look-slot-inner,
      .look-slot[data-slot="1"] .look-slot-inner {
        transform: scale(0.94);
        opacity: 0.72;
        z-index: 4;
      }
      .look-slot[data-slot="0"] .look-slot-inner {
        transform: scale(1.08);
        opacity: 1;
        z-index: 10;
      }
      #lookbook-stage.is-swapping .look-slot-inner {
        transition-duration: 0.28s;
      }
      @media (max-width: 767px) {
        #home-lookbook {
          padding-top: 2.25rem;
          padding-bottom: 2.25rem;
        }
        #home-lookbook h2.studio-section-heading {
          margin-bottom: 1.1rem;
        }
        #lookbook-stage-wrap {
          padding-left: 1rem;
          padding-right: 1rem;
        }
        .lookbook-stage {
          grid-template-columns: minmax(0, 1fr);
          padding: 8px 4px 14px;
          gap: 0;
          max-width: 320px;
          margin: 0 auto;
        }
        .look-slot-inner {
          min-height: 0;
          aspect-ratio: 3 / 5;
        }
        .look-slot[data-slot="-1"],
        .look-slot[data-slot="1"],
        .look-slot[data-slot="-2"],
        .look-slot[data-slot="2"] { display: none; }
        .look-slot[data-slot="0"] .look-slot-inner {
          transform: scale(1);
        }
        #lookbook-prev,
        #lookbook-next {
          width: 42px;
          height: 42px;
          top: 52%;
        }
        #lookbook-prev {
          left: -4px;
        }
        #lookbook-next {
          right: -4px;
        }
        .lookbook-title { font-size: 1.1rem; }
        .lookbook-link { font-size: 1.1rem; padding: 0.35rem 1.5rem; }
      }
    </style>
  </section>


  {{-- ═══════════════════════════════════════════════ --}}
  {{-- TOP COLLECTIONS (PRIMARY POSITION)             --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $topCollections = [
      [
        'title' => 'Party Frocks',
        'button' => 'Explore Now',
        'link' => route('front.sale'),
        'image' => asset('images/top-collections/party-frocks.png'),
      ],
      [
        'title' => 'Summer Collections',
        'button' => 'Explore Now',
        'link' => route('front.products.collection', ['collection' => 'summer-collections']),
        'image' => asset('images/top-collections/summer-collections.png'),
      ],
      [
        'title' => 'Festive Collection',
        'button' => 'Explore Now',
        'link' => route('front.sale'),
        'image' => asset('images/top-collections/festive-collection.png'),
      ],
      [
        'title' => 'Daily Wear',
        'button' => 'Explore Now',
        'link' => route('front.products.collection', ['collection' => 'daily-wear']),
        'image' => asset('images/top-collections/daily-wear.png'),
      ],
    ];
  @endphp
  <section id="home-top-collections" class="py-10 sm:py-12 bg-[#FCEFF5] border-y border-[#f0dce2]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="studio-section-heading mb-8 sm:mb-12">
        Top Collection
      </h2>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
        @foreach($topCollections as $card)
          <article class="group relative overflow-hidden rounded-2xl bg-[#f3e3ea] shadow-sm">
            <a href="{{ $card['link'] }}" class="block relative aspect-[3/4]">
              <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/5 to-transparent"></div>
              <div class="absolute left-3 right-3 bottom-3 bg-[#f8f4f1]/90 backdrop-blur-sm rounded-xl px-3 py-3 text-center">
                <h3 class="font-heading text-xl sm:text-2xl leading-tight text-[#3a2c2c] mb-2">{{ $card['title'] }}</h3>
                <span class="inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-[#171717] rounded-md transition-colors duration-300 group-hover:bg-[#2d2d2d]">{{ $card['button'] }}</span>
              </div>
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </section>


  {{-- ═══════════════════════════════════════════════ --}}
  {{-- SHOP BY PRICE                                  --}}
  {{-- ═══════════════════════════════════════════════ --}}
  <section id="shop-by-price-static" class="py-12 sm:py-16 bg-[#FCEFF5]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="studio-section-heading mb-10 sm:mb-14">Shop by Price</h2>
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
  <section id="shop-by-style-static" class="py-12 sm:py-16 bg-[#FCEFF5]">
    <div class="w-full px-3 sm:px-4 lg:px-8 xl:px-10">
      <h2 class="studio-section-heading mb-10">Shop by Category</h2>
      @php
        $styleCards = [
          ['label' => 'Infant Sets', 'slug' => 'infant-sets', 'image' => 'images/shop-by-style/infant-sets.png'],
          ['label' => 'KIDS COLLECTIONS AGED 2 - 4 Yrs', 'slug' => '2-4-years', 'image' => 'images/shop-by-style/2-4-years.png'],
          ['label' => 'KIDS COLLECTIONS AGED 4 - 6 Yrs', 'slug' => '4-6-years', 'image' => 'images/shop-by-style/4-6-years.png'],
          ['label' => 'KIDS COLLECTIONS AGED 6 - 14 Yrs', 'slug' => '6-14-years', 'image' => 'images/shop-by-style/6-14-years.png'],
          ['label' => 'Festive Wear', 'slug' => 'festive-wear', 'image' => 'images/shop-by-style/festive-wear.png'],
          ['label' => 'Girls Daily-wear', 'slug' => 'girls-dresses', 'image' => 'images/shop-by-style/girls-dresses.png'],
          ['label' => 'Party Frocks', 'slug' => 'party-frocks', 'image' => 'images/shop-by-style/party-frocks.png'],
        ];
      @endphp
      <div class="grid w-full grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-x-5 sm:gap-x-7 lg:gap-x-10 xl:gap-x-12 gap-y-5 sm:gap-y-6">
        @foreach($styleCards as $styleCard)
          @php
            $styleImagePath = public_path($styleCard['image']);
            $styleImageVersion = file_exists($styleImagePath) ? filemtime($styleImagePath) : now()->timestamp;
          @endphp
          <a href="{{ route('front.products.index', ['category' => $styleCard['slug']]) }}" class="group block text-center">
            <div class="aspect-[4/5] bg-white overflow-hidden shadow-sm border border-[#2B003A]/10 hover:shadow-lg transition-all duration-300">
              <img src="{{ asset($styleCard['image']) . '?v=' . $styleImageVersion }}" alt="{{ $styleCard['label'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            </div>
            <p class="mt-3 text-xs sm:text-sm text-[#C75B6E] font-semibold tracking-[0.08em] uppercase">{{ $styleCard['label'] }}</p>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- FLASH SALE SECTION                             --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if(false && $activeFlashSale && $activeFlashSale->products->isNotEmpty())
  <section id="flash-sale" class="py-12 sm:py-16 bg-[#FCEFF5] border-y border-pastel-pink/20">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
        <div class="flex items-center gap-4">
          <svg class="w-10 h-10 text-mulberry animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          <div>
            <h2 class="studio-section-heading studio-section-heading--left studio-section-heading--flash">{{ $activeFlashSale->title }}</h2>
            <p class="text-gray-500 text-sm">Hurry up! Offers end in:</p>
          </div>
        </div>
        <div class="flex gap-4 sm:gap-6" id="flash-countdown" data-expire="{{ $activeFlashSale->end_time->toIso8601String() }}">
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-pastel-pink text-mulberry px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-days">00</span>
            <span class="text-[10px] uppercase font-bold text-pastel-pink/60 mt-1">Days</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-pastel-pink text-mulberry px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-hours">00</span>
            <span class="text-[10px] uppercase font-bold text-pastel-pink/60 mt-1">Hours</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-pastel-pink text-mulberry px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-mins">00</span>
            <span class="text-[10px] uppercase font-bold text-pastel-pink/60 mt-1">Mins</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold bg-white text-mulberry px-3 py-2 rounded shadow-sm min-w-[50px] text-center" id="cd-secs">00</span>
            <span class="text-[10px] uppercase font-bold text-pastel-pink/60 mt-1">Secs</span>
          </div>
        </div>
      </div>
      <div class="relative group">
        <button id="flash-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="flash-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
        <div class="swiper flash-swiper overflow-hidden">
          <div class="swiper-wrapper">
            @foreach($activeFlashSale->products as $product)
            <div class="swiper-slide px-1">
              <div class="group bg-[#F8C8DC] rounded-sm overflow-hidden border border-transparent hover:border-mulberry/10 transition-all shadow-sm">
                <a href="{{ route('front.product.detail', $product->slug) }}" class="relative block bg-gray-100 aspect-[3/4]">
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                  @php $discountPct = $product->pivot->discount_percentage ?? $product->discount; @endphp
                  @if($discountPct > 0)
                  <div class="absolute top-2 left-2 bg-mulberry text-pastel-pink text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider">
                    {{ $discountPct }}% OFF
                  </div>
                  @endif
                </a>
                <button
                  type="button"
                  class="wishlist-btn absolute top-3 left-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                  data-product-id="{{ $product->id }}"
                  aria-label="Add to wishlist"
                  title="Add to wishlist"
                >
                  <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                </button>
                <div class="p-3">
                  <h3 class="text-xs font-medium text-gray-800 line-clamp-1 mb-2">{{ $product->name }}</h3>
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-mulberry">₹{{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price > $product->price)
                    <span class="text-xs text-gray-400 line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="swiper-pagination !-bottom-1 mt-6"></div>
        </div>
      </div>
    </div>
  </section>
  @endif

  {{-- ═══════════════════════════════════════════════ --}}
  {{-- COMBO DEALS SECTION                            --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if(false && isset($combos) && $combos->count() > 0)
  <section id="combo-deals" class="py-12 sm:py-20 bg-[#FCEFF5] border-b border-pastel-pink/20">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
        <div>
          <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-mulberry mb-2 block">Curated Bundles</span>
          <h2 class="studio-section-heading studio-section-heading--split mb-8">Combo Deals</h2>
          <p class="text-gray-500 mt-3 max-w-lg">Hand-picked combinations for the perfect look, at an unbeatable value.</p>
        </div>
        <a href="{{ route('front.products.index') }}" class="px-8 py-3 bg-mulberry text-white text-xs font-bold uppercase tracking-[0.3em] hover:bg-mulberry-dark transition-all">Shop All Sets</a>
      </div>
      <div class="relative group">
        <button id="combo-prev" class="absolute -left-1 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="combo-next" class="absolute -right-1 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
        <div class="swiper combo-swiper overflow-hidden">
          <div class="swiper-wrapper">
            @foreach($combos as $combo)
            <div class="swiper-slide h-auto pb-4">
              <div class="group relative flex flex-col bg-[#F8C8DC] rounded-sm overflow-hidden hover:shadow-2xl transition-all duration-500 h-full border border-pastel-pink/20 mx-1">
                <div class="relative aspect-[16/10] overflow-hidden">
                  @if($combo->image)
                    <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                  @else
                    <img src="{{ asset('storage/' . $combo->products->first()->image) }}" alt="{{ $combo->title }}" class="w-full h-full object-cover grayscale brightness-75 transition-transform duration-1000 group-hover:scale-110" />
                  @endif
                  @if($combo->original_price > $combo->price)
                  <div class="absolute top-0 right-0 bg-mulberry text-pastel-pink px-4 py-2 text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg">
                    Save ₹{{ number_format($combo->original_price - $combo->price, 0) }}
                  </div>
                  @endif
                </div>
                <div class="p-8 flex-1 flex flex-col">
                  <div class="mb-6 flex-1">
                    <h3 class="font-heading text-2xl mb-4 group-hover:text-mulberry transition-colors uppercase tracking-wider leading-tight text-gray-900">{{ $combo->title }}</h3>
                    <div class="flex items-center gap-3">
                      <div class="flex -space-x-3 overflow-hidden">
                        @foreach($combo->products->take(4) as $cp)
                          <div class="inline-block h-12 w-12 rounded-full ring-4 ring-white overflow-hidden border border-gray-100">
                            <img src="{{ asset('storage/' . $cp->image) }}" class="h-full w-full object-cover" />
                          </div>
                        @endforeach
                      </div>
                      <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $combo->products->count() }} Item Set</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                    <div class="flex flex-col">
                      <span class="text-2xl font-bold text-gray-900">₹{{ number_format($combo->price, 2) }}</span>
                      @if($combo->original_price)
                      <span class="text-xs text-gray-400 line-through tracking-wider">₹{{ number_format($combo->original_price, 2) }}</span>
                      @endif
                    </div>
                    <button type="button" onclick="openComboModal('{{ $combo->id }}', '{{ number_format($combo->price, 2) }}');"
                      class="inline-flex items-center justify-center bg-mulberry text-pastel-pink px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-mulberry-dark transition-all rounded-sm shadow-sm active:scale-95">
                      Buy Now
                    </button>
                  </div>
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
  {{-- JUST IN                                        --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @if(isset($justInExperiences) && $justInExperiences->isNotEmpty())
  <section id="just-in" class="py-10 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto">
    <h2 class="studio-section-heading mb-8 sm:mb-12">
      Just In
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
      @foreach($justInExperiences->take(4) as $exp)
      <a href="{{ $exp->button_link }}" class="group relative block overflow-hidden aspect-[4/5] bg-gray-100 rounded-sm border border-mulberry/10">
        <img src="{{ asset('storage/' . $exp->image) }}" alt="{{ $exp->title }}" class="w-full h-full object-cover object-top transition-transform duration-700 ease-in-out group-hover:scale-110" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
        <div class="absolute bottom-0 inset-x-0 p-3 text-center">
          <p class="font-heading text-base sm:text-lg font-semibold text-white tracking-wide truncate">{{ $exp->title }}</p>
          <span class="inline-block mt-2 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] bg-white/90 text-mulberry opacity-0 group-hover:opacity-100 transition-opacity duration-300">Quick View</span>
        </div>
      </a>
      @endforeach
    </div>
  </section>
  @endif


  {{-- ═══════════════════════════════════════════════ --}}
  {{-- NEW IN JEWELLERY                               --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $newInJewelleryProducts = \App\Models\Product::query()
      ->where('brand_id', 2)
      ->where('is_active', true)
      ->latest()
      ->take(12)
      ->get();
  @endphp
  @if($newInJewelleryProducts->isNotEmpty())
  <section id="popular-pieces" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto overflow-hidden">
    <h2 class="studio-section-heading mb-8 sm:mb-10">
      New In Jewellery
    </h2>
    <div class="relative group">
      <button id="popular-prev" class="absolute -left-1 sm:-left-4 top-[40%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
      </button>
      <button id="popular-next" class="absolute -right-1 sm:-right-4 top-[40%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-pastel-pink border border-pastel-pink/20 rounded-full shadow-md hover:shadow-lg hover:border-white transition-all duration-200 text-mulberry opacity-0 group-hover:opacity-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
      </button>
      <div class="swiper new-in-jewellery-swiper overflow-visible">
        <div class="swiper-wrapper">
          @foreach($newInJewelleryProducts as $product)
          <div class="swiper-slide">
            <div class="group relative">
              <a href="{{ route('front.product.detail', $product->slug) }}" class="block aspect-[3/4] bg-mulberry overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
              </a>
              <button
                type="button"
                class="wishlist-btn absolute top-3 left-3 z-20 h-9 w-9 rounded-full border border-white/70 bg-white/90 text-gray-700 shadow-sm backdrop-blur transition hover:scale-105 hover:bg-white {{ $product->is_wishlisted ? 'text-red-500' : '' }}"
                data-product-id="{{ $product->id }}"
                aria-label="Add to wishlist"
                title="Add to wishlist"
              >
                <svg class="wishlist-icon mx-auto h-4 w-4 {{ $product->is_wishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </button>
              <div class="pt-4 px-1 text-center">
                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1 truncate">{{ $product->name }}</h3>
                <p class="text-xs font-bold text-mulberry">₹{{ number_format($product->price, 0) }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif


  {{-- ═══════════════════════════════════════════════ --}}
  <div class="relative left-1/2 -translate-x-1/2 w-screen h-[3px] bg-mulberry/35"></div>
  {{-- STUDIO EDITS SLIDER                            --}}
  {{-- ═══════════════════════════════════════════════ --}}
  @php
    $experiencePool = collect($brandExperiences ?? []);

    $funTrinketsExp = $experiencePool->first(function ($exp) {
      $haystack = strtolower(trim(((string) ($exp->title ?? '')) . ' ' . ((string) ($exp->content_title ?? '')) . ' ' . ((string) ($exp->content_description ?? '')) . ' ' . ((string) ($exp->button_link ?? ''))));
      return str_contains($haystack, 'trinket');
    });

    $hairAccessoriesExp = $experiencePool->first(function ($exp) {
      $haystack = strtolower(trim(((string) ($exp->title ?? '')) . ' ' . ((string) ($exp->content_title ?? '')) . ' ' . ((string) ($exp->content_description ?? '')) . ' ' . ((string) ($exp->button_link ?? ''))));
      return str_contains($haystack, 'hair') || str_contains($haystack, 'accessor');
    });

    if (!$funTrinketsExp) {
      $funTrinketsExp = $experiencePool->first();
    }
    if (!$hairAccessoriesExp) {
      $hairAccessoriesExp = $experiencePool->first(function ($exp) use ($funTrinketsExp) {
        return !$funTrinketsExp || (int) ($exp->id ?? 0) !== (int) ($funTrinketsExp->id ?? -1);
      });
    }

    $hairAccessoryTiles = [
      ['image' => 'images/hair-accessories/ha-1.jpeg'],
      ['image' => 'images/hair-accessories/ha-2.jpeg'],
      ['image' => 'images/hair-accessories/ha-3.jpeg'],
      ['image' => 'images/hair-accessories/ha-4.jpeg'],
    ];
  @endphp

  <section id="studio-edits-slider" class="py-12 sm:py-16 bg-[#FCEFF5]">
    <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="relative group">
        <button id="studio-edits-prev" class="absolute -left-1 sm:-left-4 top-[45%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-black/60 rounded-full text-white transition-all duration-200 hover:bg-black">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="studio-edits-next" class="absolute -right-1 sm:-right-4 top-[45%] -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-black/60 rounded-full text-white transition-all duration-200 hover:bg-black">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>

        <div class="swiper studio-edits-swiper overflow-hidden">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <h2 class="studio-section-heading mb-9 sm:mb-12">The Saree Edit</h2>
              <div class="bg-[#efe8e8] p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-[1.22fr_0.98fr] gap-3 sm:gap-4 lg:gap-6">
                <div class="grid grid-cols-[1.05fr_0.95fr] gap-3 sm:gap-4">
                  <div class="row-span-2">
                    <img src="{{ asset('images/saree-edit/1.webp') }}" alt="Saree Edit Look 1" class="w-full h-full object-cover object-top min-h-[360px] lg:min-h-[610px]" />
                  </div>
                  <div>
                    <img src="{{ asset('images/saree-edit/2.webp') }}" alt="Saree Edit Look 2" class="w-full h-full object-cover object-top min-h-[170px] lg:min-h-[246px]" />
                  </div>
                  <div class="grid grid-cols-2 gap-3 sm:gap-4 col-span-1">
                    <img src="{{ asset('images/saree-edit/3.webp') }}" alt="Saree Edit Look 3" class="w-full h-full object-cover object-top min-h-[185px] lg:min-h-[350px]" />
                    <img src="{{ asset('images/saree-edit/4.webp') }}" alt="Saree Edit Look 4" class="w-full h-full object-cover object-top min-h-[185px] lg:min-h-[350px]" />
                  </div>
                </div>
                <div class="flex items-center justify-center text-center px-2 sm:px-6 lg:px-10 py-6 sm:py-10">
                  <div class="max-w-[420px]">
                    <p class="font-heading italic text-4xl sm:text-5xl text-[#5f1f1f] mb-2">Introducing</p>
                    <h3 class="font-heading text-5xl sm:text-7xl lg:text-8xl text-[#5f1f1f] leading-[0.92] mb-6">INSTANT SAREE<span class="text-lg sm:text-xl align-top">TM</span></h3>
                    <a href="{{ route('front.sale') }}" class="inline-block bg-black text-white text-sm sm:text-base font-bold tracking-[0.04em] px-7 py-3.5 hover:bg-[#1f1f1f] transition-colors mb-8">PRE-DRAPE NOW</a>
                    <p class="text-gray-900 text-base sm:text-xl leading-snug">Any saree can now be pre-draped instantly</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <h2 class="studio-section-heading mb-9 sm:mb-12">{{ $funTrinketsExp->title ?? 'The Fun Trinkets Edit' }}</h2>
              <div class="bg-[#efe8e8] p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-[1.22fr_0.98fr] gap-3 sm:gap-4 lg:gap-6">
                <div class="grid grid-cols-[1.05fr_0.95fr] gap-3 sm:gap-4">
                  <div class="row-span-2">
                    <img src="{{ !empty($funTrinketsExp?->image_1) ? asset('storage/' . $funTrinketsExp->image_1) : asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.28 AM (1).jpeg') }}" alt="{{ $funTrinketsExp->image_1_label ?? ($funTrinketsExp->title ?? 'Fun Trinkets') }}" class="w-full h-full object-cover object-top min-h-[360px] lg:min-h-[610px]" />
                    @if(!empty($funTrinketsExp?->image_1_label))
                      <p class="mt-3 text-center text-2xl text-[#5f1f1f] font-medium">{{ $funTrinketsExp->image_1_label }}</p>
                    @endif
                  </div>
                  <div>
                    <img src="{{ !empty($funTrinketsExp?->image_2) ? asset('storage/' . $funTrinketsExp->image_2) : asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.27 AM (2).jpeg') }}" alt="{{ $funTrinketsExp->image_2_label ?? ($funTrinketsExp->title ?? 'Fun Trinkets') }}" class="w-full h-full object-cover object-top min-h-[170px] lg:min-h-[246px]" />
                  </div>
                  <div class="col-span-1">
                    <img src="{{ !empty($funTrinketsExp?->image_3) ? asset('storage/' . $funTrinketsExp->image_3) : asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.29 AM.jpeg') }}" alt="{{ $funTrinketsExp->image_3_label ?? ($funTrinketsExp->title ?? 'Fun Trinkets') }}" class="w-full h-full object-cover object-top min-h-[185px] lg:min-h-[350px]" />
                    @if(!empty($funTrinketsExp?->image_3_label))
                      <p class="mt-3 text-center text-2xl text-[#5f1f1f] font-medium">{{ $funTrinketsExp->image_3_label }}</p>
                    @endif
                  </div>
                </div>
                <div class="flex items-center justify-center text-left px-2 sm:px-6 lg:px-10 py-6 sm:py-10">
                  <div class="max-w-[420px]">
                    <h3 class="font-heading text-5xl sm:text-7xl text-[#5f1f1f] leading-[0.92] mb-6">{{ $funTrinketsExp->content_title ?? 'Discover Cute Trinkets!' }}</h3>
                    <p class="text-gray-900 text-base sm:text-xl leading-snug mb-8">{{ $funTrinketsExp->content_description ?? 'Explore an adorable selection of keychains and collectibles to brighten your day.' }}</p>
                    <a href="{{ route('front.sale') }}" class="inline-block bg-black text-white text-sm sm:text-base font-bold tracking-[0.04em] px-7 py-3.5 hover:bg-[#1f1f1f] transition-colors">{{ $funTrinketsExp->button_text ?? 'SHOP NOW' }}</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <h2 class="studio-section-heading mb-9 sm:mb-12">{{ $hairAccessoriesExp->title ?? 'The Hair Accessories Edit' }}</h2>
              <div class="bg-[#efe8e8] p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-[0.95fr_1.05fr] gap-3 sm:gap-4 lg:gap-6">
                <div class="flex items-center justify-center text-left px-2 sm:px-6 lg:px-10 py-6 sm:py-10">
                  <div class="max-w-[420px]">
                    <h3 class="font-heading text-5xl sm:text-7xl text-[#5f1f1f] leading-[0.92] mb-6">{{ $hairAccessoriesExp->content_title ?? 'Elevate Your Hairstyle!' }}</h3>
                    <p class="text-gray-900 text-base sm:text-xl leading-snug mb-8">{{ $hairAccessoriesExp->content_description ?? 'Explore charming hair accessories for girls and women to add a touch of beauty and fun to your look.' }}</p>
                    <a href="{{ route('front.sale') }}" class="inline-block bg-black text-white text-sm sm:text-base font-bold tracking-[0.04em] px-7 py-3.5 hover:bg-[#1f1f1f] transition-colors">{{ $hairAccessoriesExp->button_text ?? 'SHOP NOW' }}</a>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                  @foreach($hairAccessoryTiles as $tile)
                    <div>
                      <img src="{{ asset($tile['image']) }}" alt="Hair accessory" class="w-full h-full object-cover object-top min-h-[185px] lg:min-h-[350px]" />
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="studio-edits-pagination" class="mt-6 text-center"></div>
      </div>
    </div>
  </section>

  @include('partials.front.reviews')
  @include('partials.front.about_story')

@endsection

@push('scripts')
<script>
    window.__AVNEE_CUSTOM_SWIPERS__ = true;

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.Swiper === 'undefined') {
          console.warn('Swiper bundle did not load; skipping welcome sliders.');
          return;
        }

        const duplicateSectionIds = ['flash-sale', 'combo-deals', 'shop-by-price', 'shop-by-style', 'best-buys', 'shop-the-look'];
        duplicateSectionIds.forEach((sectionId) => {
          const node = document.getElementById(sectionId);
          if (node) {
            node.remove();
          }
        });

        const desiredSectionOrder = [
          'just-in',
          'shop-by-price-static',
          'shop-by-style-static',
          'best-buy-static',
          'home-lookbook',
          'home-top-collections',
          'popular-pieces',
          'studio-edits-slider',
          'customer-stories',
          'about-story'
        ];

        const anchorSection = document.getElementById('hero-slider');
        const pageRoot = anchorSection ? anchorSection.parentElement : null;

        if (pageRoot) {
          desiredSectionOrder.forEach((sectionId) => {
            const sectionNode = document.getElementById(sectionId);
            if (sectionNode && sectionNode.parentElement === pageRoot) {
              pageRoot.appendChild(sectionNode);
            }
          });
        }

        const heroEl = document.querySelector('.hero-swiper');
        if (heroEl) {
          if (heroEl.swiper) {
            heroEl.swiper.destroy(true, true);
          }

          new window.Swiper('.hero-swiper', {
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

        new window.Swiper('.best-buys-swiper', {
            slidesPerView: 1.2, spaceBetween: 12,
            navigation: { nextEl: '#best-buys-next', prevEl: '#best-buys-prev' },
            watchOverflow: true,
          breakpoints: {
            640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 16 },
            768: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 20 },
            1024: { slidesPerView: 4, slidesPerGroup: 4, spaceBetween: 20 }
          }
        });
        new window.Swiper('.flash-swiper', {
            slidesPerView: 2, spaceBetween: 10,
            navigation: { nextEl: '#flash-next', prevEl: '#flash-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 3, spaceBetween: 15 }, 1024: { slidesPerView: 5, spaceBetween: 20 } }
        });
        if (document.querySelector('.just-in-swiper')) {
          new window.Swiper('.just-in-swiper', {
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
        new window.Swiper('.best-buy-static-swiper', {
            slidesPerView: 1.15,
            slidesPerGroup: 1,
            spaceBetween: 14,
            navigation: { nextEl: '#bestbuy-static-next', prevEl: '#bestbuy-static-prev' },
            watchOverflow: true,
            breakpoints: {
              640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 16 },
              1024: { slidesPerView: 4, slidesPerGroup: 4, spaceBetween: 18 }
            }
        });
        const lookbookStage = document.getElementById('lookbook-stage');
        const lookbookPrev = document.getElementById('lookbook-prev');
        const lookbookNext = document.getElementById('lookbook-next');
        if (lookbookStage && lookbookPrev && lookbookNext) {
          const lookbookItems = @json($lookbookVideos);
          const slots = Array.from(lookbookStage.querySelectorAll('.look-slot'));
          const offsets = [-2, -1, 0, 1, 2];
          let centerIndex = Math.min(2, Math.max(0, lookbookItems.length - 1));
          let isSwapping = false;

          const mod = (n, m) => ((n % m) + m) % m;

          const renderSlots = () => {
            slots.forEach((slot, slotIndex) => {
              const offset = offsets[slotIndex];
              const data = lookbookItems[mod(centerIndex + offset, lookbookItems.length)];
              const videoEl = slot.querySelector('.lookbook-video');
              const titleEl = slot.querySelector('.lookbook-title');
              const linkEl = slot.querySelector('.lookbook-link');

              slot.setAttribute('data-slot', String(offset));
              if (videoEl) {
                videoEl.poster = data.poster;
                videoEl.src = data.src;
                videoEl.load();
                const playPromise = videoEl.play();
                if (playPromise && typeof playPromise.catch === 'function') {
                  playPromise.catch(() => {});
                }
              }
              titleEl.textContent = data.title;
              linkEl.setAttribute('href', data.cta);
            });
          };

          const swap = (direction) => {
            if (isSwapping || lookbookItems.length < 2) return;
            isSwapping = true;
            lookbookStage.classList.add('is-swapping');

            setTimeout(() => {
              centerIndex = mod(centerIndex + direction, lookbookItems.length);
              renderSlots();
            }, 120);

            setTimeout(() => {
              lookbookStage.classList.remove('is-swapping');
              isSwapping = false;
            }, 320);
          };

          lookbookPrev.addEventListener('click', () => swap(-1));
          lookbookNext.addEventListener('click', () => swap(1));

          let touchStartX = 0;
          let touchEndX = 0;
          lookbookStage.addEventListener('touchstart', (event) => {
            touchStartX = event.changedTouches[0].clientX;
          }, { passive: true });
          lookbookStage.addEventListener('touchend', (event) => {
            touchEndX = event.changedTouches[0].clientX;
            const delta = touchEndX - touchStartX;
            if (Math.abs(delta) < 28) return;
            if (delta > 0) swap(-1);
            if (delta < 0) swap(1);
          }, { passive: true });

          renderSlots();
        }
        if (document.querySelector('#shop-look-swiper')) {
          new window.Swiper('#shop-look-swiper', {
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
              }
            },
            navigation: { nextEl: '#look-next', prevEl: '#look-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
          });
        }
        new window.Swiper('.combo-swiper', {
            slidesPerView: 1, spaceBetween: 16,
            navigation: { nextEl: '#combo-next', prevEl: '#combo-prev' },
            watchOverflow: true,
            breakpoints: { 640: { slidesPerView: 2, spaceBetween: 20 }, 1024: { slidesPerView: 3, spaceBetween: 30 } }
        });
        new window.Swiper('.style-swiper', {
            slidesPerView: 2, spaceBetween: 16,
            navigation: { nextEl: '#style-next', prevEl: '#style-prev' },
            watchOverflow: true,
            breakpoints: { 480: { slidesPerView: 3, spaceBetween: 20 }, 768: { slidesPerView: 4, spaceBetween: 24 }, 1024: { slidesPerView: 4, spaceBetween: 30 } }
        });
        new window.Swiper('.style-static-swiper', {
          slidesPerView: 1.2, spaceBetween: 12,
          navigation: { nextEl: '#style-static-next', prevEl: '#style-static-prev' },
          watchOverflow: true,
          breakpoints: { 640: { slidesPerView: 2.2, spaceBetween: 16 }, 1024: { slidesPerView: 4, spaceBetween: 20 } }
        });

        new window.Swiper('.new-in-jewellery-swiper', {
          slidesPerView: 1.2, spaceBetween: 12,
          loop: true,
          autoplay: { delay: 2800, disableOnInteraction: false },
            navigation: { nextEl: '#popular-next', prevEl: '#popular-prev' },
            watchOverflow: true,
          breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 16 },
            900: { slidesPerView: 3, spaceBetween: 18 },
            1024: { slidesPerView: 4, spaceBetween: 18 },
          },
        });
        if (document.querySelector('.studio-edits-swiper')) {
          new window.Swiper('.studio-edits-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoHeight: true,
            speed: 750,
            autoplay: {
              delay: 3500,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            },
            navigation: { nextEl: '#studio-edits-next', prevEl: '#studio-edits-prev' },
            pagination: { el: '#studio-edits-pagination', clickable: true },
          });
        }
        document.querySelectorAll('.hover-video').forEach((videoEl) => {
          videoEl.addEventListener('mouseenter', () => videoEl.play());
          videoEl.addEventListener('mouseleave', () => videoEl.pause());
        });
    });
</script>
@endpush

