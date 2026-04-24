@extends('layouts.front.' . $theme)

@section('content')
@php
    $isDark = $theme === 'jewellery';
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#e9d5ff]/50' : 'text-mulberry/60';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-mulberry/10';
    $bgColor = $isDark ? 'bg-[#1a0023]' : 'bg-[#F8C8DC]';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-mulberry';
    $category = $category ?? 'party-frocks';
    $categoryLabel = $categoryLabel ?? 'Party Frocks';
    $linkedProduct = $linkedProduct ?? null;
    $detailContent = $detailContent ?? [];
    $price = $detailContent['price'] ?? 699;
    $comparePrice = $detailContent['compare_price'] ?? ($price + 300);
    $description = $detailContent['description'] ?? ($categoryLabel . ' curated piece with handcrafted detailing.');
    $styleFitText = $detailContent['style_fit'] ?? 'Choose your regular size for a comfortable fit. For layered styling, size up by one step.';
    $shippingText = $detailContent['shipping'] ?? 'Dispatch within 48 hours. Free shipping above ₹1499.';
    $returnsText = $detailContent['returns'] ?? 'Returns accepted as per policy for unused products.';
    $faqText = $detailContent['faq'] ?? 'Need help with size, delivery, or bulk orders? Contact AVNEE concierge support for quick assistance.';
    $styleNo = $detailContent['style_no'] ?? ($linkedProduct->sku ?? ('AVN' . str_pad((string) ($linkedProduct->id ?? 1), 6, '0', STR_PAD_LEFT)));
    $dressCategories = ['party-frocks', 'girls-dresses', 'festive-wear', 'pattu-pavadai', '2-4-years', '4-6-years', '6-14-years', 'infant-sets'];
    $showAgeSizes = in_array((string) $category, $dressCategories, true);
    $whatsAppMessage = rawurlencode('Hi AVNEE, I want to buy ' . ($galleryProduct['title'] ?? 'this product') . ' from ' . $categoryLabel . '.');
    $colorOptions = collect($galleryProduct['color_options'] ?? [])->values();
    $initialImages = $colorOptions->first()['images'] ?? ($galleryProduct['images'] ?? []);
    $initialMainImage = $colorOptions->first()['main_url'] ?? ($galleryProduct['images'][0] ?? null);
    $similarGalleryProducts = $similarGalleryProducts ?? [];
    $recentlyViewedGalleryProducts = $recentlyViewedGalleryProducts ?? [];
    $isReturnable = (bool) ($linkedProduct?->is_returnable ?? true);
    $sizeVariantMap = $linkedProduct
        ? $linkedProduct->variants
            ->where('stock', '>', 0)
            ->filter(fn ($v) => (string) ($v->size ?? '') !== '')
            ->groupBy(fn ($v) => trim((string) $v->size))
            ->map(fn ($g) => $g->first())
            ->map(fn ($v) => $v->id)
            ->all()
        : [];
    $initialSize = $sizeVariantMap ? array_key_first($sizeVariantMap) : '0-6 Months';
@endphp

