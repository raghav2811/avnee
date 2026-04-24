@extends('layouts.front.' . $theme)

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Product",
  "name": "{{ $product->name }}",
  "image": ["{{ asset('storage/' . $product->image) }}"],
  "description": "{{ $product->meta_description ?? strip_tags($product->description) }}",
  "sku": "{{ $product->slug }}",
  "brand": { "@@type": "Brand", "name": "AVNEE" },
  "offers": {
    "@@type": "Offer",
    "url": "{{ request()->url() }}",
    "priceCurrency": "INR",
    "price": "{{ $product->price }}",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock"
  }
}
</script>
@endpush

@section('content')
@php
    $isDark = $theme === 'jewellery';
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#e9d5ff]/50' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-300';
    $bgColor = $isDark ? 'bg-[#1a0023]' : 'bg-[#f2f2f2]';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-gray-900';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-black';
    $cardBg = $isDark ? 'bg-[#2B003A]/30' : 'bg-white';
    $isKidsProduct = str_contains(strtolower($product->category->slug ?? ''), 'kid') || str_contains(strtolower($product->category->name ?? ''), 'kid');

    $flashSale = $product->currentlyActiveFlashSale();
    $activePrice = $product->price;
    $strikePrice = $product->compare_price;
    $activeDiscount = $product->discount;

    if ($flashSale) {
        $flashDiscountPct = $flashSale->pivot->discount_percentage ?? 0;
        $flashDiscountAmt = $flashSale->pivot->discount_amount ?? 0;
        if ($flashDiscountPct > 0) {
            $activePrice = $activePrice - ($activePrice * ($flashDiscountPct / 100));
            $activeDiscount = round((($strikePrice - $activePrice) / $strikePrice) * 100);
        } elseif ($flashDiscountAmt > 0) {
            $activePrice = $activePrice - $flashDiscountAmt;
            $activeDiscount = round((($strikePrice - $activePrice) / $strikePrice) * 100);
        }
    }

    $couponBanner = asset('images/coupons/avnee7.jpeg');
    $kidsAgeSizes = ['0-6 Months', '6-12 Months', '1-2 Years', '2-3 Years', '3-4 Years', '4-5 Years', '5-6 Years', '6-7 Years', '7-8 Years'];
    $variantBySize = $product->variants
        ->where('stock', '>', 0)
        ->filter(fn ($v) => (string) ($v->size ?? '') !== '')
        ->groupBy(fn ($v) => trim((string) $v->size))
        ->map(fn ($group) => $group->first())
        ->all();
    $availableSizeKeys = collect(array_keys($variantBySize))
        ->map(fn ($s) => strtolower(preg_replace('/\s+/', '', (string) $s)))
        ->values();
    $isReturnable = (bool) ($product->is_returnable ?? true);

    $galleryImages = collect([$product->image])
        ->merge($product->images->pluck('path')->all())
        ->filter()
        ->unique()
        ->values();
    $galleryCount = max($galleryImages->count(), 1);
    $categoryTitle = $product->category->name ?? 'Collection';
@endphp

