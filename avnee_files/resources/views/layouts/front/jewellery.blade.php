<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @stack('schema')
  <title>@yield('title', $settings['site_name'] ?? 'AVNEE Collections') - {{ $settings['default_meta_title'] ?? 'Exquisite Handcrafted Indian Jewellery' }}</title>
  <meta name="description" content="@yield('meta_description', $settings['default_meta_description'] ?? 'AVNEE Collections – Premium handcrafted Indian jewellery. Kundan, Meenakari, Jhumkas & Bridal sets. Free shipping above ₹1499.')" />

  {!! $settings['custom_pixels'] ?? '' !!}

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Google Fonts: Atelier Theme -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Noto+Serif:ital,wght@0,400;0,700;1,400&family=Manrope:wght@300;400;500;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

  <style>
    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Custom scrollbar for search */
    .search-input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(184, 115, 51, 0.28);
    }

    /* Badge pulse animation */
    @keyframes badge-pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.15);
      }
    }

    .badge-animate {
      animation: badge-pulse 2s ease-in-out infinite;
    }

    /* Hover underline effect */
    .hover-underline {
      position: relative;
    }

    .hover-underline::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 1px;
      background-color: #f3d9ff;
      transition: width 0.3s ease;
    }

    .hover-underline:hover::after {
      width: 100%;
    }

    /* Top bar slide-in animation */
    @keyframes slideDown {
      from {
        transform: translateY(-100%);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .slide-down {
      animation: slideDown 0.5s ease-out forwards;
    }

    /* Icon hover effect */
    .icon-btn {
      transition: all 0.25s ease;
    }

    .icon-btn:hover {
      transform: translateY(-2px);
      color: #f3d9ff;
    }

    /* Nav bar link hover */
    .nav-link {
      position: relative;
      transition: color 0.2s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 1.5px;
      background-color: #f3d9ff;
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-item-link {
      color: #FADADD;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      padding: 8px 10px;
      transition: all 0.2s ease;
    }

    .nav-item-link:hover {
      background-color: #FADADD;
      color: #2B003A;
    }

    .mega-menu-panel {
      min-width: 1040px;
      background: #fff5f9;
    }

    .mega-tab {
      display: block;
      padding: 10px 14px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: #5d2d47;
      border-bottom: 1px solid rgba(119, 7, 55, 0.08);
      transition: all 0.2s ease;
    }

    .mega-tab.is-active {
      background: #f4d8e5;
      color: #770737;
    }

    .mega-panel {
      display: none;
    }

    .mega-panel.is-active {
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      gap: 10px;
    }

    .mega-card {
      display: block;
      background: #fff;
      border: 1px solid rgba(119, 7, 55, 0.12);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mega-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(119, 7, 55, 0.18);
    }

    .mega-card img {
      width: 100%;
      height: 170px;
      object-fit: cover;
    }

    .mega-card span {
      display: block;
      padding: 8px 6px 10px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.02em;
      text-align: center;
      color: #4a2439;
    }

    .brand-wordmark {
      display: inline-flex;
      flex-direction: column;
      align-items: center;
      line-height: 1;
    }

    .brand-wordmark-main {
      font-family: "Cinzel", "Noto Serif", serif;
      font-weight: 700;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      font-size: clamp(1.15rem, 2.3vw, 2.35rem);
      color: #f8c8dc;
    }

    .brand-wordmark-sub {
      margin-top: 0.22rem;
      font-family: "Manrope", sans-serif;
      font-weight: 700;
      letter-spacing: 0.52em;
      text-transform: uppercase;
      font-size: clamp(0.56rem, 1.02vw, 0.8rem);
      color: #c79cff;
      opacity: 0.95;
      padding-left: 0.2em;
      white-space: nowrap;
    }

    .brand-wordmark-mobile .brand-wordmark-main {
      color: #f8c8dc;
      font-size: 1.9rem;
      letter-spacing: 0.28em;
    }

    .brand-wordmark-mobile .brand-wordmark-sub {
      color: #c79cff;
      font-size: 0.72rem;
      letter-spacing: 0.5em;
      padding-left: 0.22em;
      margin-top: 0.15rem;
    }

    /* Hide scrollbar */
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .nav-link.sale-link {
      color: #e9c349;
    }

    .nav-link.sale-link:hover {
      color: #f5da80;
    }

    /* Hero Slider */
    .hero-swiper {
      width: 100%;
    }

    .hero-swiper .swiper-slide {
      position: relative;
      overflow: hidden;
    }

    .hero-swiper .swiper-slide img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      object-position: center center;
      transition: transform 6s ease;
    }

    .hero-swiper .swiper-slide-active img {
      transform: scale(1.03);
    }

    /* Price Badge Scallop — fixed box; scoped + !important beats Tailwind / stale CDN cache */
    #shop-by-price-static .price-badge-wrap,
    #shop-by-price .price-badge-wrap,
    .price-badge-wrap {
      cursor: pointer;
      transition: transform 0.3s ease, filter 0.3s ease;
      box-sizing: border-box !important;
      flex: 0 0 auto !important;
      aspect-ratio: 1;
      width: 9rem !important;
      height: 9rem !important;
      min-width: 9rem !important;
      min-height: 9rem !important;
      max-width: 9rem !important;
      max-height: 9rem !important;
    }

    @media (min-width: 640px) {
      #shop-by-price-static .price-badge-wrap,
      #shop-by-price .price-badge-wrap,
      .price-badge-wrap {
        width: 11rem !important;
        height: 11rem !important;
        min-width: 11rem !important;
        min-height: 11rem !important;
        max-width: 11rem !important;
        max-height: 11rem !important;
      }
    }

    @media (min-width: 1024px) {
      #shop-by-price-static .price-badge-wrap,
      #shop-by-price .price-badge-wrap,
      .price-badge-wrap {
        width: 13rem !important;
        height: 13rem !important;
        min-width: 13rem !important;
        min-height: 13rem !important;
        max-width: 13rem !important;
        max-height: 13rem !important;
      }
    }

    #shop-by-price-static .price-badge-wrap .badge-svg,
    #shop-by-price .price-badge-wrap .badge-svg,
    .price-badge-wrap .badge-svg {
      display: block;
      width: 100% !important;
      height: 100% !important;
      min-width: 100% !important;
      min-height: 100% !important;
      flex-shrink: 0 !important;
    }

    .price-badge-wrap:hover {
      transform: scale(1.06) rotate(3deg);
      filter: brightness(1.12);
    }

    /* Custom Swiper Arrows */
    .hero-swiper .swiper-button-prev,
    .hero-swiper .swiper-button-next {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 50%;
      color: #222;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
      transition: all 0.2s ease;
    }

    .hero-swiper .swiper-button-prev:hover,
    .hero-swiper .swiper-button-next:hover {
      background: #fff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    }

    .hero-swiper .swiper-button-prev::after,
    .hero-swiper .swiper-button-next::after {
      font-size: 14px;
      font-weight: 700;
    }

    /* Swiper Pagination */
    .hero-swiper .swiper-pagination-bullet {
      width: 10px;
      height: 10px;
      background: rgba(255, 255, 255, 0.6);
      opacity: 1;
      transition: all 0.3s ease;
    }

    .hero-swiper .swiper-pagination-bullet-active {
      background: #f3d9ff;
      width: 28px;
      border-radius: 5px;
    }

    .trending-now-swiper .swiper-pagination-bullet,
    .flash-swiper .swiper-pagination-bullet,
    .combo-swiper .swiper-pagination-bullet,
    .style-swiper .swiper-pagination-bullet,
    .best-buys-swiper .swiper-pagination-bullet,
    #shop-look-swiper .swiper-pagination-bullet,
    .top-col-swiper .swiper-pagination-bullet,
    .bestsell-swiper .swiper-pagination-bullet,
    .brand-experience-swiper .swiper-pagination-bullet,
    .just-in-swiper .swiper-pagination-bullet,
    .style-static-swiper .swiper-pagination-bullet {
      width: 10px;
      height: 10px;
    }

    /* Slide text animation */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(24px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .swiper-slide-active .slide-title {
      animation: fadeUp 0.7s ease 0.3s both;
    }

    .swiper-slide-active .slide-subtitle {
      animation: fadeUp 0.7s ease 0.5s both;
    }

    .swiper-slide-active .slide-btn {
      animation: fadeUp 0.7s ease 0.7s both;
    }

    /* Live Chat buttons */
    .live-btn {
      transition: all 0.2s ease;
    }

    .live-btn:hover {
      transform: translateX(-4px);
      background: #1a1a1a;
    }

    /* Shop The Look – Coverflow */
    .look-swiper {
      padding: 30px 0 40px !important;
    }

    .look-swiper .swiper-slide {
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.5s ease, opacity 0.5s ease;
      opacity: 0.6;
      transform: scale(0.8);
      z-index: 1;
    }

    .look-swiper .swiper-slide-active {
      opacity: 1;
      transform: scale(1.12);
      z-index: 10;
    }

    .look-swiper .swiper-slide-prev,
    .look-swiper .swiper-slide-next {
      opacity: 0.85;
      transform: scale(0.9);
      z-index: 5;
    }

    /* Shop Now hover overlay */
    .look-overlay {
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .swiper-slide-active:hover .look-overlay {
      opacity: 1;
    }

    /* View bar */
    .look-view-bar {
      transition: transform 0.35s ease;
      transform: translateY(100%);
    }

    .swiper-slide-active .look-view-bar {
      transform: translateY(0);
    }

    /* Look Arrows */
    .look-arrow {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: rgba(30,20,40,0.85);
      border: 1px solid #4f006a;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 12px rgba(0,0,0,0.4);
      transition: all 0.2s ease;
      color: #f3d9ff;
    }

    .look-arrow:hover {
      background: #2d292e;
      box-shadow: 0 4px 20px rgba(0,0,0,0.5);
      color: #f3d9ff;
    }

    /* Top JEWELLERY Cards */
    .top-col-card {
      overflow: hidden;
      position: relative;
    }

    .top-col-card img {
      transition: transform 0.6s ease;
    }

    .top-col-card:hover img {
      transform: scale(1.05);
    }

    .top-col-overlay {
      background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
    }

    .top-col-btn {
      transition: all 0.3s ease;
    }

    .top-col-card:hover .top-col-btn {
      background-color: #d4af37;
      color: #fff;
      border-color: #d4af37;
    }

    /* Bestselling Styles Arrows (Square) */
    .bestsell-arrow {
      width: 44px;
      height: 44px;
      background: #350047;
      border: 1px solid #4f006a;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      transition: all 0.2s ease;
      color: #e9d5ff;
    }

    .bestsell-arrow:hover {
      background: #2d292e;
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
      color: #f3d9ff;
    }

    /* Stories Swiper */
    .stories-swiper {
      padding-bottom: 40px !important;
    }

    .story-card {
      background: #350047;
      border: 1px solid #4f006a;
      border-radius: 6px;
    }

    .stories-swiper .swiper-pagination-bullet {
      background: #4f006a;
      opacity: 1;
      width: 8px;
      height: 8px;
      margin: 0 5px !important;
    }

    .stories-swiper .swiper-pagination-bullet-active {
      background: #f3d9ff;
    }

    /* Simple black ghost arrows */
    .story-arrow {
      color: #aaa;
      transition: color 0.2s ease;
    }

    .story-arrow:hover {
      color: #222;
    }
    /* Footer section heading underline */
    .footer-heading {
      position: relative;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }
    .footer-heading::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 28px;
      height: 1.5px;
      background: linear-gradient(to right, #d4af37, transparent);
    }

    /* Footer newsletter box */
    .footer-newsletter { border: 1px solid #4f006a; padding: 24px; background: #13101f; }

    /* Search Results Styles */
    .search-result-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid #2e2630;
        transition: background-color 0.2s;
    }
    .search-result-item:hover {
        background-color: #1a151b;
    }
    .search-result-item:last-child {
        border-bottom: none;
    }
    .search-result-image {
        width: 48px;
        height: 60px;
        object-fit: cover;
        border-radius: 2px;
        margin-right: 1rem;
    }
    .search-result-info {
        flex: 1;
    }
    .search-result-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #fdf2f8;
        margin-bottom: 0.25rem;
    }
    .search-result-price {
        font-size: 0.8125rem;
        color: #f3d9ff;
        font-weight: 600;
    }
    .search-result-old-price {
        font-size: 0.75rem;
        color: #c0a0c0;
        text-decoration: line-through;
        margin-left: 0.5rem;
    }
    .no-results {
        padding: 1rem;
        text-align: center;
        color: #c0a0c0;
        font-size: 0.875rem;
    }
  </style>
  @stack('styles')
</head>

  <body class="font-body text-[#A47DAB] bg-[#300E54]">

  <!-- ═══════════════════════════════════════════════ -->
  <!-- TOP ANNOUNCEMENT BAR                           -->
  <!-- ═══════════════════════════════════════════════ -->
  <div id="top-bar" class="bg-top-bar slide-down">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-9 text-xs sm:text-sm">

        <!-- Left: Brand Links -->
        <div class="hidden sm:flex items-center gap-3">
          <a href="{{ route('front.home') }}" id="brand-studio"
            class="text-[#f3d9ff] font-medium hover-underline text-[10px] sm:text-xs transition-colors duration-200">
            STUDIO
          </a>
          <a href="{{ route('front.jewellery') }}" id="brand-jewellery"
            class="bg-[#f3d9ff] text-[#1a0a3a] text-[10px] sm:text-xs font-semibold tracking-wider px-3 py-1 rounded-sm transition-colors duration-200">
            JEWELLERY
          </a>
        </div>

        <!-- Center: Free Shipping Message -->
        <p
          class="text-center flex-1 sm:flex-none font-medium tracking-widest text-top-bar-text text-[11px] sm:text-xs uppercase">
          ✦ &nbsp;FREE SHIPPING ON ORDERS ABOVE ₹1499&nbsp; ✦
        </p>

        <!-- Right: Utility Links -->
        <div class="hidden md:flex items-center gap-5 text-xs">
          <a href="{{ route('front.blog.index') }}" id="link-blog" class="hover-underline font-medium text-top-bar-text transition-colors duration-200">BLOG</a>
          <a href="{{ route('front.track_order', ['theme' => 'jewellery']) }}" id="link-track-order" class="hover-underline font-medium text-top-bar-text transition-colors duration-200 uppercase tracking-widest">Track Order</a>
        </div>

      </div>
    </div>
  </div>

  <!-- Mobile Brand Switcher -->
  <div class="sm:hidden bg-top-bar border-y border-[#f3d9ff]/25">
    <div class="max-w-[1440px] mx-auto px-4 py-2 flex items-center justify-start gap-2">
      <a href="{{ route('front.home') }}"
        class="text-[#f3d9ff] text-[10px] font-semibold tracking-[0.16em] uppercase px-3 py-1 rounded-sm border border-[#f3d9ff]/45 hover:border-[#f3d9ff] transition-colors">
        Studio
      </a>
      <a href="{{ route('front.jewellery') }}"
        class="bg-[#f3d9ff] text-[#1a0a3a] text-[10px] font-semibold tracking-[0.16em] uppercase px-3 py-1 rounded-sm border border-[#f3d9ff]">
        Jewellery
      </a>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- MAIN HEADER                                    -->
  <!-- ═══════════════════════════════════════════════ -->
  <header id="main-header" class="bg-[#300E54] backdrop-blur-md border-b border-[#A47DAB]/25 transition-all duration-300">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-[auto_1fr_auto] lg:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] items-center h-16 sm:h-24 gap-2 sm:gap-4">

        <!-- Left: Mobile Menu -->
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
          <!-- Mobile: Hamburger Menu -->
          <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 text-[#f8c8dc] hover:text-[#d4af37] transition-colors" aria-label="Open menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <!-- Search Bar (Desktop, left aligned) -->
          <div class="hidden lg:flex lg:-ml-10 xl:-ml-14 w-[360px] xl:w-[460px] max-w-full">
            <div class="relative w-full" id="search-container">
              <input id="search-input" type="text" placeholder="Search for Earrings, Necklace, Rings, Anklets..."
                class="search-input w-full h-10 pl-4 pr-11 text-sm bg-white/10 border border-[#F8C8DC]/30 placeholder:text-[#F8C8DC]/70 text-[#F8C8DC] transition-all duration-200 focus:ring-1 focus:ring-[#F8C8DC]/50 shadow-inner" autocomplete="off" />
              <button id="search-btn"
                class="absolute right-0 top-0 h-10 w-11 flex items-center justify-center bg-[#F8C8DC] hover:bg-white text-[#770737] transition-colors duration-200"
                aria-label="Search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </button>
              <div id="search-results" class="absolute left-0 w-[320px] top-full mt-1 bg-[#F8C8DC] border border-[#770737]/20 shadow-2xl z-50 hidden max-h-[400px] overflow-y-auto rounded-sm">
                  <!-- Results injected here -->
              </div>
            </div>
          </div>
        </div>

        <!-- Center: Logo -->
        <div class="flex justify-center min-w-0 px-1">
          <a href="{{ route('front.jewellery') }}" id="logo" class="flex flex-col items-center shrink-0 group max-[390px]:scale-90">
            <span class="brand-wordmark">
              <span class="brand-wordmark-main">AVNEE</span>
              <span class="brand-wordmark-sub">Collections</span>
            </span>
          </a>
        </div>

        <!-- Right: Action Icons -->
        <div class="flex items-center justify-end flex-nowrap gap-1.5 sm:gap-3 lg:gap-4 font-semibold text-[#fdf2f8] min-w-0">
          <!-- Mobile Search Toggle -->
          <button id="mobile-search-btn" class="md:hidden hover:text-[#d4af37] p-2 transition-colors" aria-label="Search">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>

          <!-- WhatsApp -->
          <a href="#" id="icon-whatsapp" class="hover:text-[#d4af37] p-1 sm:p-2 transition-all max-[390px]:hidden" aria-label="WhatsApp" title="WhatsApp">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </a>

          <!-- Account -->
          <div class="relative" id="account-menu-root">
            @auth
            <button type="button" id="icon-account" class="hover:text-[#d4af37] p-1 sm:p-2 transition-all" aria-label="My Account" title="My Account" aria-expanded="false" aria-controls="account-menu-panel">
              <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
            </button>

            <div id="account-menu-panel" class="hidden absolute right-0 top-full mt-3 w-[290px] bg-[#350047] border border-[#4f006a] shadow-2xl rounded-md z-50 overflow-hidden">
              <div class="px-4 py-3 border-b border-[#4f006a] bg-[#2b003a]">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-[#d8b6d8] truncate">{{ auth()->user()->email }}</p>
              </div>

              <div class="py-1 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-4 py-3 text-[#f3d9ff] hover:bg-[#230030]">
                  <span>Account Details</span><span>›</span>
                </a>
                <a href="{{ route('front.orders.index', ['source' => 'online']) }}" class="flex items-center justify-between px-4 py-3 text-[#f3d9ff] hover:bg-[#230030]">
                  <span>My Online Order</span><span>›</span>
                </a>
                <a href="{{ route('front.orders.index', ['source' => 'offline']) }}" class="flex items-center justify-between px-4 py-3 text-[#f3d9ff] hover:bg-[#230030]">
                  <span>My Offline Order</span><span>›</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-4 py-3 text-[#f3d9ff] hover:bg-[#230030]">
                  <span>Addresses</span><span>›</span>
                </a>
                <a href="{{ route('front.wishlist.index') }}" class="flex items-center justify-between px-4 py-3 text-[#f3d9ff] hover:bg-[#230030]">
                  <span>Wishlist</span><span>›</span>
                </a>
              </div>

              <form action="{{ route('logout') }}" method="POST" class="border-t border-[#4f006a] bg-[#2b003a]">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-[#f3d9ff] hover:bg-[#230030]">Sign Out</button>
              </form>
            </div>
            @else
            <a href="{{ route('login') }}" id="icon-account" class="hover:text-[#d4af37] p-1 sm:p-2 transition-all" aria-label="My Account" title="My Account">
              <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
            </a>
            @endauth
          </div>

          <!-- Wishlist -->
          <a href="{{ route('front.wishlist.index') }}" id="icon-wishlist" class="hover:text-[#d4af37] p-1 sm:p-2 transition-all" aria-label="Wishlist" title="Wishlist">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </a>

          <!-- Cart with Badge -->
          <a href="{{ route('front.cart.index') }}" id="icon-cart" class="hover:text-[#d4af37] p-1 sm:p-2 relative transition-all" aria-label="Cart" title="Shopping Cart">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            <span
              class="absolute -top-0.5 -right-0.5 sm:top-0 sm:right-0 w-4 h-4 bg-[#d4af37] text-white text-[9px] font-bold rounded-full flex items-center justify-center badge-animate">
              {{ $cartCount }}
            </span>
          </a>

        </div>
      </div>

      <!-- Mobile Search Bar (Hidden by default) -->
      <div id="mobile-search-bar-container" class="md:hidden pb-4 px-4 overflow-hidden max-h-0 transition-all duration-300 ease-in-out opacity-0">
        <div class="relative w-full">
            <input id="mobile-search-input" type="text" placeholder="Search for Earrings, Necklace, Rings, Anklets..."
                class="w-full h-11 pl-4 pr-12 text-sm bg-[#350047] border border-[#4f006a] placeholder:text-[#c0a0c0] text-white focus:outline-none focus:border-[#d4af37]" />
            <button class="absolute right-0 top-0 h-11 w-11 flex items-center justify-center bg-[#d4af37] text-white"
                aria-label="Search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
      </div>
    </div>
  </header>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- MOBILE SLIDE-OUT MENU                          -->
  <!-- ═══════════════════════════════════════════════ -->
  <div id="mobile-menu" class="fixed inset-0 z-[200] invisible transition-all duration-300 lg:hidden" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

    <!-- Menu Content -->
    <div id="mobile-menu-content" class="absolute inset-y-0 left-0 w-[300px] bg-[#1a0023] shadow-2xl -translate-x-full transition-transform duration-300 flex flex-col border-r border-[#4f006a]">
        <div class="p-6 border-b border-[#4f006a] flex items-center justify-between">
            <span class="font-heading text-xl font-bold tracking-widest text-[#d4af37]">MENU</span>
            <button id="close-mobile-menu" class="p-2 -mr-2 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-6">
            <div class="space-y-6">
                <div class="space-y-4">
                    <p class="text-[10px] font-bold text-[#d4af37] uppercase tracking-[0.2em]">Quick Links</p>
                    <a href="{{ route('front.home') }}" class="block text-sm font-medium text-gray-300 hover:text-[#d4af37] transition-colors">Studio Store</a>
                    <a href="{{ route('front.jewellery') }}" class="block text-sm font-medium text-gray-300 hover:text-[#d4af37] transition-colors">Jewellery Home</a>
                </div>

                <div class="pt-6 border-t border-[#4f006a] space-y-4">
                    <p class="text-[10px] font-bold text-[#d4af37] uppercase tracking-[0.2em]">Profile & Account</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-sm font-medium text-gray-300">My Profile</a>
                        <a href="{{ route('front.orders.index') }}" class="block text-sm font-medium text-gray-300">My Orders</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-red-400 uppercase tracking-widest mt-2">Sign Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-sm font-medium text-gray-300">Login</a>
                        <a href="{{ route('register') }}" class="block text-sm font-medium text-gray-300">Register</a>
                    @endauth
                    <a href="{{ route('front.blog.index') }}" class="block text-sm font-medium text-gray-300">Fashion Blog</a>
                    <a href="{{ route('front.track_order') }}" class="block text-sm font-medium text-gray-300">Track Order</a>
                </div>
            </div>
        </div>

        <div class="p-6 bg-[#0a0711] border-t border-[#4f006a] italic text-[11px] text-gray-500 text-center">
            &copy; {{ date('Y') }} AVNEE Collections. Luxury Jewellery.
        </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- MAIN NAVIGATION BAR                            -->
  <!-- ═══════════════════════════════════════════════ -->
  <nav class="lg:hidden bg-[#2B003A] border-y border-[#f8c8dc]/40">
    <div class="px-3">
      <ul class="flex items-center justify-start gap-2 py-2 overflow-x-auto whitespace-nowrap hide-scrollbar">
        <li><a href="{{ route('front.products.collection', ['collection' => 'sale']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Sale</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'new-arrivals']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">New Arrivals</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Jewellery</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'organizers']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Organizers</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'gifting']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Gifting</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'hair-accessories']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Hair Accessories</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'watches']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Watches</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'trinkets']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-[#f8c8dc] border border-[#f8c8dc]/40 rounded-sm">Trinkets</a></li>
      </ul>
    </div>
  </nav>

  <nav id="main-nav" class="bg-[#4B0082] hidden lg:block" style="border-top: 1px solid rgba(164, 125, 171, 0.35); border-bottom: 2px solid #A47DAB;">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 relative">
      <ul class="flex items-center justify-center gap-4 xl:gap-6 h-12">
        <li><a href="{{ route('front.products.collection', ['collection' => 'sale']) }}" class="nav-item-link rounded-sm">SALE</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'new-arrivals']) }}" class="nav-item-link rounded-sm">NEW ARRIVALS</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="nav-item-link rounded-sm">JEWELLERY</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'organizers']) }}" class="nav-item-link rounded-sm">ORGANIZERS</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'gifting']) }}" class="nav-item-link rounded-sm">GIFTING</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'hair-accessories']) }}" class="nav-item-link rounded-sm">HAIR ACCESSORIES</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'watches']) }}" class="nav-item-link rounded-sm">WATCHES</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'trinkets']) }}" class="nav-item-link rounded-sm">TRINKETS</a></li>
      </ul>
    </div>
  </nav>

  <main class="flex-grow min-h-screen">
    @yield("content")
  </main>
  <!-- ═══════════════════════════════════════════════ -->
  <!-- FOOTER                                         -->
  <!-- ═══════════════════════════════════════════════ -->
  <footer class="bg-[#230030] text-white pt-0 pb-6" style="border-top: 3px solid #d4af37;">
    <!-- Decorative gold top bar -->
    <div class="w-full h-[3px] bg-gradient-to-r from-transparent via-[#f3d9ff] to-transparent"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Top Grid: 4 Columns -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-12 pt-16">

        <!-- Column 1: About Brand -->
        <div class="pr-0 lg:pr-6">
          <h4 class="footer-heading text-[#f3d9ff] font-semibold tracking-[0.12em] uppercase text-[15px]">About our brand</h4>
          <p class="text-[#e9d5ff] text-[15px] leading-7 mb-4">
            AVNEE Collections is a thoughtfully curated space for kidswear and everyday jewelry - created with love, comfort, and style in mind.
          </p>
          <p class="text-[#e9d5ff] text-[15px] leading-7 mb-6">
            Inspired by little moments and the joy of dressing up, we bring together pieces that celebrate both childhood and the woman behind it - simple, elegant, and made to feel special every day.
          </p>

          <!-- Social Icons -->
          <div class="flex items-center gap-3">
            @if(!empty($settings['facebook_url']))
            <a href="{{ $settings['facebook_url'] }}" target="_blank" title="Facebook"
              class="w-8 h-8 rounded-full border border-[#f3d9ff]/30 flex items-center justify-center text-[#f3d9ff] hover:bg-[#f3d9ff] hover:border-[#f3d9ff] hover:text-[#1a0023] transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['instagram_url']))
            <a href="{{ $settings['instagram_url'] }}" target="_blank" title="Instagram"
              class="w-8 h-8 rounded-full border border-[#f3d9ff]/30 flex items-center justify-center text-[#f3d9ff] hover:bg-[#f3d9ff] hover:border-[#f3d9ff] hover:text-[#1a0023] transition-colors duration-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
              </svg>
            </a>
            @endif

            @if(!empty($settings['twitter_url']))
            <a href="{{ $settings['twitter_url'] }}" target="_blank" title="Twitter / X"
              class="w-8 h-8 rounded-full border border-[#f3d9ff]/30 flex items-center justify-center text-[#f3d9ff] hover:bg-[#f3d9ff] hover:border-[#f3d9ff] hover:text-[#1a0023] transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['youtube_url']))
            <a href="{{ $settings['youtube_url'] }}" target="_blank" title="YouTube"
              class="w-8 h-8 rounded-full border border-[#f3d9ff]/30 flex items-center justify-center text-[#f3d9ff] hover:bg-[#f3d9ff] hover:border-[#f3d9ff] hover:text-[#1a0023] transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.54 6.42a2.78 2.78 0 00-1.94-1.98C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 1.98C0 8.18 0 12 0 12s0 3.82.46 5.58a2.78 2.78 0 001.94 1.98C4.12 20 11.96 20 11.96 20s6.88 0 8.6-.46a2.78 2.78 0 001.94-1.98C24 15.82 24 12 24 12s0-3.82-.46-5.58zM9.54 15.55V8.45l6.76 3.55-6.76 3.55z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['whatsapp_number']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) }}" target="_blank" title="WhatsApp"
              class="w-8 h-8 rounded-full border border-[#f3d9ff]/30 flex items-center justify-center text-[#f3d9ff] hover:bg-[#f3d9ff] hover:border-[#f3d9ff] hover:text-[#1a0023] transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.998 2C6.477 2 2 6.477 2 12c0 1.821.491 3.53 1.346 5.003L2.007 22l5.116-1.34A9.959 9.959 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 11.998 2z"/>
              </svg>
            </a>
            @endif
          </div>
        </div>

        <!-- Column 2: Shop -->
        <div>
          <h4 class="footer-heading text-[#f3d9ff] font-semibold tracking-[0.12em] uppercase text-[15px]">Shop</h4>
          <ul class="space-y-3.5">
            <li><a href="{{ route('front.products.index', ['category' => 'kids']) }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Kids Collection</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Jewellery</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Sarees</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'fun-trinkets']) }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Funky Trinkets</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'hair-accessories']) }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Hair Accessories</a></li>
          </ul>
        </div>

        <!-- Column 3: About -->
        <div>
          <h4 class="footer-heading text-[#f3d9ff] font-semibold tracking-[0.12em] uppercase text-[15px]">About</h4>
          <ul class="space-y-3.5">
            <li><a href="{{ route('front.page', 'terms-of-service') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Terms of Service</a></li>
            <li><a href="{{ route('front.page', 'privacy-policy') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Privacy Policy</a></li>
            <li><a href="{{ route('front.page', 'return-exchange-policy') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Returns Policy</a></li>
            <li><a href="{{ route('front.page', 'shipping-policy') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Shipping Policy</a></li>
            <li><a href="{{ route('front.page', 'faqs') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">FAQ's</a></li>
            <li><a href="{{ route('front.contact') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Contact Us</a></li>
            <li><a href="{{ route('front.careers') }}" class="text-[#e9d5ff] text-[15px] hover:text-[#f3d9ff] transition-colors">Careers</a></li>
          </ul>
        </div>

        <!-- Column 4: Newsletter -->
        <div>
          <h4 class="footer-heading text-[#f3d9ff] font-semibold tracking-[0.12em] uppercase text-[15px]">Newsletter</h4>
          <div class="footer-newsletter border-[#f3d9ff]/20 bg-top-bar-dark/10">
            <p class="text-[#e9d5ff] text-[15px] leading-7 mb-5">
              Subscribe to get notified about product launches, special offers and company news.
            </p>
            <form id="jewellery-newsletter-form" class="flex flex-col gap-3">
              @csrf
              <input type="email" name="email" id="jewellery-newsletter-email" placeholder="Your email address" required
                class="bg-white/5 border border-[#f3d9ff]/20 text-[#f3d9ff] text-[15px] px-4 py-3 focus:outline-none focus:border-[#f3d9ff] transition-colors placeholder-[#f3d9ff]/50" />
              <button type="submit"
                class="bg-[#d4af37] hover:bg-[#f3d9ff] text-[#1a0023] text-[13px] font-bold tracking-[0.18em] uppercase px-6 py-3.5 transition-colors w-full">
                SUBSCRIBE
              </button>
              <p id="jewellery-newsletter-msg" class="text-sm text-green-400 hidden">✓ Thanks for subscribing!</p>
            </form>
            <div class="mt-5 pt-4 border-t border-[#f3d9ff]/20 text-[14px] text-[#e9d5ff] space-y-2">
              <p><span class="font-semibold">Call Us:</span> <a href="tel:+91908671144" class="hover:text-[#f3d9ff]">+91 908671144</a></p>
              <p><span class="font-semibold">Mail:</span> <a href="mailto:studio@avneecollections.com" class="hover:text-[#f3d9ff]">studio@avneecollections.com</a></p>
              <p><span class="font-semibold">Alt Mail:</span> <a href="mailto:avnee.collections@gmail.com" class="hover:text-[#f3d9ff]">avnee.collections@gmail.com</a></p>
              <p><span class="font-semibold">WhatsApp:</span> <a href="https://wa.me/91908671144" target="_blank" class="hover:text-[#f3d9ff]">+91 908671144</a></p>
            </div>
          </div>
        </div>

      </div>

      <!-- Bottom Frame -->
      <div class="pt-8 border-t border-[#2a2218] flex flex-col md:flex-row items-center justify-between gap-6">

        <!-- Left: Copyright and Dropdown -->
        <div
          class="flex items-center gap-4 text-[#e9d5ff] text-[14px] w-full md:w-auto justify-center md:justify-start">
          <!-- Globe icon button mock -->
          <button class="flex items-center gap-1 hover:text-[#f3d9ff] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
              </path>
            </svg>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <span>&copy; {{ date('Y') }} AVNEE Collections - All Rights Reserved.</span>
        </div>

        <!-- Right: Payment Methods -->
        <div class="flex items-center gap-3 md:gap-3.5 flex-wrap justify-center md:justify-end">
          <!-- Mocking the payment method badges -->
          <div class="bg-white rounded-[4px] w-[52px] h-[32px] md:w-[60px] md:h-[36px] flex items-center justify-center shadow-sm">
            <span class="text-[12px] md:text-[13px] font-bold text-[#1434CB]">VISA</span>
          </div>
          <div class="bg-white rounded-[4px] w-[52px] h-[32px] md:w-[60px] md:h-[36px] flex items-center justify-center shadow-sm">
            <div class="flex -space-x-1 opacity-90">
              <div class="w-3.5 h-3.5 md:w-4 md:h-4 rounded-full bg-red-500"></div>
              <div class="w-3.5 h-3.5 md:w-4 md:h-4 rounded-full bg-yellow-500"></div>
            </div>
          </div>
          <div class="bg-white rounded-[4px] w-[52px] h-[32px] md:w-[60px] md:h-[36px] flex items-center justify-center shadow-sm">
            <span class="text-[9.5px] md:text-[10.5px] font-bold text-[#0070BA] italic leading-none text-center">AM<br />EX</span>
          </div>
          <div class="bg-white rounded-[4px] w-[52px] h-[32px] md:w-[60px] md:h-[36px] flex items-center justify-center shadow-sm">
            <span class="text-[13px] md:text-[14px] font-bold text-[#f2a900]">a</span>
          </div>
          <div class="bg-white rounded-[4px] w-[52px] h-[32px] md:w-[60px] md:h-[36px] flex items-center justify-center shadow-sm">
            <span class="text-[10px] md:text-[11px] font-bold text-[#003087] italic">PayPal</span>
          </div>
        </div>

      </div>

    </div>
  </footer>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- MOBILE SLIDE-OUT MENU                          -->
  <!-- ═══════════════════════════════════════════════ -->
  <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300">
  </div>
  <div id="mobile-menu-panel"
    class="fixed top-0 left-0 h-full w-72 bg-[#350047] z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-5">
      <!-- Close Button -->
      <button id="mobile-menu-close" class="absolute top-4 right-4 p-1 icon-btn" aria-label="Close menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Mobile Logo -->
      <div class="mb-6 pt-1">
        <span class="brand-wordmark brand-wordmark-mobile">
          <span class="brand-wordmark-main">AVNEE</span>
          <span class="brand-wordmark-sub">Collections</span>
        </span>
      </div>

      <!-- Mobile Brand Links -->
      <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
        <a href="#"
          class="bg-top-bar-dark text-white text-[10px] font-semibold tracking-wider px-3 py-1 rounded-sm">TJORI</a>
        <a href="#" class="text-sm font-medium text-icon-dark">Saagah</a>
      </div>

      <!-- Mobile Nav Links -->
      <nav class="space-y-1">
        <p class="text-[10px] font-semibold tracking-widest text-[#c0a0c0] uppercase mb-3">Shop</p>
        @foreach($categories as $category)
        <a href="{{ route('front.products.index', ['category' => $category->slug]) }}"
          class="block text-sm font-semibold tracking-wider uppercase py-2.5 border-b border-gray-100 text-icon-dark hover:text-brand-gold transition-colors duration-200">
          {{ $category->name }}
        </a>
        @endforeach
        <div class="pt-4 space-y-3">
          <p class="text-[10px] font-semibold tracking-widest text-[#c0a0c0] uppercase">Quick Links</p>
          <a href="{{ route('front.blog.index') }}"
            class="block text-sm font-medium text-icon-dark hover:text-brand-gold transition-colors duration-200">Blog</a>
          <a href="{{ route('front.contact') }}"
            class="block text-sm font-medium text-icon-dark hover:text-brand-gold transition-colors duration-200">Contact Us</a>
        </div>
      </nav>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- JAVASCRIPT                                     -->
  <!-- ═══════════════════════════════════════════════ -->
  <script>
    // Mobile Search Toggle
    const mobileSearchBtn = document.getElementById('mobile-search-btn');
    const mobileSearchBar = document.getElementById('mobile-search-bar-container');

    mobileSearchBtn?.addEventListener('click', () => {
      if (!mobileSearchBar) return;
      mobileSearchBar.classList.toggle('hidden');
      if (!mobileSearchBar.classList.contains('hidden')) {
        mobileSearchBar.querySelector('input')?.focus();
      }
    });

    // Mobile Menu Toggle
    const menuBtn = document.getElementById('mobile-menu-btn');
    const menuOverlay = document.getElementById('mobile-menu-overlay');
    const menuPanel = document.getElementById('mobile-menu-panel');
    const menuClose = document.getElementById('mobile-menu-close');

    function openMenu() {
      menuOverlay.classList.remove('hidden');
      setTimeout(() => {
        menuOverlay.classList.remove('opacity-0');
        menuPanel.classList.remove('-translate-x-full');
      }, 10);
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      menuOverlay.classList.add('opacity-0');
      menuPanel.classList.add('-translate-x-full');
      setTimeout(() => {
        menuOverlay.classList.add('hidden');
      }, 300);
      document.body.style.overflow = '';
    }

    menuBtn?.addEventListener('click', openMenu);
    menuClose?.addEventListener('click', closeMenu);
    menuOverlay?.addEventListener('click', closeMenu);

    // Account Menu Toggle
    const accountRoot = document.getElementById('account-menu-root');
    const accountBtn = document.getElementById('icon-account');
    const accountPanel = document.getElementById('account-menu-panel');

    if (accountRoot && accountBtn && accountPanel) {
      const closeAccountMenu = () => {
        accountPanel.classList.add('hidden');
        accountBtn.setAttribute('aria-expanded', 'false');
      };




      accountBtn.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        const isHidden = accountPanel.classList.contains('hidden');
        if (isHidden) {
          accountPanel.classList.remove('hidden');
          accountBtn.setAttribute('aria-expanded', 'true');
        } else {
          closeAccountMenu();
        }
      });

      accountPanel.addEventListener('click', (event) => {
        event.stopPropagation();
      });

      document.addEventListener('click', (event) => {
        if (!accountRoot.contains(event.target)) {
          closeAccountMenu();
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          closeAccountMenu();
        }
      });
    }
  </script>

  <!-- Swiper JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (window.__AVNEE_CUSTOM_SWIPERS__ === true) {
        return;
      }

      if (typeof window.Swiper === 'undefined') {
        console.warn('Swiper bundle did not load; skipping carousel initialization.');
        return;
      }

      const shouldEnableLoop = (selector, fallbackSlidesPerView = 1) => {
        const root = document.querySelector(selector);
        if (!root) return false;

        const slides = root.querySelectorAll('.swiper-slide').length;
        return slides > fallbackSlidesPerView;
      };

      new window.Swiper('.hero-swiper', {
        loop: shouldEnableLoop('.hero-swiper', 1),
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

      new window.Swiper('.best-buys-swiper', {
        loop: shouldEnableLoop('.best-buys-swiper', 4),
        speed: 600,
        spaceBetween: 16,
        slidesPerView: 2,
        autoplay: {
          delay: 2600,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        navigation: {
          prevEl: '#best-buys-prev',
          nextEl: '#best-buys-next',
        },
        breakpoints: {
          640: { slidesPerView: 2, spaceBetween: 16 },
          768: { slidesPerView: 3, spaceBetween: 20 },
          1024: { slidesPerView: 4, spaceBetween: 24 },
          1280: { slidesPerView: 4, spaceBetween: 28 },
        },
      });

      new window.Swiper('.bestsell-swiper', {
        loop: shouldEnableLoop('.bestsell-swiper', 5),
        speed: 600,
        spaceBetween: 16,
        slidesPerView: 2,
        navigation: {
          prevEl: '#bestsell-prev',
          nextEl: '#bestsell-next',
        },
        breakpoints: {
          480: { slidesPerView: 2, spaceBetween: 16 },
          640: { slidesPerView: 3, spaceBetween: 20 },
          860: { slidesPerView: 4, spaceBetween: 24 },
          1024: { slidesPerView: 5, spaceBetween: 24 },
          1280: { slidesPerView: 5, spaceBetween: 24 },
        },
      });

      new window.Swiper('.stories-swiper', {
        loop: shouldEnableLoop('.stories-swiper', 2),
        speed: 600,
        spaceBetween: 24,
        slidesPerView: 1,
        navigation: {
          nextEl: '#story-next',
        },
        pagination: {
          el: '.stories-swiper .swiper-pagination',
          clickable: true,
        },
        breakpoints: {
          850: { slidesPerView: 1.5 },
          1100: { slidesPerView: 2 },
        },
      });

      new window.Swiper('.look-swiper', {
        loop: shouldEnableLoop('.look-swiper', 5),
        speed: 600,
        centeredSlides: true,
        grabCursor: true,
        slidesPerView: 2,
        spaceBetween: -20,
        navigation: {
          prevEl: '#look-prev',
          nextEl: '#look-next',
        },
        breakpoints: {
          480: { slidesPerView: 3, spaceBetween: -20 },
          640: { slidesPerView: 3, spaceBetween: -30 },
          768: { slidesPerView: 5, spaceBetween: -30 },
          1024: { slidesPerView: 5, spaceBetween: -45 },
          1280: { slidesPerView: 5, spaceBetween: -70 },
        },
      });
    });
  </script>


  <script>
    (function () {
      // Generate a scalloped circle path using quadratic beziers
      // n = number of bumps, R = outer radius (peak), r = inner radius (valley)
      function scallopPath(cx, cy, R, r, n) {
        let d = '';
        for (let i = 0; i < n; i++) {
          // Angle of outer peak points
          const a1 = (i / n) * 2 * Math.PI - Math.PI / 2;
          const a2 = ((i + 0.5) / n) * 2 * Math.PI - Math.PI / 2; // valley control
          const a3 = ((i + 1) / n) * 2 * Math.PI - Math.PI / 2;   // next peak

          const x1 = cx + R * Math.cos(a1);
          const y1 = cy + R * Math.sin(a1);
          const qx = cx + r * Math.cos(a2);
          const qy = cy + r * Math.sin(a2);
          const x2 = cx + R * Math.cos(a3);
          const y2 = cy + R * Math.sin(a3);

          if (i === 0) d += `M ${x1.toFixed(2)},${y1.toFixed(2)} `;
          d += `Q ${qx.toFixed(2)},${qy.toFixed(2)} ${x2.toFixed(2)},${y2.toFixed(2)} `;
        }
        return d + 'Z';
      }

      // Outer scallop: R=88, r=74, 16 bumps
      const outerPath = scallopPath(100, 100, 88, 74, 16);
      // Inner decorative stroke: R=79, r=67, 16 bumps (slightly smaller)
      const innerPath = scallopPath(100, 100, 79, 67, 16);

      // Apply to all badge SVGs
      document.querySelectorAll('.badge-svg').forEach(svg => {
        const fillPath = svg.querySelector('.scallop-fill');
        const strokePath = svg.querySelector('.scallop-stroke');
        if (fillPath) {
          fillPath.setAttribute('d', outerPath);
        }
        if (strokePath) {
          strokePath.setAttribute('d', innerPath);
        }
      });
    })();
  </script>

  <!-- Live Search Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        let debounceTimer;

        if (searchInput && searchResults) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(debounceTimer);
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('front.products.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(product => {
                                    const item = document.createElement('a');
                                    item.href = product.url;
                                    item.className = 'search-result-item';
                                    item.innerHTML = `
                                        <img src="${product.image}" alt="${product.name}" class="search-result-image">
                                        <div class="search-result-info">
                                            <div class="search-result-name">${product.name}</div>
                                            <div class="search-result-price">
                                                ${product.price}
                                                ${product.old_price ? `<span class="search-result-old-price">${product.old_price}</span>` : ''}
                                            </div>
                                        </div>
                                    `;
                                    searchResults.appendChild(item);
                                });
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = '<div class="no-results">No products found</div>';
                                searchResults.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching search results:', error);
                        });
                }, 300);
            });

            // Close results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });

            // Show results again when refocusing if there's text
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && searchResults.children.length > 0) {
                    searchResults.classList.remove('hidden');
                }
            });
        }

        // Mobile Menu Toggle Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
        const mobileMenuContent = document.getElementById('mobile-menu-content');

        const openMobileMenu = () => {
            mobileMenu.classList.remove('invisible');
            setTimeout(() => {
                mobileMenuBackdrop.classList.add('opacity-100');
                mobileMenuContent.classList.remove('-translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        };

        const closeMobileMenu = () => {
            mobileMenuBackdrop.classList.remove('opacity-100');
            mobileMenuContent.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('invisible');
                document.body.style.overflow = '';
            }, 300);
        };

        mobileMenuBtn?.addEventListener('click', openMobileMenu);
        closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
        mobileMenuBackdrop?.addEventListener('click', closeMobileMenu);

        // Mobile Search Toggle Logic
        const mobileSearchBtn = document.getElementById('mobile-search-btn');
        const mobileSearchBar = document.getElementById('mobile-search-bar-container');

        mobileSearchBtn?.addEventListener('click', () => {
            if (mobileSearchBar.classList.contains('max-h-0')) {
                mobileSearchBar.classList.remove('max-h-0', 'opacity-0');
                mobileSearchBar.classList.add('max-h-20', 'opacity-100');
            } else {
                mobileSearchBar.classList.add('max-h-0', 'opacity-0');
                mobileSearchBar.classList.remove('max-h-20', 'opacity-100');
            }
        });
    });
  </script>

  <!-- Wishlist AJAX Handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const showWishlistToast = (message) => {
            const toast = document.createElement('div');
            toast.className = 'fixed top-20 right-4 z-[250] bg-black text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md shadow-xl';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => { toast.remove(); }, 1800);
        };

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.wishlist-btn');
            if (!btn) return;

            e.preventDefault();
            const productId = btn.getAttribute('data-product-id');
            const icon = btn.querySelector('.wishlist-icon') || btn.querySelector('svg');

            if (!productId) return;

            // Simple feedback
            btn.style.opacity = '0.5';
            btn.style.pointerEvents = 'none';

            fetch("{{ route('front.wishlist.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';

                if (data.action === 'added') {
                    btn.classList.add('text-red-500');
                    if (icon) icon.classList.add('fill-current');
                    showWishlistToast('Product added to wishlist');
                } else if (data.action === 'removed') {
                    btn.classList.remove('text-red-500');
                    if (icon) icon.classList.remove('fill-current');
                    showWishlistToast('Product removed from wishlist');
                }
            })
            .catch(error => {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
                console.error('Wishlist error:', error);
            });
        });
    });
  </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const desktopSearch = document.getElementById('search-input');
      const mobileSearch = document.getElementById('mobile-search-input');
      const placeholders = [
        'Search for Earrings...',
        'Search for Necklace...',
        'Search for Rings...',
        'Search for Anklets...'
      ];
      let idx = 0;

      const setPlaceholder = () => {
        const text = placeholders[idx % placeholders.length];
        if (desktopSearch) desktopSearch.placeholder = text;
        if (mobileSearch) mobileSearch.placeholder = text;
        idx += 1;
      };

      setPlaceholder();
      window.setInterval(setPlaceholder, 2600);
    });
    </script>

  <!-- Newsletter AJAX Handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('jewellery-newsletter-form');
        if (!form) return;
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('jewellery-newsletter-email').value;
            const btn = form.querySelector('button[type="submit"]');
            const msg = document.getElementById('jewellery-newsletter-msg');
            btn.disabled = true;
            btn.textContent = 'Subscribing...';
            fetch('{{ route("front.newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(async (r) => {
                const data = await r.json().catch(() => ({}));
                if (!r.ok || !data.success) {
                    const validationMessage = data?.errors?.email?.[0];
                    throw new Error(validationMessage || data?.message || 'Subscription failed');
                }
                return data;
            })
            .then(() => {
                btn.textContent = '✓ Subscribed!';
                btn.disabled = true;
                msg.textContent = '✓ Thanks for subscribing!';
                msg.classList.remove('hidden');
                form.querySelector('input[type="email"]').value = '';
            })
            .catch((error) => {
                btn.disabled = false;
                btn.textContent = 'SUBSCRIBE';
                msg.textContent = error?.message || 'Could not subscribe. Please try again.';
                msg.classList.remove('hidden');
            });
        });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const megaMenus = document.querySelectorAll('[data-mega-menu]');

      megaMenus.forEach((menu) => {
        const defaultTab = menu.getAttribute('data-default-tab');
        const tabs = menu.querySelectorAll('[data-mega-tab]');
        const panels = menu.querySelectorAll('[data-mega-panel]');

        const activateTab = (tabKey) => {
          tabs.forEach((tab) => {
            tab.classList.toggle('is-active', tab.getAttribute('data-mega-tab') === tabKey);
          });

          panels.forEach((panel) => {
            panel.classList.toggle('is-active', panel.getAttribute('data-mega-panel') === tabKey);
          });
        };

        tabs.forEach((tab) => {
          const tabKey = tab.getAttribute('data-mega-tab');
          tab.addEventListener('mouseenter', () => activateTab(tabKey));
          tab.addEventListener('focus', () => activateTab(tabKey));
        });

        menu.addEventListener('mouseenter', () => activateTab(defaultTab));
        menu.addEventListener('mouseleave', () => activateTab(defaultTab));
        activateTab(defaultTab);
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