<div class="{{ $bgColor }} transition-colors duration-700">
    <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-10 pt-10 pb-24">
        <nav class="flex items-center gap-2 text-[10px] font-bold tracking-[0.3em] uppercase {{ $mutedColor }} mb-12 overflow-x-auto whitespace-nowrap hide-scrollbar" aria-label="Breadcrumb">
            <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="hover:{{ $textColor }} transition-colors">Home</a>
            <span class="opacity-30">/</span>
            <a href="{{ route('front.products.index', ['category' => $category]) }}" class="hover:{{ $textColor }} transition-colors">{{ $categoryLabel }}</a>
            <span class="opacity-30">/</span>
            <span class="{{ $textColor }}">{{ $galleryProduct['title'] }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start">
            <div class="w-full lg:w-[46%] space-y-5">
                <div class="max-w-[520px] mx-auto lg:mx-0 border {{ $borderColor }} bg-white overflow-hidden">
                    <img src="{{ asset('images/coupons/avnee7.jpeg') }}" alt="AVNEE7 Coupon Banner" class="w-full h-auto object-cover" />
                </div>

                <div class="relative aspect-[4/5] max-w-[520px] mx-auto lg:mx-0 overflow-hidden shadow-2xl shadow-black/5 lg:rounded-sm border {{ $borderColor }} bg-white/20">
                    <img id="main-party-image" src="{{ $initialMainImage }}" alt="{{ $galleryProduct['title'] }}" class="w-full h-full object-cover object-top" />
                    <button id="party-slider-prev" type="button" aria-label="Previous image" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/55 text-white text-lg font-bold leading-none flex items-center justify-center hover:bg-black/75 transition-colors">&lsaquo;</button>
                    <button id="party-slider-next" type="button" aria-label="Next image" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/55 text-white text-lg font-bold leading-none flex items-center justify-center hover:bg-black/75 transition-colors">&rsaquo;</button>
                    <div id="party-slider-count" class="absolute bottom-3 right-3 px-2 py-1 text-[10px] font-bold tracking-[0.18em] uppercase bg-black/55 text-white rounded">1 / 1</div>
                </div>

                @if($colorOptions->count() > 1)
                <div class="max-w-[600px] mx-auto lg:mx-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.24em] {{ $mutedColor }} mb-2">Select Color</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($colorOptions as $color)
                        <button
                            type="button"
                            class="color-option-btn w-8 h-8 rounded-full border-2 {{ $loop->first ? 'border-black ring-2 ring-black/60' : 'border-white/70' }} shadow-sm"
                            data-main="{{ $color['main_url'] }}"
                            data-images='@json($color['images'])'
                            data-label="{{ $color['name'] }}"
                            onclick="switchGalleryColor(this)">
                            <span class="sr-only">{{ $color['name'] }}</span>
                        </button>
                        @endforeach
                    </div>
                    <p id="selected-color-name" class="mt-2 text-xs font-semibold {{ $textColor }}">{{ $colorOptions->first()['name'] ?? 'Selected Color' }}</p>
                </div>
                @endif

                <div id="party-thumbs" class="flex gap-2 overflow-x-auto pb-1 max-w-[520px] mx-auto lg:mx-0 hide-scrollbar">
                    @foreach($initialImages as $image)
                    <button type="button" onclick="changePartyImage('{{ $image }}', this)" class="party-thumb flex-none w-16 sm:w-20 aspect-[3/4] overflow-hidden border {{ $borderColor }} bg-black/5 {{ $loop->first ? 'ring-2 ring-black/60 dark:ring-white/60' : '' }}">
                        <img src="{{ $image }}" alt="{{ $galleryProduct['title'] }}" class="w-full h-full object-cover object-top" />
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="w-full lg:w-[54%] lg:sticky lg:top-28 {{ $textColor }}">
                <span class="text-[10px] font-bold tracking-[0.35em] uppercase {{ $mutedColor }}">Avnee {{ $categoryLabel }} Archive</span>
                <h1 class="mt-3 text-4xl lg:text-5xl font-heading font-normal leading-[1.1] uppercase tracking-tight">{{ $galleryProduct['title'] }}</h1>
                <p class="mt-2 text-lg leading-snug font-semibold">{{ $galleryProduct['title'] }}</p>
                <p class="mt-1 text-sm {{ $mutedColor }}">Style No {{ $styleNo }}</p>

                <div class="mt-8 mb-6">
                    <div class="flex items-baseline gap-3 mb-1">
                        <span class="text-3xl font-bold tracking-tight">₹{{ number_format((float)$price, 0) }}</span>
                        @if((float)$comparePrice > (float)$price)
                            <span class="text-sm {{ $mutedColor }} line-through">₹{{ number_format((float)$comparePrice, 0) }}</span>
                        @endif
                    </div>
                    <p class="text-[11px] {{ $mutedColor }}">Inclusive of all taxes</p>
                </div>

                <p class="text-sm leading-relaxed {{ $mutedColor }} mb-5">{{ $description }}</p>

                @if($showAgeSizes)
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] {{ $mutedColor }}">Size:</p>
                            <a href="javascript:void(0)" class="text-sm underline font-semibold {{ $textColor }}">Size Guide</a>
                        </div>
                        <div class="flex flex-wrap gap-2.5 max-w-[520px]" id="gallery-size-options">
                            @foreach(['0-6 Months', '1-2 Years', '2-3 Years', '3-4 Years', '4-5 Years', '5-6 Years', '6-7 Years', '8-9 Years', '10-11 Years', '12-13 Years', '14-15 Years'] as $sizeOption)
                            @php
                                $variantId = $sizeVariantMap[$sizeOption] ?? null;
                                $disabled = !$variantId;
                                $isSelected = $sizeOption === $initialSize;
                            @endphp
                            <button type="button" data-size="{{ $sizeOption }}" data-variant-id="{{ $variantId }}" class="gallery-size-btn h-11 px-4 rounded-full border {{ $borderColor }} text-sm font-semibold {{ $textColor }} hover:bg-black/5 transition-colors {{ $isSelected ? 'bg-black text-white border-black' : '' }} {{ $disabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}">
                                {{ $sizeOption }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($linkedProduct)
                <form action="{{ route('cart.add') }}" method="POST" id="gallery-add-to-cart-form" class="space-y-3 mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $linkedProduct->id }}">
                    <input type="hidden" name="quantity" id="gallery-qty-hidden" value="1">
                    <input type="hidden" name="buy_now" id="gallery-buy-now" value="0">
                    <input type="hidden" name="variant_id" id="gallery-variant-id" value="{{ $sizeVariantMap[$initialSize] ?? '' }}">
                    <input type="hidden" name="selected_size" id="gallery-selected-size" value="{{ $initialSize }}">

                    <div class="max-w-[520px]">
                        <div class="mb-2 flex items-center gap-2">
                            <div class="relative flex-1 min-w-0">
                                <input id="gallery-delivery-pincode-input" type="text" inputmode="numeric" maxlength="6" autocomplete="off" placeholder="Express Delivery? Start with your PIN" class="w-full h-9 border {{ $borderColor }} px-3 text-xs {{ $isDark ? 'bg-[#230030] text-white' : 'bg-white text-gray-900' }}" />
                                <div id="gallery-delivery-pincode-suggestions" class="hidden absolute left-0 right-0 top-[calc(100%+4px)] z-30 border {{ $borderColor }} {{ $isDark ? 'bg-[#1f0028] text-white' : 'bg-white text-gray-900' }} max-h-52 overflow-y-auto shadow-lg"></div>
                            </div>
                            <button id="gallery-delivery-pincode-check-btn" type="button" class="h-9 px-3 {{ $isDark ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-[#122f2f] text-white' }} text-[11px] font-semibold whitespace-nowrap">Check Service</button>
                        </div>
                        <p id="gallery-delivery-pincode-feedback" class="text-[11px] text-red-500 mb-2">Valid 6-digit PIN required</p>

                        <div class="flex items-stretch gap-2 h-11 mb-1">
                            <div class="flex items-center border {{ $borderColor }} w-[96px] shrink-0 {{ $isDark ? 'bg-[#230030]' : 'bg-white' }}">
                                <button type="button" onclick="galleryQtyDown()" class="w-full h-full text-lg">−</button>
                                <input type="number" id="gallery-qty" min="1" value="1" readonly class="w-8 text-center bg-transparent border-none p-0 focus:ring-0 text-sm font-semibold" />
                                <button type="button" onclick="galleryQtyUp()" class="w-full h-full text-lg">+</button>
                            </div>
                            <button type="button" onclick="galleryAddToCart(true)" class="flex-1 h-full {{ $isDark ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-black text-white' }} text-[14px] font-semibold uppercase tracking-wide">Add To Cart &bull; ₹{{ number_format((float)$price, 0) }}</button>
                        </div>
                        <button type="button" onclick="galleryBuyNow()" class="w-full h-11 border {{ $isDark ? 'border-[#d4af37] text-[#f3d9ff] hover:bg-[#d4af37]/10' : 'border-black text-black hover:bg-black/5' }} text-[12px] font-semibold uppercase tracking-wide">Buy It Now</button>

                        <div class="space-y-3 mt-3 text-sm md:text-base {{ $mutedColor }} leading-snug">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                <div class="flex items-center gap-2"><span class="text-base">◈</span><span>100% Purchase Protection</span></div>
                                <div class="flex items-center gap-2"><span class="text-base">◎</span><span>Assured Quality</span></div>
                                <div class="flex items-center gap-2"><span class="text-base">↻</span><span>{{ $isReturnable ? 'This product is returnable' : 'This product is not returnable' }}</span></div>
                                <div class="flex items-center gap-2"><span class="text-base">✈</span><span>Free shipping*</span></div>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="space-y-3 mb-8">
                    <a href="https://wa.me/91908671144?text={{ $whatsAppMessage }}" target="_blank" class="block w-full h-11 {{ $isDark ? 'bg-[#d4af37] text-[#1a0023]' : 'bg-black text-white' }} text-[12px] font-semibold uppercase tracking-wide text-center leading-[44px]">Buy on WhatsApp</a>
                    <a href="https://wa.me/91908671144?text={{ rawurlencode('Hi AVNEE, please add ' . ($galleryProduct['title'] ?? 'this item') . ' to my cart.') }}" target="_blank" class="block w-full h-11 border {{ $isDark ? 'border-[#d4af37] text-[#f3d9ff] hover:bg-[#d4af37]/10' : 'border-black text-black hover:bg-black/5' }} text-[12px] font-semibold uppercase tracking-wide text-center leading-[44px]">Request to Add in Cart</a>
                </div>
                @endif

                <div class="space-y-px border-y {{ $borderColor }} py-3 mb-8">
                    <details class="group border-b {{ $borderColor }}" open>
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-sm font-semibold uppercase tracking-[0.16em]">
                            <span>Product Details</span>
                            <span class="text-xl leading-none transition-transform group-open:rotate-45">+</span>
                        </summary>
                        <div class="pb-4 text-sm {{ $mutedColor }} leading-relaxed">{{ $description }}</div>
                    </details>
                    <details class="group border-b {{ $borderColor }}">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-sm font-semibold uppercase tracking-[0.16em]">
                            <span>Style &amp; Fit Tips</span>
                            <span class="text-xl leading-none transition-transform group-open:rotate-45">+</span>
                        </summary>
                        <div class="pb-4 text-sm {{ $mutedColor }} leading-relaxed">Dummy text for style and fit guidance. Final content will be updated later.</div>
                    </details>
                    <details class="group border-b {{ $borderColor }}">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-sm font-semibold uppercase tracking-[0.16em]">
                            <span>Shipping &amp; Returns</span>
                            <span class="text-xl leading-none transition-transform group-open:rotate-45">+</span>
                        </summary>
                        <div class="pb-4 text-sm {{ $mutedColor }} leading-relaxed">Dummy shipping and returns text placeholder. You can replace this with actual policy content later.</div>
                    </details>
                    <details class="group">
                        <summary class="flex justify-between items-center py-4 cursor-pointer list-none text-sm font-semibold uppercase tracking-[0.16em]">
                            <span>FAQs</span>
                            <span class="text-xl leading-none transition-transform group-open:rotate-45">+</span>
                        </summary>
                        <div class="pb-2 text-sm {{ $mutedColor }} leading-relaxed">Dummy FAQ text placeholder. Actual frequently asked questions can be added later.</div>
                    </details>
                </div>

                <div class="mt-10 border-y {{ $borderColor }} py-6 space-y-3">
                    <p class="text-sm {{ $mutedColor }}">Main image is shown first, and all remaining photos from this product folder are available in the gallery below.</p>
                    <a href="{{ route('front.products.index', ['category' => $category]) }}" class="inline-flex items-center text-xs font-bold uppercase tracking-[0.25em] {{ $accentColor }} hover:underline">Back to {{ $categoryLabel }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($similarGalleryProducts) || !empty($recentlyViewedGalleryProducts))
<section class="bg-[#f5f5f5] border-t border-black/5 py-12">
    <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12">
        @if(!empty($similarGalleryProducts))
        <div>
            <h2 class="text-2xl sm:text-3xl font-heading text-center {{ $textColor }} mb-6">Similar Products</h2>
            <div class="relative group">
                <button type="button" id="similar-prev" class="absolute left-0 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-black/10 text-black shadow-sm hidden sm:flex items-center justify-center">&#8249;</button>
                <button type="button" id="similar-next" class="absolute right-0 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-black/10 text-black shadow-sm hidden sm:flex items-center justify-center">&#8250;</button>
                <div id="similar-rail" class="flex gap-4 overflow-x-auto hide-scrollbar scroll-smooth">
                    @foreach($similarGalleryProducts as $card)
                    <a href="{{ $card['url'] }}" class="min-w-[180px] sm:min-w-[210px] lg:min-w-[240px] bg-white border border-black/10 block">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover" loading="lazy" />
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-medium leading-snug text-black line-clamp-2">{{ $card['title'] }}</p>
                            <p class="text-base font-bold text-black mt-1">₹{{ number_format((float) ($card['price'] ?? 0), 0) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if(!empty($recentlyViewedGalleryProducts))
        <div>
            <h2 class="text-2xl sm:text-3xl font-heading text-center {{ $textColor }} mb-6">Recently Viewed</h2>
            <div class="relative group">
                <button type="button" id="recent-prev" class="absolute left-0 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-black/10 text-black shadow-sm hidden sm:flex items-center justify-center">&#8249;</button>
                <button type="button" id="recent-next" class="absolute right-0 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-black/10 text-black shadow-sm hidden sm:flex items-center justify-center">&#8250;</button>
                <div id="recent-rail" class="flex gap-4 overflow-x-auto hide-scrollbar scroll-smooth">
                    @foreach($recentlyViewedGalleryProducts as $card)
                    <a href="{{ $card['url'] }}" class="min-w-[180px] sm:min-w-[210px] lg:min-w-[240px] bg-white border border-black/10 block">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover" loading="lazy" />
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-medium leading-snug text-black line-clamp-2">{{ $card['title'] }}</p>
                            <p class="text-base font-bold text-black mt-1">₹{{ number_format((float) ($card['price'] ?? 0), 0) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<div id="gallery-cart-overlay" class="fixed inset-0 bg-black/40 z-[120] hidden"></div>
<aside id="gallery-cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-[430px] bg-white text-gray-900 z-[130] shadow-2xl translate-x-full transition-transform duration-300">
    <div class="h-full flex flex-col">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-[42px] leading-[0.95] font-semibold tracking-tight">Your Cart <span id="gallery-drawer-count" class="text-[30px] font-medium text-gray-500">Items 0</span></h3>
            <button type="button" onclick="closeGalleryCartDrawer()" class="text-2xl leading-none text-gray-500 hover:text-black">&times;</button>
        </div>
        <div id="gallery-drawer-items" class="p-4 flex-1 overflow-y-auto space-y-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Your cart is empty.</p>
        </div>
        <div class="p-4 space-y-3">
            <div class="flex items-center justify-between text-3xl leading-none font-semibold pb-2 border-b border-gray-200">
                <span>Subtotal</span>
                <span id="gallery-drawer-subtotal">₹0</span>
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

<script>
var partyGalleryState = {
    images: @json(array_values($initialImages)),
    index: 0
};

function setPartyMainImageByIndex(index) {
    if (!Array.isArray(partyGalleryState.images) || partyGalleryState.images.length === 0) {
        return;
    }

    var boundedIndex = index;
    if (boundedIndex < 0) {
        boundedIndex = partyGalleryState.images.length - 1;
    }
    if (boundedIndex >= partyGalleryState.images.length) {
        boundedIndex = 0;
    }

    partyGalleryState.index = boundedIndex;
    var src = partyGalleryState.images[boundedIndex];
    var mainImage = document.getElementById('main-party-image');
    if (mainImage) {
        mainImage.src = src;
    }

    var counter = document.getElementById('party-slider-count');
    if (counter) {
        counter.textContent = (boundedIndex + 1) + ' / ' + partyGalleryState.images.length;
    }

    document.querySelectorAll('.party-thumb').forEach(function(btn, i) {
        btn.classList.remove('ring-2', 'ring-black/60', 'dark:ring-white/60');
        if (i === boundedIndex) {
            btn.classList.add('ring-2', 'ring-black/60', 'dark:ring-white/60');
            btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    });

    var prevBtn = document.getElementById('party-slider-prev');
    var nextBtn = document.getElementById('party-slider-next');
    var hiddenClass = 'hidden';
    if (prevBtn && nextBtn) {
        if (partyGalleryState.images.length <= 1) {
            prevBtn.classList.add(hiddenClass);
            nextBtn.classList.add(hiddenClass);
        } else {
            prevBtn.classList.remove(hiddenClass);
            nextBtn.classList.remove(hiddenClass);
        }
    }
}

function changePartyImage(src, el) {
    var index = partyGalleryState.images.indexOf(src);
    if (index === -1) {
        partyGalleryState.images.push(src);
        index = partyGalleryState.images.length - 1;
    }
    setPartyMainImageByIndex(index);
}

function switchGalleryColor(button) {
    var thumbsContainer = document.getElementById('party-thumbs');
    var rawImages = button.getAttribute('data-images') || '[]';
    var images = [];

    try {
        images = JSON.parse(rawImages);
    } catch (e) {
        images = [];
    }

    if (!Array.isArray(images) || images.length === 0) {
        images = [button.getAttribute('data-main')];
    }

    document.querySelectorAll('.color-option-btn').forEach(function(btn) {
        btn.classList.remove('ring-2', 'ring-black/60', 'border-black');
        btn.classList.add('border-white/70');
    });
    button.classList.add('ring-2', 'ring-black/60', 'border-black');
    button.classList.remove('border-white/70');

    var selectedColorLabel = document.getElementById('selected-color-name');
    if (selectedColorLabel) {
        selectedColorLabel.textContent = button.getAttribute('data-label') || 'Selected Color';
    }

    if (!thumbsContainer) {
        return;
    }

    var title = @json($galleryProduct['title']);
    thumbsContainer.innerHTML = '';

    images.forEach(function(image, index) {
        var thumbButton = document.createElement('button');
        thumbButton.type = 'button';
        thumbButton.className = 'party-thumb flex-none w-20 sm:w-24 aspect-[3/4] overflow-hidden border {{ $borderColor }} bg-black/5';
        if (index === 0) {
            thumbButton.classList.add('ring-2', 'ring-black/60', 'dark:ring-white/60');
        }
        thumbButton.setAttribute('onclick', 'changePartyImage(' + JSON.stringify(image) + ', this)');

        var img = document.createElement('img');
        img.src = image;
        img.alt = title;
        img.className = 'w-full h-full object-cover object-top';

        thumbButton.appendChild(img);
        thumbsContainer.appendChild(thumbButton);
    });

    partyGalleryState.images = images;
    setPartyMainImageByIndex(0);
}

function applyColorSwatches() {
    var swatches = document.querySelectorAll('.color-option-btn');

    function rgbToHsv(r, g, b) {
        r /= 255;
        g /= 255;
        b /= 255;

        var max = Math.max(r, g, b);
        var min = Math.min(r, g, b);
        var delta = max - min;
        var h = 0;

        if (delta !== 0) {
            if (max === r) {
                h = ((g - b) / delta) % 6;
            } else if (max === g) {
                h = (b - r) / delta + 2;
            } else {
                h = (r - g) / delta + 4;
            }
            h = Math.round(h * 60);
            if (h < 0) h += 360;
        }

        var s = max === 0 ? 0 : delta / max;
        var v = max;
        return { h: h, s: s, v: v };
    }

    function hueDistance(a, b) {
        var d = Math.abs(a - b) % 360;
        return d > 180 ? 360 - d : d;
    }

    swatches.forEach(function(swatch) {
        var imageUrl = swatch.getAttribute('data-main');
        if (!imageUrl) {
            swatch.style.backgroundColor = '#d4af37';
            return;
        }

        var img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function() {
            var canvas = document.createElement('canvas');
            canvas.width = 96;
            canvas.height = 96;
            var ctx = canvas.getContext('2d');
            if (!ctx) {
                swatch.style.backgroundColor = '#d4af37';
                return;
            }

            ctx.drawImage(img, 0, 0, 96, 96);
            var pixels = ctx.getImageData(0, 0, 96, 96).data;
            var bins = new Array(36).fill(null).map(function() {
                return { score: 0, r: 0, g: 0, b: 0, count: 0 };
            });

            // Estimate dominant background hue from border pixels.
            var bgHueBins = new Array(36).fill(0);
            for (var yb = 0; yb < 96; yb++) {
                for (var xb = 0; xb < 96; xb++) {
                    var onEdge = xb < 8 || xb > 87 || yb < 8 || yb > 87;
                    if (!onEdge) continue;
                    var edgeIndex = (yb * 96 + xb) * 4;
                    var er = pixels[edgeIndex];
                    var eg = pixels[edgeIndex + 1];
                    var eb = pixels[edgeIndex + 2];
                    var ea = pixels[edgeIndex + 3];
                    if (ea < 24) continue;
                    var ehsv = rgbToHsv(er, eg, eb);
                    if (ehsv.s < 0.08 || ehsv.v < 0.1) continue;
                    var eBin = Math.min(35, Math.floor(ehsv.h / 10));
                    bgHueBins[eBin] += 1;
                }
            }

            var bgHueBin = 0;
            for (var bgi = 1; bgi < bgHueBins.length; bgi++) {
                if (bgHueBins[bgi] > bgHueBins[bgHueBin]) {
                    bgHueBin = bgi;
                }
            }
            var bgHue = bgHueBin * 10 + 5;

            var cx = 47.5;
            var cy = 47.5;
            var maxDist = Math.sqrt(cx * cx + cy * cy);

            for (var i = 0; i < pixels.length; i += 4) {
                var r = pixels[i];
                var g = pixels[i + 1];
                var b = pixels[i + 2];
                var a = pixels[i + 3];
                if (a < 24) continue;

                var hsv = rgbToHsv(r, g, b);
                if (hsv.s < 0.16 || hsv.v < 0.14 || hsv.v > 0.97) continue;

                var pixelIndex = i / 4;
                var x = pixelIndex % 96;
                var y = Math.floor(pixelIndex / 96);
                var dist = Math.sqrt(Math.pow(x - cx, 2) + Math.pow(y - cy, 2));
                var centerWeight = 0.35 + (1 - (dist / maxDist)) * 0.85;

                var bgDist = hueDistance(hsv.h, bgHue);
                var backgroundPenalty = (bgDist < 18 && hsv.s < 0.55) ? 0.25 : 1;

                var binIndex = Math.min(35, Math.floor(hsv.h / 10));
                var weight = ((hsv.s * 0.85) + (hsv.v * 0.15)) * centerWeight * backgroundPenalty;

                bins[binIndex].score += weight;
                bins[binIndex].r += r * weight;
                bins[binIndex].g += g * weight;
                bins[binIndex].b += b * weight;
                bins[binIndex].count += weight;
            }

            var bestBin = bins.reduce(function(best, current) {
                return current.score > best.score ? current : best;
            }, bins[0]);

            if (!bestBin || bestBin.count <= 0) {
                swatch.style.backgroundColor = '#d4af37';
                return;
            }

            var rr = Math.round(bestBin.r / bestBin.count);
            var gg = Math.round(bestBin.g / bestBin.count);
            var bb = Math.round(bestBin.b / bestBin.count);

            swatch.style.backgroundColor = 'rgb(' + rr + ',' + gg + ',' + bb + ')';
        };
        img.onerror = function() {
            swatch.style.backgroundColor = '#d4af37';
        };
        img.src = imageUrl;
    });
}

function galleryQtyUp() {
    var qty = document.getElementById('gallery-qty');
    if (!qty) return;
    qty.value = parseInt(qty.value || '1', 10) + 1;
    syncGalleryQty();
}

function galleryQtyDown() {
    var qty = document.getElementById('gallery-qty');
    if (!qty) return;
    var next = parseInt(qty.value || '1', 10) - 1;
    qty.value = next < 1 ? 1 : next;
    syncGalleryQty();
}

function syncGalleryQty() {
    var qty = document.getElementById('gallery-qty');
    var hiddenQty = document.getElementById('gallery-qty-hidden');
    if (qty && hiddenQty) {
        hiddenQty.value = qty.value;
    }
}

function galleryBuyNow() {
    var buyNow = document.getElementById('gallery-buy-now');
    if (buyNow) {
        buyNow.value = '1';
    }
    var form = document.getElementById('gallery-add-to-cart-form');
    if (form) {
        syncGalleryQty();
        form.submit();
    }
}

function formatCurrency(value) {
    var num = Number(value || 0);
    return '₹' + Math.round(num).toLocaleString('en-IN');
}

function escapeHtml(text) {
    var value = String(text || '');
    return value
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function renderGalleryDrawerItems(payload) {
    var itemsHost = document.getElementById('gallery-drawer-items');
    if (!itemsHost) {
        return;
    }

    var items = Array.isArray(payload.items) ? payload.items : [];
    if (items.length === 0) {
        itemsHost.innerHTML = '<p class="text-sm text-gray-500">Your cart is empty.</p>';
        return;
    }

    itemsHost.innerHTML = items.map(function(item) {
        var fallbackImage = (document.getElementById('main-party-image') || {}).src || '';
        var image = item.image ? item.image : fallbackImage;
        var sizeText = item.size ? item.size : 'Free Size';
        var itemUrl = item.product_url ? item.product_url : '#';
        return '' +
            '<div class="flex gap-4 pb-4 border-b border-gray-200">' +
                '<img src="' + escapeHtml(image) + '" alt="' + escapeHtml(item.title) + '" class="w-20 h-24 object-cover border" />' +
                '<div class="flex-1 min-w-0">' +
                    '<div class="flex items-start justify-between gap-2">' +
                        '<p class="text-[16px] leading-[1.2] font-medium text-gray-900 line-clamp-2">' + escapeHtml(String(item.qty || 1) + ' x ' + item.title) + '</p>' +
                        '<div class="flex gap-2 text-gray-500">' +
                            '<button type="button" onclick="updateGalleryCartItem(' + Number(item.id) + ', -1)" class="text-xs border border-gray-300 px-1">−</button>' +
                            '<button type="button" onclick="updateGalleryCartItem(' + Number(item.id) + ', 1)" class="text-xs border border-gray-300 px-1">+</button>' +
                        '</div>' +
                    '</div>' +
                    '<p class="text-[16px] text-gray-900 mt-2 font-semibold">MRP ' + formatCurrency(item.line_total) + '</p>' +
                    '<p class="text-[16px] text-gray-700 mt-1">Size: ' + escapeHtml(sizeText) + '</p>' +
                    '<div class="mt-2 flex items-center justify-between">' +
                        '<a href="' + escapeHtml(itemUrl) + '" class="text-[14px] text-[#0d3b7a] underline">View Details</a>' +
                        '<button type="button" onclick="removeGalleryCartItem(' + Number(item.id) + ')" class="text-gray-500 text-lg leading-none">🗑</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
    }).join('');
}

function cartUpdateUrl(itemId) {
    return @json(route('front.cart.update', ['id' => '__ID__'])).replace('__ID__', String(itemId));
}

function cartRemoveUrl(itemId) {
    return @json(route('front.cart.remove', ['id' => '__ID__'])).replace('__ID__', String(itemId));
}

function updateGalleryCartItem(itemId, delta) {
    fetchCartSummary().then(function(summary) {
        var items = Array.isArray(summary.items) ? summary.items : [];
        var found = items.find(function(i) { return Number(i.id) === Number(itemId); });
        if (!found) return;
        var qty = Math.max(1, Number(found.qty || 1) + Number(delta || 0));
        return fetch(cartUpdateUrl(itemId), {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ _method: 'PATCH', quantity: String(qty) })
        }).then(function() { return fetchCartSummary(); }).then(function(nextSummary) {
            openGalleryCartDrawer(nextSummary);
        });
    });
}

function removeGalleryCartItem(itemId) {
    fetch(cartRemoveUrl(itemId), {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': @json(csrf_token()),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ _method: 'DELETE' })
    }).then(function() { return fetchCartSummary(); }).then(function(nextSummary) {
        openGalleryCartDrawer(nextSummary);
    });
}

function openGalleryCartDrawer(payload) {
    var overlay = document.getElementById('gallery-cart-overlay');
    var drawer = document.getElementById('gallery-cart-drawer');
    if (!overlay || !drawer) {
        return;
    }

    renderGalleryDrawerItems(payload);
    document.getElementById('gallery-drawer-subtotal').textContent = formatCurrency(payload.subtotal || 0);
    document.getElementById('gallery-drawer-count').textContent = 'Items ' + String(payload.item_count || 0);

    overlay.classList.remove('hidden');
    drawer.classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden';
}

function fetchCartSummary() {
    return fetch(@json(route('front.cart.summary')), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    }).then(function(response) {
        if (!response.ok) {
            throw new Error('Failed to fetch cart summary');
        }
        return response.json();
    });
}

function closeGalleryCartDrawer() {
    var overlay = document.getElementById('gallery-cart-overlay');
    var drawer = document.getElementById('gallery-cart-drawer');
    if (!overlay || !drawer) {
        return;
    }

    drawer.classList.add('translate-x-full');
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
}

function galleryAddToCart(openDrawer) {
    var form = document.getElementById('gallery-add-to-cart-form');
    if (!form) {
        return;
    }

    syncGalleryQty();
    var buyNow = document.getElementById('gallery-buy-now');
    if (buyNow) {
        buyNow.value = '0';
    }

    var formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (openDrawer) {
            fetchCartSummary().then(function(summary) {
                openGalleryCartDrawer(summary);
            });
        }
    })
    .catch(function() {
        form.submit();
    });
}

function bindHorizontalRail(railId, prevId, nextId) {
    var rail = document.getElementById(railId);
    var prev = document.getElementById(prevId);
    var next = document.getElementById(nextId);
    if (!rail || !prev || !next) {
        return;
    }

    var step = function() {
        return Math.max(220, Math.floor(rail.clientWidth * 0.72));
    };

    prev.addEventListener('click', function() {
        rail.scrollBy({ left: -step(), behavior: 'smooth' });
    });
    next.addEventListener('click', function() {
        rail.scrollBy({ left: step(), behavior: 'smooth' });
    });
}

function initGallerySizeSelection() {
    var sizeButtons = document.querySelectorAll('.gallery-size-btn');
    if (!sizeButtons.length) {
        return;
    }

    var selectedSizeInput = document.getElementById('gallery-selected-size');
    var variantIdInput = document.getElementById('gallery-variant-id');

    function selectSize(button) {
        sizeButtons.forEach(function(btn) {
            btn.classList.remove('bg-black', 'text-white', 'border-black');
        });
        button.classList.add('bg-black', 'text-white', 'border-black');
        if (selectedSizeInput) {
            selectedSizeInput.value = button.getAttribute('data-size') || '';
        }
        if (variantIdInput) {
            variantIdInput.value = button.getAttribute('data-variant-id') || '';
        }
    }

    sizeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            selectSize(button);
        });
    });

    var initial = document.querySelector('.gallery-size-btn.bg-black');
    if (initial) {
        selectSize(initial);
    } else {
        var firstEnabled = Array.prototype.slice.call(sizeButtons).find(function(btn) {
            return String(btn.getAttribute('data-variant-id') || '').trim() !== '';
        });
        if (firstEnabled) {
            selectSize(firstEnabled);
        }
    }
}

