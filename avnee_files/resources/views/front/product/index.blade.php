@extends('layouts.front.' . $theme)

@section('content')
@php
    $isDark = $theme === 'jewellery';
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#e9d5ff]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $bgColor = $isDark ? 'bg-[#230030]' : 'bg-white';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-gray-50';
    $inputClass = $isDark ? 'bg-[#2B003A] border-[#4f006a] text-white focus:ring-[#d4af37] focus:border-[#d4af37]' : 'bg-white border-gray-300 text-gray-900 focus:ring-[#b87333] focus:border-[#b87333]';
    $collectionLabels = [
        'sale' => 'Sale Collection',
        'new-arrivals' => 'New Arrivals',
        'best-sellers' => 'Best Sellers',
        'bogo' => 'BOGO Collection',
        'organizers' => 'Organizers',
        'gifting' => 'Gifting',
        'all-collections' => 'All Collections',
        'party-frocks' => 'Party Frocks',
        'summer-collections' => 'Summer Collections',
        'festive-wear' => 'Festive Wear',
        'daily-wear' => 'Daily Wear',
        'all-sarees' => 'All Sarees',
        'printed-cotton' => 'Printed Cotton',
        'georgette' => 'Georgette',
        'semi-silk' => 'Semi Silk',
    ];
    $collectionExperiences = [
        'sale' => [
            'eyebrow' => 'Limited-Time Edit',
            'title' => 'Seasonal Sale Atelier',
            'description' => 'Timed markdowns on festive, party, and signature looks. Curated to help you build complete looks without compromise.',
            'chips' => ['Top Discount Picks', 'Under 1999', 'Occasion Ready'],
            'cta' => route('front.products.index', ['collection' => 'sale', 'discount' => 1]),
            'cta_text' => 'Shop Markdowns',
        ],
        'new-arrivals' => [
            'eyebrow' => 'Fresh In',
            'title' => 'New Arrival Journal',
            'description' => 'Discover the latest silhouettes, tones, and textures as soon as they land. Updated continuously for both studio and celebration dressing.',
            'chips' => ['This Week', 'Trending Now', 'Limited Quantities'],
            'cta' => route('front.products.index', ['collection' => 'new-arrivals', 'sort' => 'newest']),
            'cta_text' => 'Explore Fresh Drops',
        ],
        'best-sellers' => [
            'eyebrow' => 'Most Loved',
            'title' => 'Best-Seller Registry',
            'description' => 'The most re-ordered and re-loved AVNEE pieces. Tested by real wardrobes and selected for repeat-wear value.',
            'chips' => ['Top Rated', 'Repeat Buys', 'Iconic Fits'],
            'cta' => route('front.products.index', ['collection' => 'best-sellers', 'sort' => 'price_desc']),
            'cta_text' => 'Browse Top Picks',
        ],
        'bogo' => [
            'eyebrow' => 'Pair Better',
            'title' => 'BOGO & Bundle Deck',
            'description' => 'Build match-ready bundles and maximize value on combo-friendly pieces designed for family wardrobes and gifting.',
            'chips' => ['Combo Eligible', 'Mix & Match', 'Value Bundles'],
            'cta' => route('front.products.index', ['collection' => 'bogo', 'bogo' => 1]),
            'cta_text' => 'Unlock Bundle Value',
        ],
        'organizers' => [
            'eyebrow' => 'Declutter Edit',
            'title' => 'Organizers Collection',
            'description' => 'Functional organisers designed to keep your jewellery, accessories, and daily picks sorted beautifully.',
            'chips' => ['Smart Storage', 'Daily Utility', 'Neat Display'],
            'cta' => route('front.products.collection', ['collection' => 'organizers']),
            'cta_text' => 'Shop Organizers',
        ],
        'gifting' => [
            'eyebrow' => 'Gift-Ready Picks',
            'title' => 'Gifting Collection',
            'description' => 'Curated gifting favourites for celebrations, return gifts, and thoughtful everyday surprises.',
            'chips' => ['Gift Boxes', 'Occasion Picks', 'Ready to Gift'],
            'cta' => route('front.products.collection', ['collection' => 'gifting']),
            'cta_text' => 'Shop Gifting',
        ],
    ];
    $activeCollection = request('collection');
    $collectionHeadingPriority = ['all-collections', 'party-frocks', 'summer-collections', 'festive-wear', 'daily-wear', 'all-sarees', 'printed-cotton', 'georgette', 'semi-silk'];
    $formatFilterLabel = function (?string $raw): string {
        $raw = (string) $raw;
        if ($raw === '') {
            return '';
        }
        $protected = preg_replace('/(?<=\d)-(?=\d)/', '__RANGE__', $raw) ?? $raw;
        $spaced = str_replace('-', ' ', $protected);
        $restored = str_replace('__RANGE__', '-', $spaced);
        return ucfirst($restored);
    };
    $resolvePriceBandLabel = function () {
        $hasMin = request()->filled('min_price');
        $hasMax = request()->filled('max_price');

        if (!$hasMin && !$hasMax) {
            return null;
        }

        $min = $hasMin ? (int) request('min_price') : null;
        $max = $hasMax ? (int) request('max_price') : null;

        if ($min === null && $max === 399) {
            return 'Under 399';
        }

        if ($min === 400 && $max === 599) {
            return 'Under 599';
        }

        if ($min === 600 && $max === 999) {
            return 'Under 999';
        }

        if ($min === 1000 && $max === null) {
            return 'Under 1999';
        }

        if ($min === null && $max !== null) {
            return 'Under ' . $max;
        }

        if ($min !== null && $max !== null) {
            return $min . ' - ' . $max;
        }

        return $min . ' & Above';
    };
    $priceBandLabel = $resolvePriceBandLabel();
    $headingText = ($activeCollection && in_array($activeCollection, $collectionHeadingPriority, true))
        ? ($collectionLabels[$activeCollection] ?? 'All Collections')
        : (request('category')
            ? $formatFilterLabel(request('category'))
            : ($priceBandLabel ?: ($collectionLabels[$activeCollection] ?? 'All Collections')));

    $selectedCategorySlug = (string) request('category', '');
    $selectedCategoryNode = null;
    $selectedParentNode = null;
    if ($selectedCategorySlug !== '') {
        foreach ($categories as $catNode) {
            if ((string) $catNode->slug === $selectedCategorySlug) {
                $selectedCategoryNode = $catNode;
                break;
            }
            foreach (($catNode->children ?? collect()) as $childNode) {
                if ((string) $childNode->slug === $selectedCategorySlug) {
                    $selectedCategoryNode = $childNode;
                    $selectedParentNode = $catNode;
                    break 2;
                }
            }
        }
    }
    $breadcrumbCategory = $selectedParentNode ?? ($selectedCategoryNode && !($selectedCategoryNode->parent_id ?? null) ? $selectedCategoryNode : null);
    $breadcrumbSubcategory = $selectedParentNode ? $selectedCategoryNode : null;
    $onlineImage = function (string $keyword, int $seed = 1): string {
        $sanitized = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', ',', $keyword), ','));
        if ($sanitized === '') {
            $sanitized = 'fashion,jewellery';
        }

        return 'https://loremflickr.com/900/1200/' . $sanitized . '?lock=' . $seed;
    };
    $listingFallbackImage = $isDark
        ? asset('images/hero-slider/3.png')
        : asset('images/hero-slider/summer-classics.png');

    $sareeSyncFallbacks = array_map(fn($i) => asset('images/sarees-sync/' . $i . '.webp'), range(1, 10));

    $categoryFallbacks = [
        'party-frocks' => array_map(fn($i) => $onlineImage('girls party frock fashion', 100 + $i), range(1, 16)),
        'festive-wear' => array_map(fn($i) => $onlineImage('kids festive ethnic dress', 200 + $i), range(1, 16)),
        'girls-dresses' => array_map(fn($i) => $onlineImage('girls dress fashion', 300 + $i), range(1, 16)),
        'infant-sets' => array_map(fn($i) => $onlineImage('baby ethnic outfit', 400 + $i), range(1, 16)),
        '2-4-years' => array_map(fn($i) => $onlineImage('toddler girls outfit', 500 + $i), range(1, 16)),
        '4-6-years' => array_map(fn($i) => $onlineImage('kids outfit fashion', 600 + $i), range(1, 16)),
        '6-14-years' => array_map(fn($i) => $onlineImage('teens ethnic wear', 700 + $i), range(1, 16)),
        'sarees' => $sareeSyncFallbacks,
        'jewellery' => array_map(fn($i) => $onlineImage('indian jewellery set', 900 + $i), range(1, 16)),
        'jewellery-gallery' => array_map(fn($i) => $onlineImage('bridal jewellery collection', 1000 + $i), range(1, 16)),
        'earrings' => array_map(fn($i) => $onlineImage('earrings jewellery', 1100 + $i), range(1, 16)),
        'necklace' => array_map(fn($i) => $onlineImage('necklace jewellery', 1200 + $i), range(1, 16)),
        'rings' => array_map(fn($i) => $onlineImage('ring jewellery', 1300 + $i), range(1, 16)),
        'bangles-bracelet' => array_map(fn($i) => $onlineImage('bangles bracelet jewellery', 1400 + $i), range(1, 16)),
        'necklace-set' => array_map(fn($i) => $onlineImage('necklace set jewellery', 1500 + $i), range(1, 16)),
        'belt' => array_map(fn($i) => $onlineImage('waist belt accessory women', 1600 + $i), range(1, 16)),
        'maangtikkas' => array_map(fn($i) => $onlineImage('maang tikka jewellery', 1700 + $i), range(1, 16)),
        'mens-accessories' => array_map(fn($i) => $onlineImage('mens accessory fashion', 1800 + $i), range(1, 16)),
        'anklet' => array_map(fn($i) => $onlineImage('anklet jewellery', 1900 + $i), range(1, 16)),
        'mathapati' => array_map(fn($i) => $onlineImage('matha patti jewellery', 2000 + $i), range(1, 16)),
        'anti-tarnish' => array_map(fn($i) => $onlineImage('anti tarnish jewellery', 2010 + $i), range(1, 16)),
        'korean' => array_map(fn($i) => $onlineImage('korean jewellery women', 2020 + $i), range(1, 16)),
        'traditional' => array_map(fn($i) => $onlineImage('traditional indian jewellery', 2030 + $i), range(1, 16)),
        'kundan' => array_map(fn($i) => $onlineImage('kundan jewellery set', 2040 + $i), range(1, 16)),
        'oxidised' => array_map(fn($i) => $onlineImage('oxidised silver jewellery', 2045 + $i), range(1, 16)),
        '18k-gold-plated' => array_map(fn($i) => $onlineImage('18k gold plated jewellery', 2048 + $i), range(1, 16)),
        'fashion' => array_map(fn($i) => $onlineImage('fashion jewellery for women', 2049 + $i), range(1, 16)),
        'watches' => array_map(fn($i) => $onlineImage('women watches fashion', 2050 + $i), range(1, 16)),
        'trinkets' => array_map(fn($i) => $onlineImage('fashion trinkets accessories', 2100 + $i), range(1, 16)),
        'fun-trinkets' => array_map(fn($i) => $onlineImage('cute trinkets accessories', 2200 + $i), range(1, 16)),
        'accessories' => array_map(fn($i) => asset('images/hair-accessories/ha-src-' . $i . '.jpeg'), range(1, 16)),
        'hair-accessories' => array_map(fn($i) => asset('images/hair-accessories/ha-src-' . $i . '.jpeg'), range(1, 16)),
        'organizers' => array_map(fn($i) => asset('images/hair-accessories/ha-src-' . $i . '.jpeg'), range(1, 16)),
        'gifting' => array_map(fn($i) => $onlineImage('gift jewellery festive', 2300 + $i), range(1, 16)),
    ];

    $nameFallbackRules = [
        'classic peach layered frock' => [asset('images/best-buy/classic-peach-layered-frock.png')],
        'ethnic charm festive dress' => [asset('images/best-buy/ethnic-charm-festive-dress.png')],
        'floral garden party dress' => [asset('images/best-buy/floral-garden-party-dress.png')],
        'casual chic denim set' => [asset('images/best-buy/casual-chic-denim-set.png')],
        'blush bloom ethnic set' => [asset('images/best-buy/blush-bloom-ethnic-set.png')],
        'shimmer silver party dress' => [asset('images/best-buy/shimmer-silver-party-dress.png')],
        'glam black sequin dress' => [asset('images/best-buy/glam-black-sequin-dress.png')],
        'twinkle pink party dress' => [asset('images/best-buy/twinkle-pink-party-dress.png')],
        'party frock' => [asset('images/shop-by-style/party-frocks.png')],
        'festive wear' => [asset('images/shop-by-style/festive-wear.png')],
        'girls dress' => [asset('images/shop-by-style/girls-dresses.png')],
        'infant set' => [asset('images/shop-by-style/infant-sets.png')],
        'baby' => [asset('images/shop-by-style/infant-sets.png')],
        'child' => [asset('images/shop-by-style/2-4-years.png'), asset('images/shop-by-style/4-6-years.png')],
        'trinket' => [
            asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.27 AM.jpeg'),
            asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.29 AM.jpeg'),
        ],
        'saree' => $sareeSyncFallbacks,
        'earring' => [asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-FLA-C45/AVN-JW-HAN-FLA-C45-01.png')],
        'ring' => [asset('images/jewellery/Avnee_s Adjustable Radiant Bloom Statement Ring/AVN-JW-FRN-RRD-C70/AVN-JW-FRN-RRD-C70-01.png')],
        'pendant' => [asset('images/jewellery/Avnee_s Bird Design Pendant with Chain/AVN-JW-NEC-RGB-C86/AVN-JW-NEC-RGB-C86-01.png')],
        'necklace' => [asset('images/jewellery/Necklace/17850103560573191.webp')],
    ];

    $resolveProductImage = function (?string $rawPath) {
        $rawPath = trim((string) $rawPath);
        if ($rawPath === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $rawPath)) {
            return $rawPath;
        }

        $normalized = ltrim($rawPath, '/');

        if (str_starts_with($normalized, 'images/')) {
            $abs = public_path($normalized);
            return is_file($abs) ? asset($normalized) : null;
        }

        if (str_starts_with($normalized, 'storage/')) {
            $abs = public_path($normalized);
            return is_file($abs) ? asset($normalized) : null;
        }

        $storagePath = 'storage/' . $normalized;
        $absStorage = public_path($storagePath);
        if (is_file($absStorage)) {
            $segments = array_map('rawurlencode', explode('/', $storagePath));
            return asset(implode('/', $segments));
        }

        return null;
    };

    $resolveNameBasedImage = function (?string $productName, int $seed = 0) use ($nameFallbackRules) {
        $normalizedName = strtolower(trim((string) $productName));
        if ($normalizedName === '') {
            return null;
        }

        foreach ($nameFallbackRules as $needle => $candidates) {
            if (!str_contains($normalizedName, $needle) || empty($candidates)) {
                continue;
            }

            $index = abs($seed) % count($candidates);
            return $candidates[$index] ?? $candidates[0];
        }

        return null;
    };