<div class="{{ $bgColor }} selection:bg-black selection:text-white transition-colors duration-700">
    <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-10 pt-8 pb-20">

        <nav class="flex items-center gap-2 text-[10px] font-bold tracking-[0.24em] uppercase {{ $mutedColor }} mb-6 overflow-x-auto whitespace-nowrap hide-scrollbar" aria-label="Breadcrumb">
            <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="hover:{{ $textColor }} transition-colors">Home</a>
            <span class="opacity-30">/</span>
            @if($product->category)
                <a href="{{ route('front.products.index', ['category' => $product->category->slug]) }}" class="hover:{{ $textColor }} transition-colors">{{ $product->category->name }}</a>
                <span class="opacity-30">/</span>
            @endif
            <span class="{{ $textColor }}">{{ $product->name }}</span>
        </nav>

        @if(!$isDark)
        <section class="mb-6 border {{ $borderColor }} bg-white overflow-hidden">
            <img src="{{ $couponBanner }}" alt="AVNEE7 Coupon Banner" class="w-full h-auto object-cover" />
        </section>
        @endif

        @if($isDark)
        <section class="mb-10 border {{ $borderColor }} bg-gradient-to-r from-[#2b003a] via-[#3d0a43] to-[#2b003a] px-4 py-3">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-sm sm:text-base text-[#f3d9ff] font-semibold tracking-wide">Limited Festive Edit</p>
                <p class="text-xs sm:text-sm text-[#e9d5ff]">Exclusive handcrafted styles with premium finishing and fast shipping support.</p>
            </div>
        </section>
        @endif

        @if($isKidsProduct)
        <section class="mb-12 border {{ $borderColor }} {{ $isDark ? 'bg-[#350047]' : 'bg-white/70' }} px-6 py-5">
            <p class="text-[10px] font-bold tracking-[0.3em] uppercase {{ $mutedColor }} mb-2">Kids Collection Banner</p>
            <p class="text-sm {{ $textColor }} leading-relaxed">Soft fabrics, playful silhouettes, and comfortable fits designed for little twirls and big smiles.</p>
        </section>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-[72px_minmax(0,1fr)_360px] gap-5 xl:gap-7 items-start">

            <div class="order-2 xl:order-1 flex xl:flex-col gap-2 overflow-x-auto xl:overflow-visible pb-1 xl:pb-0">
                <button class="detail-thumb shrink-0 w-[64px] xl:w-full aspect-[3/4] overflow-hidden border {{ $isDark ? 'border-[#d4af37]' : 'border-black' }} bg-white" onclick="changeImage('{{ asset('storage/' . $product->image) }}', this)">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }} thumbnail" class="w-full h-full object-cover object-top" />
                </button>
                @foreach($product->images as $img)
                    @if($img->path !== $product->image)
                    <button class="detail-thumb shrink-0 w-[64px] xl:w-full aspect-[3/4] overflow-hidden border {{ $borderColor }} bg-white" onclick="changeImage('{{ asset('storage/' . $img->path) }}', this)">
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }} thumbnail" class="w-full h-full object-cover object-top" />
                    </button>
                    @endif
                @endforeach
            </div>

            <div class="order-1 xl:order-2">
                <div class="relative bg-[#d8d8d8] border {{ $borderColor }} w-full min-h-[420px] sm:min-h-[560px] xl:min-h-[640px] flex items-center justify-center overflow-hidden">
                    <img id="main-product-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-[95%] max-w-[95%] object-contain transition-all duration-500 ease-out" />
                    @if($activeDiscount > 0)
                        <div class="absolute top-4 left-4 {{ $accentBg }} text-white text-[10px] font-bold px-3 py-1.5 tracking-[0.18em] uppercase">
                            {{ round($activeDiscount) }}% Off
                        </div>
                    @endif
                    <button type="button" id="gallery-prev" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/35 text-white text-lg leading-none">&#8249;</button>
                    <button type="button" id="gallery-next" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/35 text-white text-lg leading-none">&#8250;</button>
                    <span id="gallery-counter" class="absolute bottom-3 right-3 px-2 py-1 text-[10px] font-semibold rounded bg-black/40 text-white">1 / {{ $galleryCount }}</span>
                </div>
            </div>

            <div class="order-3 {{ $textColor }} xl:sticky xl:top-20 {{ $isDark ? 'border border-[#4f006a] bg-[#230030]/55 p-4 sm:p-5' : '' }} {{ !$isDark ? 'bg-transparent' : '' }}">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <h1 class="text-2xl leading-tight font-semibold tracking-tight max-w-[85%]">{{ $product->name }}</h1>
                    <div class="flex items-center gap-2 pt-1">
                        <button type="button" onclick="toggleWishlist({{ $product->id }})" class="p-1.5 rounded-full hover:bg-black/5 {{ $product->isWishlisted ? 'text-red-500' : '' }}" aria-label="Toggle wishlist">
                            <svg class="w-4 h-4 {{ $product->isWishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                        <button type="button" onclick="shareProduct()" class="p-1.5 rounded-full hover:bg-black/5" aria-label="Share product">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        </button>
                    </div>
                </div>

                <p class="text-[10px] {{ $mutedColor }} tracking-[0.22em] uppercase mb-1">{{ $isDark ? ('AVNEE ' . strtoupper($categoryTitle) . ' Archive') : strtoupper($categoryTitle) }}</p>
                <p class="text-[12px] {{ $mutedColor }} mb-1">Style No {{ $product->sku ?? 'AVN' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</p>

                <div class="mb-5">
                    @if($strikePrice > $activePrice)
                        <p class="text-xs {{ $mutedColor }} line-through mb-1">MRP ₹{{ number_format($strikePrice, 0) }}</p>
                    @endif
                    <p class="text-[28px] font-bold leading-none">₹{{ number_format($activePrice, 0) }}</p>
                    <p class="text-[11px] {{ $mutedColor }} mt-1">Inclusive of all taxes</p>
                </div>

                <div class="mb-6 space-y-2">
                    <div class="border {{ $borderColor }} bg-white overflow-hidden">
                        <img src="{{ $couponBanner }}" alt="AVNEE7 Coupon Banner" class="w-full h-auto object-cover" />
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="detail-variant-id" value="">
                    <input type="hidden" name="buy_now" id="buy-now-input" value="0">

                    @if($product->variants->count() > 0)
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-sm font-semibold">Size:</label>
                            <button type="button" id="size-guide-trigger" class="text-xs underline underline-offset-2 {{ $accentColor }} hover:opacity-70 transition-opacity">Size Guide</button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->variants->unique('size') as $index => $variant)
                            @php
                                $sizeLabel = trim((string) ($variant->size ?? ''));
                                $stockVariant = $variantBySize[$sizeLabel] ?? null;
                                $isDisabled = !$stockVariant;
                            @endphp
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="{{ $variant->size }}" data-variant-id="{{ $stockVariant?->id }}" class="peer sr-only" {{ $index === 0 ? 'required' : '' }} {{ $isDisabled ? 'disabled' : '' }} />
                                <span class="inline-flex items-center justify-center min-w-[84px] h-9 px-3 rounded-full border {{ $borderColor }} text-xs font-medium peer-checked:bg-black peer-checked:text-white {{ $isDark ? 'peer-checked:bg-[#d4af37] peer-checked:text-[#1a0023]' : '' }} {{ $isDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
                                    {{ $variant->size }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] {{ $mutedColor }} mt-2">Select your preferred size before adding to cart.</p>
                    </div>
                    @endif

                    @if($isKidsProduct)
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold">Kids Age Sizes</p>
                            <span class="text-[11px] {{ $mutedColor }}">Tap to match size</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($kidsAgeSizes as $ageSize)
                            @php
                                $ageKey = strtolower(preg_replace('/\s+/', '', (string) $ageSize));
                                $ageDisabled = !$availableSizeKeys->contains($ageKey);
                            @endphp
                            <button type="button" class="age-size-chip inline-flex items-center justify-center min-w-[88px] h-8 px-3 rounded-full border {{ $borderColor }} text-[11px] font-medium {{ $isDark ? 'hover:bg-[#d4af37]/15' : 'hover:bg-gray-100' }} transition-colors {{ $ageDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}" data-age-size="{{ $ageSize }}">
                                {{ $ageSize }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-2 flex items-center gap-2">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                id="delivery-pincode-input"
                                inputmode="numeric"
                                maxlength="6"
                                autocomplete="off"
                                placeholder="Express Delivery? Start with your PIN"
                                class="w-full h-9 border {{ $borderColor }} px-3 text-xs {{ $isDark ? 'bg-[#230030] text-white' : 'bg-white text-gray-900' }}"
                            />
                            <div
                                id="delivery-pincode-suggestions"
                                class="hidden absolute left-0 right-0 top-[calc(100%+4px)] z-30 border {{ $isDark ? 'border-[#4f006a] bg-[#1f0028] text-white' : 'border-gray-300 bg-white text-gray-900' }} max-h-52 overflow-y-auto shadow-lg"
                            ></div>
                        </div>
                        <button type="button" id="delivery-pincode-check-btn" class="h-9 px-3 {{ $isDark ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-[#122f2f] text-white' }} text-[11px] font-semibold">Check Service</button>
                    </div>
                    <p id="delivery-pincode-feedback" class="text-[11px] text-red-500 mb-4">Valid 6-digit PIN required</p>

                    <div class="mb-6 space-y-2">
                        <div class="flex items-stretch gap-2 h-11">
                            <div class="flex items-center border {{ $borderColor }} w-[96px] shrink-0 {{ $isDark ? 'bg-[#230030]' : 'bg-white' }}">
                                <button type="button" onclick="decrementQty()" class="w-full h-full text-lg">−</button>
                                <input type="number" name="quantity" id="qty" value="1" min="1" class="w-8 text-center bg-transparent border-none p-0 focus:ring-0 text-sm font-semibold" readonly />
                                <button type="button" onclick="incrementQty()" class="w-full h-full text-lg">+</button>
                            </div>
                            <button type="button" onclick="addToCartWithDrawer()" class="flex-1 h-full border {{ $isDark ? $borderColor : 'border-black' }} {{ $isDark ? 'bg-[#2B003A] text-white' : 'bg-black text-white' }} text-[12px] font-semibold uppercase tracking-wide">Add To Cart • ₹{{ number_format($activePrice, 0) }}</button>
                        </div>
                        <button type="button" onclick="buyNow()" class="w-full h-11 {{ $isDark ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-white border border-black text-black' }} text-[12px] font-semibold uppercase tracking-wide">Buy It Now</button>
                    </div>

                    <div class="mb-6 pt-2">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-[12px] leading-snug {{ $mutedColor }}">
                            <div class="flex items-center gap-2"><span class="text-base">◈</span><span>100% Purchase Protection</span></div>
                            <div class="flex items-center gap-2"><span class="text-base">◎</span><span>Assured Quality</span></div>
                            <div class="flex items-center gap-2"><span class="text-base">↻</span><span>{{ $isReturnable ? 'This product is returnable' : 'This product is not returnable' }}</span></div>
                            <div class="flex items-center gap-2"><span class="text-base">✈</span><span>Free shipping*</span></div>
                        </div>
                    </div>
                </form>

                <div class="space-y-px border-t {{ $borderColor }} pt-2">
                    <details class="group border-b {{ $borderColor }}" open>
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-[18px] font-medium">
                            <span>Product Details</span>
                            <span class="transition-transform duration-300 group-open:rotate-45 text-xl leading-none">+</span>
                        </summary>
                        <div class="pb-5 text-[13px] leading-relaxed {{ $mutedColor }}">
                            {!! $product->description !!}
                        </div>
                    </details>

                    <details class="group border-b {{ $borderColor }}">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-[18px] font-medium">
                            <span>Style & Fit Tips</span>
                            <span class="transition-transform duration-300 group-open:rotate-45 text-xl leading-none">+</span>
                        </summary>
                        <div class="pb-5 text-[13px] leading-relaxed {{ $mutedColor }}">
                            Pair this style with soft footwear and minimal accessories for day events; add a jacket or shrug for evening layering. For growing kids, choose one size up when between age brackets.
                        </div>
                    </details>

                    <details class="group border-b {{ $borderColor }}">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-[18px] font-medium">
                            <span>Shipping & Returns</span>
                            <span class="transition-transform duration-300 group-open:rotate-45 text-xl leading-none">+</span>
                        </summary>
                        <div class="pb-5 text-[13px] leading-relaxed {{ $mutedColor }}">
                            Orders are processed quickly and dispatched with tracking updates. Easy return requests can be raised within 5 days of delivery for eligible items in original condition.
                        </div>
                    </details>

                    <details class="group border-b {{ $borderColor }}">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-[18px] font-medium">
                            <span>FAQs</span>
                            <span class="transition-transform duration-300 group-open:rotate-45 text-xl leading-none">+</span>
                        </summary>
                        <div class="pb-5 text-[13px] leading-relaxed {{ $mutedColor }}">
                            Need sizing help or order support? Reach out on WhatsApp or email and share the product style number for faster assistance from our support team.
                        </div>
                    </details>

                    <div class="pt-8 pb-4 text-[12px] leading-relaxed {{ $mutedColor }} border-b {{ $borderColor }}">
                        Main image is shown first, and all remaining photos from this product folder are available in the gallery below.
                    </div>
                    @if($product->category)
                    <a href="{{ route('front.products.index', ['category' => $product->category->slug]) }}" class="block pt-4 text-[11px] font-bold uppercase tracking-[0.22em] {{ $accentColor }} hover:opacity-70 transition-opacity">
                        Back to {{ $product->category->name }}
                    </a>
                    @endif
                </div>
            </div>
        </div>


        <!-- SECTION: Symphonic Pairings (Related) -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16 pt-10 border-t {{ $borderColor }}">
            <h2 class="font-heading text-2xl sm:text-3xl {{ $isDark ? 'text-center' : 'text-left' }} font-normal tracking-tight uppercase mb-8 {{ $textColor }}">Similar Products</h2>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-5">
                @foreach($relatedProducts as $related)
                <div class="group relative flex flex-col">
                    <a href="{{ route('front.product.detail', $related->slug ?? $related->id) }}" class="relative aspect-[3/4] overflow-hidden mb-6 block shadow-xl transition-all duration-700">
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover object-top filter grayscale-[30%] group-hover:grayscale-0 transition-all duration-[2s] group-hover:scale-105" />
                        @if($related->discount > 0)
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-black text-[9px] font-bold px-3 py-1.5 tracking-widest uppercase">-{{ round($related->discount) }}%</div>
                        @endif
                    </a>
                    <div class="space-y-2">
                        <a href="{{ route('front.product.detail', $related->slug ?? $related->id) }}" class="block text-[11px] font-bold tracking-widest uppercase {{ $textColor }} line-clamp-1 opacity-70 group-hover:opacity-100 transition-opacity">
                            {{ $related->name }}
                        </a>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold tracking-tight">₹{{ number_format($related->price, 0) }}</span>
                            @if($related->compare_price > $related->price)
                                <span class="text-[10px] {{ $mutedColor }} line-through uppercase opacity-30">₹{{ number_format($related->compare_price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($recentlyViewedProducts) && $recentlyViewedProducts->count() > 0)
        <section class="mt-14 pt-10 border-t {{ $borderColor }}">
            <h2 class="font-heading text-2xl sm:text-3xl {{ $isDark ? 'text-center' : 'text-left' }} font-normal tracking-[0.16em] uppercase mb-8 {{ $textColor }}">Recently Viewed</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                @foreach($recentlyViewedProducts as $recent)
                    <a href="{{ route('front.product.detail', $recent->slug ?? $recent->id) }}" class="group block">
                        <div class="aspect-[3/4] overflow-hidden border {{ $borderColor }} {{ $isDark ? 'bg-[#2B003A]' : 'bg-white/60' }}">
                            <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                        </div>
                        <p class="mt-3 text-[11px] font-bold tracking-[0.12em] uppercase {{ $textColor }} line-clamp-1">{{ $recent->name }}</p>
                        <p class="text-sm {{ $accentColor }} font-semibold">₹{{ number_format($recent->price, 0) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>

<div id="size-guide-panel" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div id="size-guide-backdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
    <aside id="size-guide-drawer" class="absolute right-0 top-0 h-full w-full max-w-md {{ $isDark ? 'bg-[#1f0028] text-white border-l border-[#4f006a]' : 'bg-white text-gray-900 border-l border-gray-200' }} translate-x-full transition-transform duration-300 shadow-2xl overflow-y-auto">
        <div class="p-6 border-b {{ $borderColor }} flex items-center justify-between">
            <h3 class="text-lg font-semibold tracking-wide uppercase">Size Guide</h3>
            <button type="button" id="size-guide-close" class="text-2xl leading-none hover:opacity-70">&times;</button>
        </div>
        <div class="p-6 space-y-5 text-sm {{ $mutedColor }}">
            <p>Choose the closest chest measurement for the best fit. For layered styling, select one size up.</p>
            <div class="border {{ $borderColor }} overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="{{ $isDark ? 'bg-[#2B003A]' : 'bg-gray-50' }} {{ $textColor }} uppercase tracking-[0.14em]">
                        <tr>
                            <th class="px-4 py-3">Size</th>
                            <th class="px-4 py-3">Age</th>
                            <th class="px-4 py-3">Chest (in)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t {{ $borderColor }}"><td class="px-4 py-3">1-2Y</td><td class="px-4 py-3">Toddler</td><td class="px-4 py-3">20-21</td></tr>
                        <tr class="border-t {{ $borderColor }}"><td class="px-4 py-3">2-4Y</td><td class="px-4 py-3">Kids</td><td class="px-4 py-3">22-23</td></tr>
                        <tr class="border-t {{ $borderColor }}"><td class="px-4 py-3">4-6Y</td><td class="px-4 py-3">Kids</td><td class="px-4 py-3">24-25</td></tr>
                        <tr class="border-t {{ $borderColor }}"><td class="px-4 py-3">6-8Y</td><td class="px-4 py-3">Juniors</td><td class="px-4 py-3">26-27</td></tr>
                        <tr class="border-t {{ $borderColor }}"><td class="px-4 py-3">8-10Y</td><td class="px-4 py-3">Juniors</td><td class="px-4 py-3">28-29</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs">Need assistance? Reach out via the concierge and share your child’s height, age, and preferred fit profile for faster recommendations.</p>
        </div>
    </aside>
</div>

<div id="detail-cart-overlay" class="fixed inset-0 bg-black/40 z-[120] hidden"></div>
<aside id="detail-cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-[430px] bg-white text-gray-900 z-[130] shadow-2xl translate-x-full transition-transform duration-300">
    <div class="h-full flex flex-col">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-[42px] leading-[0.95] font-semibold tracking-tight">Your Cart <span id="detail-drawer-count" class="text-[30px] font-medium text-gray-500">Items 0</span></h3>
            <button type="button" onclick="closeDetailCartDrawer()" class="text-2xl leading-none text-gray-500 hover:text-black">&times;</button>
        </div>
        <div id="detail-drawer-items" class="p-4 flex-1 overflow-y-auto space-y-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Your cart is empty.</p>
        </div>
        <div class="p-4 space-y-3">
            <div class="flex items-center justify-between text-3xl leading-none font-semibold pb-2 border-b border-gray-200">
                <span>Subtotal</span>
                <span id="detail-drawer-subtotal">₹0</span>
            </div>
            <a href="{{ route('front.checkout.index') }}" class="block w-full h-12 bg-black text-white text-center leading-[48px] text-[18px] font-semibold uppercase">Checkout</a>
            <a href="{{ route('front.cart.index') }}" class="block w-full h-12 border border-black text-center leading-[48px] text-[18px] font-semibold uppercase">View Cart</a>
            <p class="text-[13px] leading-relaxed text-gray-700 text-center">By clicking on checkout you are agreeing to <a href="{{ route('front.page', ['slug' => 'return-policy']) }}" class="underline">Return Policy</a>.</p>
            <div>
                <p class="text-[34px] font-semibold mb-3">We Accept</p>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="h-10 min-w-[58px] px-3 border border-gray-200 rounded-md text-[#1434CB] text-[18px] font-bold inline-flex items-center justify-center">VISA</span>
                    <span class="h-10 min-w-[58px] px-3 border border-gray-200 rounded-md text-[18px] font-bold inline-flex items-center justify-center gap-1"><span class="text-red-500 text-xl">●</span><span class="text-yellow-500 text-xl">●</span></span>
                    <span class="h-10 min-w-[70px] px-3 border border-gray-200 rounded-md text-[#0070BA] text-[16px] font-bold inline-flex items-center justify-center">AMEX</span>
                    <span class="h-10 px-3 border border-gray-200 rounded-md text-[14px] font-semibold inline-flex items-center justify-center">Cash on Delivery</span>
                    <span class="h-10 px-3 border border-gray-200 rounded-md text-[14px] font-semibold inline-flex items-center justify-center">BHIM UPI</span>
                    <span class="h-10 min-w-[72px] px-3 border border-gray-200 rounded-md text-[15px] font-semibold inline-flex items-center justify-center">RuPay</span>
                </div>
            </div>
        </div>
    </div>
</aside>


@push('scripts')
<script>
    function changeImage(src, element) {
        const mainImg = document.getElementById('main-product-image');
        const buttons = document.querySelectorAll('.detail-thumb');
        const counter = document.getElementById('gallery-counter');
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 300);

        buttons.forEach(btn => btn.classList.remove('{{ $isDark ? "border-brand-gold" : "border-mulberry" }}'));
        buttons.forEach(btn => btn.classList.add('{{ $borderColor }}'));
        element.classList.remove('{{ $borderColor }}');
        element.classList.add('{{ $isDark ? "border-brand-gold" : "border-mulberry" }}');

        if (counter && element) {
            const index = Array.from(buttons).indexOf(element);
            if (index >= 0) counter.textContent = `${index + 1} / ${buttons.length}`;
        }
    }

    function incrementQty() {
        const qtyInput = document.getElementById('qty');
        qtyInput.value = parseInt(qtyInput.value) + 1;
    }

    function decrementQty() {
        const qtyInput = document.getElementById('qty');
        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
        }
    }

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }} — AVNEE ARCHIVE',
                url: window.location.href
            }).catch(console.error);
        } else {
            const el = document.createElement('textarea');
            el.value = window.location.href;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('Atelier Resource Link copied to archive.');
        }
    }

    function buyNow() {
        const form = document.getElementById('add-to-cart-form');
        if (!form) return;

        const buyNowInput = document.getElementById('buy-now-input');
        if (buyNowInput) buyNowInput.value = '1';

        form.submit();
    }

    function formatDetailCurrency(value) {
        const num = Number(value || 0);
        return '₹' + Math.round(num).toLocaleString('en-IN');
    }

    function detailCartUpdateUrl(itemId) {
        return @json(route('front.cart.update', ['id' => '__ID__'])).replace('__ID__', String(itemId));
    }

    function detailCartRemoveUrl(itemId) {
        return @json(route('front.cart.remove', ['id' => '__ID__'])).replace('__ID__', String(itemId));
    }

    function fetchDetailCartSummary() {
        return fetch(@json(route('front.cart.summary')), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).then((response) => {
            if (!response.ok) throw new Error('Failed to fetch cart summary');
            return response.json();
        });
    }

    function renderDetailDrawerItems(payload) {
        const host = document.getElementById('detail-drawer-items');
        if (!host) return;

        const items = Array.isArray(payload.items) ? payload.items : [];
        if (items.length === 0) {
            host.innerHTML = '<p class="text-sm text-gray-500">Your cart is empty.</p>';
            return;
        }

        host.innerHTML = items.map((item) => {
            const image = item.image || (document.getElementById('main-product-image') || {}).src || '';
            const sizeText = item.size || 'Free Size';
            const itemUrl = item.product_url || '#';
            return '' +
                '<div class="flex gap-4 pb-4 border-b border-gray-200">' +
                    '<img src="' + image + '" alt="' + (item.title || 'Product') + '" class="w-20 h-24 object-cover border" />' +
                    '<div class="flex-1 min-w-0">' +
                        '<div class="flex items-start justify-between gap-2">' +
                            '<p class="text-[16px] leading-[1.2] font-medium text-gray-900 line-clamp-2">' + String(item.qty || 1) + ' x ' + (item.title || 'Product') + '</p>' +
                            '<div class="flex gap-2 text-gray-500">' +
                                '<button type="button" onclick="updateDetailCartItem(' + Number(item.id) + ', -1)" class="text-xs border border-gray-300 px-1">−</button>' +
                                '<button type="button" onclick="updateDetailCartItem(' + Number(item.id) + ', 1)" class="text-xs border border-gray-300 px-1">+</button>' +
                            '</div>' +
                        '</div>' +
                        '<p class="text-[16px] text-gray-900 mt-2 font-semibold">MRP ' + formatDetailCurrency(item.line_total) + '</p>' +
                        '<p class="text-[16px] text-gray-700 mt-1">Size: ' + sizeText + '</p>' +
                        '<div class="mt-2 flex items-center justify-between">' +
                            '<a href="' + itemUrl + '" class="text-[14px] text-[#0d3b7a] underline">View Details</a>' +
                            '<button type="button" onclick="removeDetailCartItem(' + Number(item.id) + ')" class="text-gray-500 text-lg leading-none">🗑</button>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        }).join('');
    }

    function openDetailCartDrawer(payload) {
        const overlay = document.getElementById('detail-cart-overlay');
        const drawer = document.getElementById('detail-cart-drawer');
        if (!overlay || !drawer) return;

        renderDetailDrawerItems(payload);
        document.getElementById('detail-drawer-subtotal').textContent = formatDetailCurrency(payload.subtotal || 0);
        document.getElementById('detail-drawer-count').textContent = 'Items ' + String(payload.item_count || 0);

        overlay.classList.remove('hidden');
        drawer.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailCartDrawer() {
        const overlay = document.getElementById('detail-cart-overlay');
        const drawer = document.getElementById('detail-cart-drawer');
        if (!overlay || !drawer) return;
        drawer.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateDetailCartItem(itemId, delta) {
        fetchDetailCartSummary().then((summary) => {
            const items = Array.isArray(summary.items) ? summary.items : [];
            const found = items.find((i) => Number(i.id) === Number(itemId));
            if (!found) return;
            const qty = Math.max(1, Number(found.qty || 1) + Number(delta || 0));
            return fetch(detailCartUpdateUrl(itemId), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ _method: 'PATCH', quantity: String(qty) })
            }).then(() => fetchDetailCartSummary()).then((nextSummary) => openDetailCartDrawer(nextSummary));
        });
    }

    function removeDetailCartItem(itemId) {
        fetch(detailCartRemoveUrl(itemId), {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ _method: 'DELETE' })
        }).then(() => fetchDetailCartSummary()).then((nextSummary) => openDetailCartDrawer(nextSummary));
    }

    function addToCartWithDrawer() {
        const form = document.getElementById('add-to-cart-form');
        if (!form) return;
        const buyNowInput = document.getElementById('buy-now-input');
        if (buyNowInput) buyNowInput.value = '0';

        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async (response) => {
            if (!response.ok) {
                throw new Error('Add to cart failed');
            }

            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                throw new Error('Unexpected response type');
            }

            return response.json();
        })
        .then((payload) => {
            if (!payload || payload.success !== true) {
                throw new Error((payload && payload.message) || 'Unable to add item');
            }

            return fetchDetailCartSummary();
        })
        .then((summary) => openDetailCartDrawer(summary))
        .catch(() => form.submit());
    }

    function toggleWishlist(productId) {
        fetch('{{ route("front.wishlist.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        }).finally(() => {
            window.location.reload();
        });
    }

    (function () {
        const trigger = document.getElementById('size-guide-trigger');
        const panel = document.getElementById('size-guide-panel');
        const drawer = document.getElementById('size-guide-drawer');
        const backdrop = document.getElementById('size-guide-backdrop');
        const closeBtn = document.getElementById('size-guide-close');

        if (!trigger || !panel || !drawer || !backdrop || !closeBtn) return;

        const closePanel = () => {
            backdrop.classList.add('opacity-0');
            drawer.classList.add('translate-x-full');
            setTimeout(() => panel.classList.add('hidden'), 220);
            document.body.classList.remove('overflow-hidden');
        };

        trigger.addEventListener('click', () => {
            panel.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('translate-x-full');
            });
            document.body.classList.add('overflow-hidden');
        });

        closeBtn.addEventListener('click', closePanel);
        backdrop.addEventListener('click', closePanel);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !panel.classList.contains('hidden')) {
                closePanel();
            }
        });
    })();

    (function () {
        const prevBtn = document.getElementById('gallery-prev');
        const nextBtn = document.getElementById('gallery-next');
        const thumbs = Array.from(document.querySelectorAll('.detail-thumb'));
        if (!prevBtn || !nextBtn || thumbs.length === 0) return;

        const getActiveIndex = () => {
            return Math.max(0, thumbs.findIndex((btn) => btn.classList.contains('{{ $isDark ? "border-brand-gold" : "border-mulberry" }}')));
        };

        const activateByIndex = (idx) => {
            const safeIdx = (idx + thumbs.length) % thumbs.length;
            thumbs[safeIdx].click();
        };

        prevBtn.addEventListener('click', () => activateByIndex(getActiveIndex() - 1));
        nextBtn.addEventListener('click', () => activateByIndex(getActiveIndex() + 1));
    })();

    (function () {
        const overlay = document.getElementById('detail-cart-overlay');
        if (overlay) {
            overlay.addEventListener('click', closeDetailCartDrawer);
        }
    })();

    (function () {
        const input = document.getElementById('delivery-pincode-input');
        const checkBtn = document.getElementById('delivery-pincode-check-btn');
        const feedback = document.getElementById('delivery-pincode-feedback');
        const list = document.getElementById('delivery-pincode-suggestions');
        if (!input || !checkBtn || !feedback || !list) return;

        const DATASET_URLS = [
            'https://cdn.jsdelivr.net/gh/saravanakumargn/All-India-Pincode-Directory@master/all-india-pincode-json-array.json',
            'https://raw.githubusercontent.com/saravanakumargn/All-India-Pincode-Directory/master/all-india-pincode-json-array.json'
        ];
        let allPincodes = [];
        let byPincode = new Map();
        let datasetLoaded = false;
        let loadingPromise = null;

        const setFeedback = (message, isError = true) => {
            feedback.textContent = message;
            feedback.classList.toggle('text-red-500', isError);
            feedback.classList.toggle('text-green-600', !isError);
        };

        const hideSuggestions = () => {
            list.classList.add('hidden');
            list.innerHTML = '';
        };

        const loadDataset = async () => {
            if (datasetLoaded) return;
            if (loadingPromise) return loadingPromise;
            loadingPromise = (async () => {
                let rows = null;
                for (const url of DATASET_URLS) {
                    try {
                        const res = await fetch(url);
                        if (!res.ok) continue;
                        rows = await res.json();
                        break;
                    } catch (_) {
                        // Try next source.
                    }
                }
                if (!rows) throw new Error('Failed to load pincode dataset');
                return rows;
            })()
                .then((rows) => {
                    const normalized = Array.isArray(rows) ? rows : [];
                    const seen = new Set();
                    normalized.forEach((row) => {
                        const pin = String(row.pincode || '').replace(/\D/g, '').slice(0, 6);
                        if (!/^\d{6}$/.test(pin)) return;
                        if (!seen.has(pin)) {
                            allPincodes.push(pin);
                            seen.add(pin);
                        }
                        if (!byPincode.has(pin)) {
                            byPincode.set(pin, {
                                district: row.Districtname || row.districtname || '',
                                state: row.statename || row.StateName || '',
                                office: row.officename || row.OfficeName || '',
                            });
                        }
                    });
                    allPincodes.sort();
                    datasetLoaded = true;
                })
                .catch(() => {
                    setFeedback('Unable to load pincode suggestions right now. You can still enter a 6-digit PIN.');
                });
            return loadingPromise;
        };

        const renderSuggestions = async (digits) => {
            const query = (digits || '').replace(/\D/g, '');
            if (query.length < 2) {
                hideSuggestions();
                return;
            }
            await loadDataset();
            if (!datasetLoaded) return;
            const matches = allPincodes.filter((pin) => pin.startsWith(query)).slice(0, 8);
            if (!matches.length) {
                hideSuggestions();
                return;
            }
            list.innerHTML = matches.map((pin) => {
                const meta = byPincode.get(pin) || {};
                const hintParts = [meta.office, meta.district, meta.state].filter(Boolean);
                const hint = hintParts.join(', ');
                return (
                    '<button type="button" class="w-full text-left px-3 py-2 text-xs hover:' + (@json($isDark ? 'bg-[#2b003a]' : 'bg-gray-100')) + '" data-pin="' + pin + '">' +
                        '<span class="font-semibold">' + pin + '</span>' +
                        (hint ? '<span class="block opacity-70 mt-0.5">' + hint + '</span>' : '') +
                    '</button>'
                );
            }).join('');
            list.classList.remove('hidden');
        };

        input.addEventListener('focus', () => {
            renderSuggestions(input.value);
        });

        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '').slice(0, 6);
            setFeedback('Valid 6-digit PIN required', true);
            renderSuggestions(input.value);
        });

        list.addEventListener('click', (event) => {
            const btn = event.target.closest('[data-pin]');
            if (!btn) return;
            input.value = btn.getAttribute('data-pin') || '';
            hideSuggestions();
            checkBtn.click();
        });

        document.addEventListener('click', (event) => {
            if (!list.contains(event.target) && event.target !== input) {
                hideSuggestions();
            }
        });

        checkBtn.addEventListener('click', async () => {
            const pin = input.value.replace(/\D/g, '').slice(0, 6);
            input.value = pin;
            if (!/^\d{6}$/.test(pin)) {
                setFeedback('Please enter a valid 6-digit PIN code.');
                return;
            }
            await loadDataset();
            if (datasetLoaded && byPincode.has(pin)) {
                const meta = byPincode.get(pin) || {};
                const locationParts = [meta.district, meta.state].filter(Boolean);
                const location = locationParts.length ? ' for ' + locationParts.join(', ') : '';
                setFeedback('Delivery available at ' + pin + location + '.', false);
                return;
            }

            // Fallback validation using India Post API if dataset couldn't resolve this PIN.
            try {
                const res = await fetch('https://api.postalpincode.in/pincode/' + pin);
                const data = await res.json();
                const first = Array.isArray(data) ? data[0] : null;
                const offices = first && Array.isArray(first.PostOffice) ? first.PostOffice : [];
                if (first && first.Status === 'Success' && offices.length > 0) {
                    const place = [offices[0].District, offices[0].State].filter(Boolean).join(', ');
                    setFeedback('Valid Indian PIN: ' + pin + (place ? ' (' + place + ')' : '') + '.', false);
                } else {
                    setFeedback('PIN ' + pin + ' is not a valid Indian pincode.');
                }
            } catch (_) {
                setFeedback('Could not verify PIN right now. Please try again.');
            }
        });
    })();

    (function () {
        const chips = Array.from(document.querySelectorAll('.age-size-chip'));
        const sizeInputs = Array.from(document.querySelectorAll('input[name="size"]'));
        if (!chips.length || !sizeInputs.length) return;

        const variantIdInput = document.getElementById('detail-variant-id');
        const syncVariantId = () => {
            const selected = sizeInputs.find((i) => i.checked);
            if (!variantIdInput) return;
            const id = selected ? selected.getAttribute('data-variant-id') : '';
            variantIdInput.value = id ? String(id) : '';
        };

        sizeInputs.forEach((input) => {
            input.addEventListener('change', () => {
                syncVariantId();
            });
        });

        chips.forEach((chip) => {
            chip.addEventListener('click', () => {
                const desired = String(chip.getAttribute('data-age-size') || '').toLowerCase().replace(/\s+/g, '');
                const match = sizeInputs.find((input) => {
                    const value = String(input.value || '').toLowerCase().replace(/\s+/g, '');
                    return value === desired || value.includes(desired) || desired.includes(value);
                });
                if (match) {
                    match.checked = true;
                    match.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });

        syncVariantId();
    })();
</script>

<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.font-heading { font-family: 'Noto Serif', serif; }
#main-product-image { transition: opacity 0.3s ease-in-out, transform 1.5s cubic-bezier(0.4, 0, 0.2, 1); }
.group:hover #main-product-image { transform: scale(1.015); }
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endpush
@endsection