function initGalleryPincodeValidation() {
    var input = document.getElementById('gallery-delivery-pincode-input');
    var checkBtn = document.getElementById('gallery-delivery-pincode-check-btn');
    var feedback = document.getElementById('gallery-delivery-pincode-feedback');
    var list = document.getElementById('gallery-delivery-pincode-suggestions');
    if (!input || !checkBtn || !feedback || !list) {
        return;
    }

    var DATASET_URLS = [
        'https://cdn.jsdelivr.net/gh/saravanakumargn/All-India-Pincode-Directory@master/all-india-pincode-json-array.json',
        'https://raw.githubusercontent.com/saravanakumargn/All-India-Pincode-Directory/master/all-india-pincode-json-array.json'
    ];
    var allPincodes = [];
    var byPincode = new Map();
    var loaded = false;
    var loadingPromise = null;

    var setFeedback = function(message, isError) {
        if (isError === undefined) isError = true;
        feedback.textContent = message;
        feedback.classList.toggle('text-red-500', isError);
        feedback.classList.toggle('text-green-600', !isError);
    };

    var hideSuggestions = function() {
        list.classList.add('hidden');
        list.innerHTML = '';
    };

    var loadDataset = function() {
        if (loaded) return Promise.resolve();
        if (loadingPromise) return loadingPromise;
        loadingPromise = (async function() {
            var rows = null;
            for (var i = 0; i < DATASET_URLS.length; i++) {
                try {
                    var res = await fetch(DATASET_URLS[i]);
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
            .then(function(rows) {
                var seen = new Set();
                (Array.isArray(rows) ? rows : []).forEach(function(row) {
                    var pin = String(row.pincode || '').replace(/\D/g, '').slice(0, 6);
                    if (!/^\d{6}$/.test(pin)) return;
                    if (!seen.has(pin)) {
                        allPincodes.push(pin);
                        seen.add(pin);
                    }
                    if (!byPincode.has(pin)) {
                        byPincode.set(pin, {
                            district: row.Districtname || '',
                            state: row.statename || ''
                        });
                    }
                });
                allPincodes.sort();
                loaded = true;
            })
            .catch(function() {
                setFeedback('Unable to load pincode suggestions right now. Enter full PIN to validate.');
            });
        return loadingPromise;
    };

    var renderSuggestions = function(value) {
        var query = String(value || '').replace(/\D/g, '');
        if (query.length < 2) {
            hideSuggestions();
            return;
        }
        loadDataset().then(function() {
            if (!loaded) return;
            var matches = allPincodes.filter(function(pin) { return pin.indexOf(query) === 0; }).slice(0, 8);
            if (!matches.length) {
                hideSuggestions();
                return;
            }
            list.innerHTML = matches.map(function(pin) {
                var meta = byPincode.get(pin) || {};
                var hint = [meta.district, meta.state].filter(Boolean).join(', ');
                return '<button type="button" class="w-full text-left px-3 py-2 text-xs hover:' + @json($isDark ? 'bg-[#2b003a]' : 'bg-gray-100') + '" data-pin="' + pin + '"><span class="font-semibold">' + pin + '</span>' + (hint ? '<span class="block opacity-70 mt-0.5">' + hint + '</span>' : '') + '</button>';
            }).join('');
            list.classList.remove('hidden');
        });
    };

    input.addEventListener('input', function() {
        input.value = input.value.replace(/\D/g, '').slice(0, 6);
        setFeedback('Valid 6-digit PIN required', true);
        renderSuggestions(input.value);
    });
    input.addEventListener('focus', function() {
        renderSuggestions(input.value);
    });
    list.addEventListener('click', function(event) {
        var btn = event.target.closest('[data-pin]');
        if (!btn) return;
        input.value = btn.getAttribute('data-pin') || '';
        hideSuggestions();
        checkBtn.click();
    });
    document.addEventListener('click', function(event) {
        if (!list.contains(event.target) && event.target !== input) {
            hideSuggestions();
        }
    });
    checkBtn.addEventListener('click', function() {
        var pin = input.value.replace(/\D/g, '').slice(0, 6);
        input.value = pin;
        if (!/^\d{6}$/.test(pin)) {
            setFeedback('Please enter a valid 6-digit PIN code.');
            return;
        }
        loadDataset().then(function() {
            if (loaded && byPincode.has(pin)) {
                var meta = byPincode.get(pin) || {};
                var location = [meta.district, meta.state].filter(Boolean).join(', ');
                setFeedback('Delivery available at ' + pin + (location ? ' for ' + location : '') + '.', false);
                return;
            }

            fetch('https://api.postalpincode.in/pincode/' + pin)
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    var first = Array.isArray(data) ? data[0] : null;
                    var offices = first && Array.isArray(first.PostOffice) ? first.PostOffice : [];
                    if (first && first.Status === 'Success' && offices.length > 0) {
                        var place = [offices[0].District, offices[0].State].filter(Boolean).join(', ');
                        setFeedback('Valid Indian PIN: ' + pin + (place ? ' (' + place + ')' : '') + '.', false);
                    } else {
                        setFeedback('PIN ' + pin + ' is not a valid Indian pincode.');
                    }
                })
                .catch(function() {
                    setFeedback('Could not verify PIN right now. Please try again.');
                });
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    applyColorSwatches();
    syncGalleryQty();
    initGallerySizeSelection();
    initGalleryPincodeValidation();
    bindHorizontalRail('similar-rail', 'similar-prev', 'similar-next');
    bindHorizontalRail('recent-rail', 'recent-prev', 'recent-next');

    var drawerOverlay = document.getElementById('gallery-cart-overlay');
    if (drawerOverlay) {
        drawerOverlay.addEventListener('click', closeGalleryCartDrawer);
    }

    var prevBtn = document.getElementById('party-slider-prev');
    var nextBtn = document.getElementById('party-slider-next');

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            setPartyMainImageByIndex(partyGalleryState.index - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            setPartyMainImageByIndex(partyGalleryState.index + 1);
        });
    }

    setPartyMainImageByIndex(0);
});
</script>
@endsection