@endphp

<div class="{{ $isDark ? 'bg-[#2B003A]' : 'bg-[#F8C8DC]' }}">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <nav class="mb-6 flex items-center gap-2 text-[10px] font-bold tracking-[0.24em] uppercase {{ $mutedColor }} overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route($isDark ? 'front.jewellery' : 'front.home') }}" class="hover:{{ $textColor }} transition-colors">Home</a>
            <span class="opacity-40">&gt;&gt;</span>
            @if($breadcrumbCategory)
                <a href="{{ route('front.products.index', ['category' => $breadcrumbCategory->slug]) }}" class="hover:{{ $textColor }} transition-colors {{ $textColor }}">{{ $breadcrumbCategory->name }}</a>
            @elseif(request('collection'))
                <span class="{{ $textColor }}">{{ $formatFilterLabel(request('collection')) }}</span>
            @else
                <span class="{{ $textColor }}">{{ $priceBandLabel ?: 'All Collections' }}</span>
            @endif
            @if($breadcrumbSubcategory)
                <span class="opacity-40">&gt;&gt;</span>
                <span class="{{ $textColor }}">{{ $breadcrumbSubcategory->name }}</span>
            @endif
        </nav>

        <!-- Premium Header Area -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-8">
            <h1 class="font-heading text-3xl sm:text-4xl font-normal tracking-tight {{ $textColor }} uppercase">
                {{ $headingText }}
            </h1>
            @php $curatedCount = ($products->isEmpty() && !empty($festiveGallery)) ? count($festiveGallery) : $products->total(); @endphp
            <p class="text-xs {{ $mutedColor }} font-bold uppercase tracking-widest">{{ $curatedCount }} Items</p>
        </div>

        <section class="hidden mb-8 border {{ $borderColor }} {{ $isDark ? 'bg-gradient-to-r from-[#2b003a] via-[#3d0a43] to-[#2b003a]' : 'bg-[#f4ecf0]' }} px-6 sm:px-8 py-5 sm:py-6 rounded-lg">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-lg sm:text-2xl {{ $isDark ? 'text-[#f3d9ff]' : 'text-[#4b2d3b]' }} font-semibold tracking-wide">Wedding Invite Edit</p>
                <p class="text-sm sm:text-lg {{ $isDark ? 'text-[#e9d5ff]' : 'text-[#6a4a5a]' }}">Shop any 2 showstopper guest ensembles @ ₹34,999/-</p>
            </div>
        </section>

        @if(request('collection') === 'sale' || request()->boolean('discount'))
            @php
                $saleCards = collect($saleVisuals['cards'] ?? [])->values();
                $saleBanner = $saleVisuals['banner'] ?? null;
                $saleCode = $saleVisuals['code'] ?? 'AVNEESALE10';
                $saleNote = $saleVisuals['note'] ?? 'No Return No Exchange';
            @endphp

            <section class="mb-10 border {{ $borderColor }} {{ $isDark ? 'bg-[#2f003f]' : 'bg-[#fff5f8]' }} overflow-hidden rounded-lg">
                <div class="px-4 sm:px-6 py-3 border-b {{ $borderColor }} flex items-center justify-between gap-3">
                    <div class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em]">
                        <span class="px-2.5 py-1 {{ $isDark ? 'bg-[#7a102f] text-white' : 'bg-[#7a102f] text-white' }}">Sale</span>
                        <span class="{{ $mutedColor }}">{{ $saleNote }}</span>
                    </div>
                    <button type="button" id="tnc-open-btn" class="shrink-0 px-3 py-1.5 border {{ $borderColor }} {{ $isDark ? 'bg-[#1f0028] text-[#f3d9ff] hover:bg-[#2b003a]' : 'bg-[#f8d6e2] text-[#6a304f] hover:bg-[#f3c3d4]' }} text-[11px] font-bold tracking-[0.18em] uppercase">
                        T&amp;C
                    </button>
                    <p class="text-[11px] sm:text-xs font-bold uppercase tracking-[0.18em] {{ $isDark ? 'text-[#f3d9ff]' : 'text-[#7f355d]' }}">AVNEE Sale - Kids Collection (Girls 0-12)</p>
                </div>

                <div class="px-4 sm:px-6 py-4 {{ $isDark ? 'bg-[#3a0a4d]' : 'bg-[#f8e4eb]' }} border-b {{ $borderColor }}">
                    <p class="text-center text-base sm:text-2xl font-semibold {{ $isDark ? 'text-[#ffe6f2]' : 'text-[#6a304f]' }} tracking-wide">
                        Shop ₹2,999 &amp; Get 10% Off <span class="mx-2 opacity-60">|</span> Use Code:
                        <span class="inline-block px-3 py-1 text-sm sm:text-xl rounded {{ $isDark ? 'bg-[#f3d9ff] text-[#2b003a]' : 'bg-[#cfa7b8] text-white' }} font-black tracking-[0.08em]">{{ $saleCode }}</span>
                    </p>
                </div>

                @if(!empty($saleBanner))
                    <div class="px-4 sm:px-6 pt-4">
                        <div class="overflow-hidden border {{ $borderColor }} rounded-lg">
                            <img src="{{ $saleBanner }}" alt="AVNEE Sale Highlights" class="w-full h-28 sm:h-44 object-cover" loading="lazy" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />
                        </div>
                    </div>
                @endif

                <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                    @foreach(range(0, 2) as $idx)
                        @php
                            $card = $saleCards[$idx] ?? null;
                        @endphp
                        <a href="{{ route('front.products.index', ['collection' => 'sale', 'discount' => 1]) }}" class="block group border {{ $borderColor }} {{ $isDark ? 'bg-[#2b003a]' : 'bg-white/85' }} overflow-hidden rounded-lg">
                            <div class="aspect-[4/3] overflow-hidden bg-black/5">
                                <img src="{{ $card['image'] ?? $listingFallbackImage }}" alt="{{ $card['kicker'] ?? 'Sale Offer' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />
                            </div>
                            <div class="px-4 py-3 text-center">
                                <p class="text-lg sm:text-2xl {{ $isDark ? 'text-[#f7d6e8]' : 'text-[#6a304f]' }}">{{ $card['kicker'] ?? 'Sale Offer' }}</p>
                                <p class="text-2xl sm:text-4xl font-black uppercase tracking-wide {{ $isDark ? 'text-[#f3d9ff]' : 'text-[#7a3a58]' }}">{{ $card['headline'] ?? 'Trending Offer' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 p-4 {{ $isDark ? 'bg-[#350047] border border-[#4f006a]' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
            <div class="flex flex-wrap items-center gap-2">
                @php
                    $quickSizes = collect($sizes ?? [])->take(3);
                @endphp
                @foreach($quickSizes as $quickSize)
                    <a href="{{ request()->fullUrlWithQuery(['size' => $quickSize]) }}" class="inline-flex items-center px-3 py-1.5 rounded-full border {{ request('size') == $quickSize ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff] bg-[#1f0028]' : 'border-[#7f355d] text-[#7f355d] bg-white') : ($isDark ? 'border-[#4f006a] text-[#e9d5ff]' : 'border-gray-400 text-gray-700 bg-white') }} text-xs font-semibold">
                        {{ $quickSize }}
                    </a>
                @endforeach
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="inline-flex items-center px-3 py-1.5 rounded-full border {{ $isDark ? 'border-[#4f006a] text-[#e9d5ff]' : 'border-gray-400 text-gray-700 bg-white' }} text-xs font-semibold">Delivery Days</a>
                <a href="{{ request()->fullUrlWithQuery(['collection' => 'new-arrivals']) }}" class="inline-flex items-center px-3 py-1.5 rounded-full border {{ $isDark ? 'border-[#4f006a] text-[#e9d5ff]' : 'border-gray-400 text-gray-700 bg-white' }} text-xs font-semibold">Occasion</a>
            </div>

            <form action="{{ route('front.products.index') }}" method="GET" class="flex items-center gap-3">
                @foreach(request()->except('sort', 'page') as $k => $v)
                    @if(is_array($v))
                        @foreach($v as $vv)
                            <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}" />
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                    @endif
                @endforeach
                <label class="text-xs {{ $mutedColor }} font-bold uppercase tracking-wide">SORT BY</label>
                <select name="sort" onchange="this.form.submit()" class="h-9 px-3 rounded-lg border {{ $borderColor }} {{ $isDark ? 'bg-[#1f0028] text-white' : 'bg-white text-gray-800' }} text-sm font-semibold">
                    <option value="trending" {{ request('sort', 'trending') == 'trending' ? 'selected' : '' }}>Trending</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </section>

        <div class="flex flex-col lg:flex-row gap-12 items-start">

                    <!-- Filter Sidebar -->
                    <div class="w-full lg:w-[320px] flex-shrink-0 lg:px-0 lg:pb-4">
                        <form action="{{ route('front.products.index') }}" method="GET" id="filter-form" class="space-y-5 p-5 {{ $isDark ? 'bg-[#350047] border border-[#4f006a]' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                            @if(request('collection'))
                                <input type="hidden" name="collection" value="{{ request('collection') }}">
                            @endif
                            @if(request('collection') === 'sale' || request()->boolean('discount'))
                                <input type="hidden" name="discount" value="1">
                            @endif
                            @if(request('collection') === 'bogo' || request()->boolean('bogo'))
                                <input type="hidden" name="bogo" value="1">
                            @endif

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider {{ $mutedColor }} mb-3">Select Gallery</label>
                                    @php
                                        $styleCategoryFilters = $isDark
                                            ? [
                                                ['name' => 'Earrings', 'slug' => 'earrings'],
                                                ['name' => 'Necklace', 'slug' => 'necklace'],
                                                ['name' => 'Rings', 'slug' => 'rings'],
                                                ['name' => 'Bangles', 'slug' => 'bangles-bracelet'],
                                                ['name' => 'Necklace Set', 'slug' => 'necklace-set'],
                                                ['name' => 'Belt', 'slug' => 'belt'],
                                                ['name' => 'Maangtikkas', 'slug' => 'maangtikkas'],
                                                ['name' => "Men's Accessories", 'slug' => 'mens-accessories'],
                                                ['name' => 'Anklet', 'slug' => 'anklet'],
                                                ['name' => 'Mathapati', 'slug' => 'mathapati'],
                                                ['name' => 'Watches', 'slug' => 'watches'],
                                                ['name' => 'Anti Tarnish', 'slug' => 'anti-tarnish'],
                                                ['name' => 'Korean', 'slug' => 'korean'],
                                                ['name' => 'Traditional', 'slug' => 'traditional'],
                                                ['name' => 'Kundan', 'slug' => 'kundan'],
                                                ['name' => 'Oxidised', 'slug' => 'oxidised'],
                                                ['name' => '18 K Gold Plated', 'slug' => '18k-gold-plated'],
                                                ['name' => 'Fashion', 'slug' => 'fashion'],
                                            ]
                                            : [
                                                ['name' => 'Infant Sets', 'slug' => 'infant-sets'],
                                                ['name' => 'KIDS COLLECTIONS AGED 2 - 4 Yrs', 'slug' => '2-4-years'],
                                                ['name' => 'KIDS COLLECTIONS AGED 4 - 6 Yrs', 'slug' => '4-6-years'],
                                                ['name' => 'KIDS COLLECTIONS AGED 6 - 14 Yrs', 'slug' => '6-14-years'],
                                                ['name' => 'Festive Wear', 'slug' => 'festive-wear'],
                                                ['name' => 'Girls Daily-wear', 'slug' => 'girls-dresses'],
                                                ['name' => 'Party Frocks', 'slug' => 'party-frocks'],
                                            ];

                                        $categoryCountMap = [];
                                        foreach ($categories as $categoryNode) {
                                            $categoryCountMap[$categoryNode->slug] = $categoryNode->products_count;
                                            foreach ($categoryNode->children as $childNode) {
                                                $categoryCountMap[$childNode->slug] = $childNode->products_count;
                                            }
                                        }
                                    @endphp

                                    <div class="max-h-[320px] overflow-y-auto space-y-1.5 pr-1">
                                        <label class="block cursor-pointer">
                                            <input type="radio" name="category" value="" onchange="this.form.submit()" {{ !request('category') ? 'checked' : '' }} class="sr-only" />
                                            <span class="flex items-center justify-between px-3 py-2 rounded-md border {{ !request('category') ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff] bg-[#1f0028]' : 'border-[#b87333] text-[#b87333] bg-white') : $borderColor }} text-sm font-medium">
                                                <span>{{ $priceBandLabel ?: 'All Collections' }}</span>
                                                <span class="text-xs opacity-70">{{ App\Models\Product::where('brand_id', session('brand_id', 1))->count() }}</span>
                                            </span>
                                        </label>

                                        @foreach($styleCategoryFilters as $styleFilter)
                                        <label class="block cursor-pointer">
                                            <input type="radio" name="category" value="{{ $styleFilter['slug'] }}" onchange="this.form.submit()" {{ request('category') == $styleFilter['slug'] ? 'checked' : '' }} class="sr-only" />
                                            <span class="flex items-center justify-between px-3 py-2 rounded-lg border {{ request('category') == $styleFilter['slug'] ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff] bg-[#1f0028]' : 'border-[#b87333] text-[#b87333] bg-white') : $borderColor }} text-sm font-medium">
                                                <span>{{ $styleFilter['name'] }}</span>
                                                <span class="text-xs opacity-70">{{ $styleCategoryCounts[$styleFilter['slug']] ?? ($categoryCountMap[$styleFilter['slug']] ?? 0) }}</span>
                                            </span>
                                        </label>
                                        @endforeach

                                        @if(!$isDark)
                                        @foreach($categories as $cat)
                                        @if(strtolower($cat->name) === 'all collections') @continue @endif
                                            <label class="block cursor-pointer">
                                                <input type="radio" name="category" value="{{ $cat->slug }}" onchange="this.form.submit()" {{ request('category') == $cat->slug ? 'checked' : '' }} class="sr-only" />
                                                <span class="flex items-center justify-between px-3 py-2 rounded-lg border {{ request('category') == $cat->slug ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff] bg-[#1f0028]' : 'border-[#b87333] text-[#b87333] bg-white') : $borderColor }} text-sm font-medium">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="text-xs opacity-70">{{ $cat->products_count }}</span>
                                                </span>
                                            </label>

                                            @if($cat->children->count() > 0)
                                                <div class="ml-3 space-y-1">
                                                    @foreach($cat->children as $sub)
                                                        <label class="block cursor-pointer">
                                                            <input type="radio" name="category" value="{{ $sub->slug }}" onchange="this.form.submit()" {{ request('category') == $sub->slug ? 'checked' : '' }} class="sr-only" />
                                                            <span class="flex items-center justify-between px-3 py-1.5 rounded-lg border {{ request('category') == $sub->slug ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff]' : 'border-[#b87333] text-[#b87333]') : $borderColor }} text-xs font-medium">
                                                                <span>{{ $sub->name }}</span>
                                                                <span class="opacity-70">{{ $sub->products_count }}</span>
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                @if(isset($sizes) && $sizes->count() > 0)
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider {{ $mutedColor }} mb-3">Available Sizes</label>
                                    <div class="flex flex-wrap gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="size" value="" onchange="this.form.submit()" {{ !request('size') ? 'checked' : '' }} class="sr-only" />
                                            <span class="inline-flex px-3 py-1.5 rounded-lg border text-xs font-semibold {{ !request('size') ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff]' : 'border-[#b87333] text-[#b87333]') : $borderColor }}">All</span>
                                        </label>
                                        @foreach($sizes as $size)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="size" value="{{ $size }}" onchange="this.form.submit()" {{ request('size') == $size ? 'checked' : '' }} class="sr-only" />
                                            <span class="inline-flex px-3 py-1.5 rounded-lg border text-xs font-semibold {{ request('size') == $size ? ($isDark ? 'border-[#d4af37] text-[#f3d9ff]' : 'border-[#b87333] text-[#b87333]') : $borderColor }}">{{ $size }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider {{ $mutedColor }} mb-3">Price Range</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full text-sm border {{ $borderColor }} rounded-lg px-3 py-2 {{ $isDark ? 'bg-[#1f0028] text-white' : 'bg-white text-gray-900' }}" />
                                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full text-sm border {{ $borderColor }} rounded-lg px-3 py-2 {{ $isDark ? 'bg-[#1f0028] text-white' : 'bg-white text-gray-900' }}" />
                                    </div>
                                    <button type="submit" class="mt-3 w-full py-2.5 bg-black text-white text-xs font-bold uppercase tracking-[0.2em] hover:{{ $accentBg }} transition-all rounded-lg">Apply Filters</button>
                                </div>

                                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'size', 'sort']))
                                <a href="{{ route('front.products.index') }}" class="flex items-center justify-center gap-2 text-xs font-semibold {{ $mutedColor }} hover:{{ $textColor }} transition-colors pt-1">
                                    <span class="material-symbols-outlined text-sm">refresh</span> Reset Filters
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

            <!-- Cinematic Product Grid -->
            <div class="flex-1 min-w-0">
                @if($products->isEmpty() && !empty($festiveGallery))
                    <div class="mb-10 text-center">
                        <p class="text-sm {{ $mutedColor }} italic">Showing festive gallery images for this collection.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
                        @foreach($festiveGallery as $index => $festiveImage)
                            <div class="group relative flex flex-col">
                                @php
                                    $festiveSrc = (string) ($festiveImage['url'] ?? '');
                                    if ($festiveSrc !== '' && !preg_match('/^https?:\/\//i', $festiveSrc) && str_starts_with($festiveSrc, '/')) {
                                        $festiveSrc = asset(ltrim($festiveSrc, '/'));
                                    }
                                    if ($festiveSrc === '') {
                                        $festiveSrc = $listingFallbackImage;
                                    }
                                @endphp
                                @if(!empty($festiveImage['detail_url']))
                                    <a href="{{ $festiveImage['detail_url'] }}" class="relative block overflow-hidden {{ $cardBg }} aspect-[3/4] border {{ $borderColor }} rounded-lg">
                                        <img src="{{ $festiveSrc }}" alt="{{ $festiveImage['title'] ?? ('Festive Wear ' . ($index + 1)) }}" loading="lazy" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />
                                    </a>
                                @else
                                    <div class="relative block overflow-hidden {{ $cardBg }} aspect-[3/4] border {{ $borderColor }} rounded-lg">
                                        <img src="{{ $festiveSrc }}" alt="Festive Wear {{ $index + 1 }}" loading="lazy" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />
                                    </div>
                                @endif
                                <div class="pt-4">
                                    @if(!empty($festiveImage['title']))
                                        <h3 class="text-sm font-semibold {{ $textColor }} leading-snug tracking-wide uppercase mb-1">{{ $festiveImage['title'] }}</h3>
                                    @endif
                                    <p class="text-xs {{ $mutedColor }} leading-relaxed">Sample description - curated festive style for little celebrations.</p>
                                    <p class="text-sm font-bold {{ $textColor }} mt-1">₹699</p>
                                    <span class="text-[10px] font-black uppercase tracking-[0.25em] {{ $mutedColor }} opacity-70">{{ $festiveImage['group'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($products->isEmpty())
                    @php
                        $requestedCategory = request('category');
                        $requestedMinPrice = is_numeric(request('min_price')) ? (float) request('min_price') : null;
                        $requestedMaxPrice = is_numeric(request('max_price')) ? (float) request('max_price') : null;

                        if (!empty($sampleGallery)) {
                            $sampleCards = collect($sampleGallery)->take(10)->values()->map(function ($item, $idx) {
                                $title = trim((string) ($item['title'] ?? ''));
                                return [
                                    'title' => $title !== '' ? $title : (($item['source_label'] ?? 'Curated Style') . ' ' . ($idx + 1)),
                                    'price' => 699 + (($idx + 1) * 120),
                                    'image' => (string) ($item['main_url'] ?? ''),
                                    'label' => (string) ($item['source_label'] ?? 'Sample Preview'),
                                ];
                            });
                        } else {
                            $fallbackPool = [];
                            if (!empty($requestedCategory) && isset($categoryFallbacks[$requestedCategory])) {
                                $fallbackPool = $categoryFallbacks[$requestedCategory];
                            }
                            if (empty($fallbackPool) && !empty($requestedCategory)) {
                                $byName = $resolveNameBasedImage(str_replace('-', ' ', (string) $requestedCategory), 1);
                                if ($byName) {
                                    $fallbackPool = [$byName];
                                }
                            }
                            if (empty($fallbackPool)) {
                                $fallbackPool = [$listingFallbackImage];
                            }

                            $sampleKeyword = trim(str_replace('-', ' ', (string) ($requestedCategory ?: ($isDark ? 'jewellery accessory' : 'fashion product'))));
                            $sampleCards = collect(range(1, 10))->map(function ($idx) use ($fallbackPool, $requestedCategory, $sampleKeyword, $onlineImage) {
                                $image = $fallbackPool[$idx - 1] ?? $onlineImage($sampleKeyword . ' product', 3000 + $idx);
                                return [
                                    'title' => ucfirst(str_replace('-', ' ', $requestedCategory ?: 'Curated Style')) . ' Sample ' . $idx,
                                    'price' => 699 + ($idx * 120),
                                    'image' => $image,
                                    'label' => 'Sample Preview',
                                ];
                            });
                        }

                        // Keep fallback sample mode consistent with active price filters.
                        $sampleCards = $sampleCards->filter(function ($sample) use ($requestedMinPrice, $requestedMaxPrice) {
                            $price = (float) ($sample['price'] ?? 0);
                            if ($requestedMinPrice !== null && $price < $requestedMinPrice) {
                                return false;
                            }
                            if ($requestedMaxPrice !== null && $price > $requestedMaxPrice) {
                                return false;
                            }
                            return true;
                        })->values();
                    @endphp

                    <div class="mb-8">
                        <p class="text-sm {{ $mutedColor }} italic">Showing curated sample previews while we sync this section.</p>
                    </div>

                    @if($sampleCards->isEmpty())
                        <div class="py-10 text-center border {{ $borderColor }} {{ $cardBg }} rounded-lg">
                            <p class="text-sm {{ $mutedColor }}">No products match the selected price range.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
                            @foreach($sampleCards as $index => $sample)
                                @php
                                    $sampleSlug = 'bogo-sample-' . ($index + 1);
                                    $categorySlug = request('category', 'bogo');
                                    $detailUrl = route('front.gallery.collection.detail', ['category' => $categorySlug, 'product' => $sampleSlug]);
                                @endphp
                                <div class="group relative flex flex-col cursor-pointer" onclick="window.location.href='{{ $detailUrl }}'">
                                    <a href="{{ $detailUrl }}" class="relative block overflow-hidden {{ $cardBg }} aspect-[3/4] border {{ $borderColor }} rounded-lg group-hover:shadow-lg transition-shadow">
                                        <img src="{{ $sample['image'] }}" alt="{{ $sample['title'] }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />

                                        {{-- Quick View Badge --}}
                                        <div class="absolute top-2 left-2 {{ $isDark ? 'bg-purple-600' : 'bg-orange-600' }} text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                            Quick View
                                        </div>
                                    </a>
                                    <div class="pt-4">
                                        <a href="{{ $detailUrl }}" class="block group/link">
                                            <h3 class="text-sm font-semibold {{ $textColor }} leading-snug tracking-wide line-clamp-2 uppercase group-hover/link:{{ $accentColor }} transition-colors">{{ $sample['title'] }}</h3>
                                        </a>
                                        <p class="text-sm font-bold {{ $textColor }} mt-1">₹{{ number_format($sample['price'], 0) }}</p>
                                        <span class="text-[10px] font-black uppercase tracking-[0.25em] {{ $mutedColor }} opacity-70">{{ $sample['label'] ?? 'Sample Preview' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
                        @foreach($products as $product)
                        @php
                            $productImageSrc = $resolveNameBasedImage($product->name, (int) $product->id);

                            $candidateSources = [
                                $product->image,
                                optional($product->images->first())->path,
                            ];

                            if (!$productImageSrc) {
                                foreach ($candidateSources as $candidate) {
                                    $resolved = $resolveProductImage($candidate);
                                    if ($resolved) {
                                        $productImageSrc = $resolved;
                                        break;
                                    }
                                }
                            }

                            if (!$productImageSrc) {
                                $categorySlug = $product->category->slug ?? null;
                                $fallbackList = $categoryFallbacks[$categorySlug] ?? [$listingFallbackImage];
                                $fallbackCount = count($fallbackList);
                                if ($fallbackCount > 1) {
                                    $fallbackIndex = ((int) $product->id) % $fallbackCount;
                                    $productImageSrc = $fallbackList[$fallbackIndex] ?? $listingFallbackImage;
                                } else {
                                    $keyword = trim(str_replace('-', ' ', (string) ($categorySlug ?: 'fashion product')));
                                    $productImageSrc = $onlineImage($keyword . ' product', 4000 + (int) $product->id);
                                }
                            }
                        @endphp
                        <div class="group relative flex flex-col">
                            <a href="{{ route('front.product.detail', $product->slug ?? $product->id) }}" class="relative block overflow-hidden bg-black aspect-[3/4] rounded-lg" onclick="window.location.href='{{ route('front.product.detail', $product->slug ?? $product->id) }}'; return false;">
                                <img src="{{ $productImageSrc }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition-transform duration-[2.5s] ease-out group-hover:scale-110 opacity-90 group-hover:opacity-100" onerror="this.onerror=null;this.src='{{ $listingFallbackImage }}';" />

                                {{-- Smart Badge Placement --}}
                                @if($product->compare_price > $product->price)
                                <div class="absolute bottom-0 right-0 {{ $isDark ? 'bg-white text-black' : 'bg-black text-white' }} px-4 py-2 text-[10px] font-black tracking-[0.2em] transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 uppercase">
                                     Save {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                </div>
                                @endif

                                {{-- Visual Soft Hover Overlay --}}
                                <div class="absolute inset-0 bg-{{ $isDark ? 'purple-900' : 'orange-900' }}/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
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

                            <div class="pt-6 relative">
                                <span class="text-[9px] font-black uppercase tracking-[0.3em] {{ $mutedColor }} mb-2 block opacity-60">
                                    {{ $product->category?->name ?? 'Collection' }}
                                </span>
                                <a href="{{ route('front.product.detail', $product->slug ?? $product->id) }}" class="block group/link" onclick="window.location.href='{{ route('front.product.detail', $product->slug ?? $product->id) }}'; return false;">
                                    <h3 class="text-sm font-semibold {{ $textColor }} leading-snug tracking-wide line-clamp-2 min-h-[2.5rem] group-hover/link:{{ $accentColor }} transition-colors uppercase">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <div class="flex items-baseline gap-3 mt-4">
                                    <span class="text-base font-bold {{ $textColor }} tracking-tighter">₹{{ number_format($product->price, 0) }}</span>
                                    @if($product->compare_price > $product->price)
                                    <span class="text-xs {{ $mutedColor }} line-through opacity-50 tracking-tighter font-medium">₹{{ number_format($product->compare_price, 0) }}</span>
                                    @endif
                                </div>

                                {{-- Designer Interactive Dot --}}
                                <div class="absolute top-6 right-0 w-1.5 h-1.5 rounded-full {{ $accentBg }} opacity-0 group-hover:opacity-100 transition-opacity animate-pulse shadow-[0_0_8px_currentColor]"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Custom Pagination Minimalist -->
                    <div class="mt-20 flex justify-center border-t {{ $borderColor }} pt-12">
                        {{ $products->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    /* Premium Hover Styles */
    .glass-card {
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-card:hover {
        box-shadow: 0 20px 60px -15px rgba(0,0,0,0.2);
        transform: translateY(-2px);
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
</style>

<script>
    (function () {
        const rail = document.getElementById('collection-story-rail');
        const track = document.getElementById('collection-story-track');
        if (!rail || !track || window.innerWidth >= 768) return;

        const items = track.children;
        if (items.length <= 1) return;

        let current = 0;
        const step = () => {
            current = (current + 1) % items.length;
            rail.scrollTo({ left: current * rail.clientWidth, behavior: 'smooth' });
        };

        track.style.display = 'flex';
        track.style.width = `${items.length * 100}%`;
        Array.from(items).forEach((el) => {
            el.style.minWidth = `${100 / items.length}%`;
        });

        setInterval(step, 4200);
    })();
</script>

@if(request('collection') === 'sale' || request()->boolean('discount'))
    <div id="tnc-modal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-black/50">
        <div class="w-full max-w-3xl bg-white border border-gray-200 shadow-2xl">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                <p class="text-sm font-semibold tracking-wide">T&amp;C</p>
                <button type="button" id="tnc-close-btn" class="w-8 h-8 inline-flex items-center justify-center border border-gray-300 text-gray-700 hover:bg-gray-50" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="p-5">
                <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
                    <li>Applicable on both Sale &amp; Non-Sale Products.</li>
                    <li>Max discount: ₹1,000.</li>
                    <li>Valid on Selected Categories.</li>
                    <li>Only on website and app.</li>
                    <li>Limited period offer.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var openBtn = document.getElementById('tnc-open-btn');
            var modal = document.getElementById('tnc-modal');
            var closeBtn = document.getElementById('tnc-close-btn');
            if (!openBtn || !modal || !closeBtn) return;

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();
    </script>
@endif
@endsection
