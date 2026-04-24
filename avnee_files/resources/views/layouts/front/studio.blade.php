<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @stack('schema')
  <title>@yield('title', $settings['site_name'] ?? 'AVNEE Collections') - {{ $settings['default_meta_title'] ?? 'Premium Ethnic Wear' }}</title>
  <meta name="description" content="@yield('meta_description', $settings['default_meta_description'] ?? 'AVNEE Collections – Premium ethnic wear. Free shipping on orders above ₹1499.')" />

  <!-- Google Analytics -->
  @if(!empty($settings['google_analytics_id']))
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', "{{ $settings['google_analytics_id'] ?? '' }}");
  </script>
  @endif

  <!-- Facebook Pixel -->
  @if(!empty($settings['facebook_pixel_id']))
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    s=b.src=v;s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', "{{ $settings['facebook_pixel_id'] ?? '' }}");
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $settings['facebook_pixel_id'] }}&ev=PageView&noscript=1"
  /></noscript>
  @endif

  {!! $settings['custom_pixels'] ?? '' !!}

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Sans:wght@300;400;500;600&family=Bodoni+Moda:ital,opsz,wght@0,6..144,400..900;1,6..144,400..900&family=Playfair+Display:wght@400;500;600;700&display=swap"
    rel="stylesheet" />

  <style>
    :root {
      --studio-light-pink: #FBF4E6;
      --studio-dark-pink: #C75B6E;
    }

    body {
      font-family: "Playfair Display", serif;
      color: var(--studio-dark-pink);
      background-color: var(--studio-light-pink);
    }

    /* Studio homepage: section titles — mulberry, ALL CAPS, underline */
    .studio-section-heading {
      font-family: "Playfair Display", serif;
      color: var(--studio-dark-pink);
      font-weight: 400;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      text-decoration: underline;
      text-decoration-color: rgba(199, 91, 110, 0.45);
      text-underline-offset: 12px;
      text-align: center;
      line-height: 1.3;
      font-size: clamp(1.6875rem, 1.3rem + 1.35vw, 2.5rem);
    }

    .studio-section-heading--left {
      text-align: left;
    }

    @media (min-width: 768px) {
      .studio-section-heading--split {
        text-align: left;
      }
    }

    .studio-section-heading--flash {
      letter-spacing: 0.1em;
      text-underline-offset: 8px;
      font-size: clamp(1.375rem, 1.15rem + 1vw, 2rem);
    }

    /* Customer Stories: slightly larger than default section heading */
    #customer-stories .studio-section-heading {
      font-size: clamp(1.8rem, 1.38rem + 1.45vw, 2.65rem);
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Custom scrollbar for search */
    .search-input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(199, 91, 110, 0.28);
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
      background-color: var(--studio-dark-pink);
      transition: width 0.3s ease;
    }

    .brand-wordmark {
      display: inline-flex;
      flex-direction: column;
      align-items: center;
      line-height: 1;
    }

    .brand-wordmark-main {
      font-family: "Cinzel", "Bodoni Moda", serif;
      font-weight: 600;
      letter-spacing: 0.32em;
      text-transform: uppercase;
      font-size: clamp(1.15rem, 2.3vw, 2rem);
      color: #F8C8DC;
    }

    .brand-wordmark-sub {
      margin-top: 0.3rem;
      font-family: "DM Sans", sans-serif;
      font-weight: 600;
      letter-spacing: 0.58em;
      text-transform: uppercase;
      font-size: clamp(0.42rem, 0.8vw, 0.62rem);
      color: #F8C8DC;
      opacity: 0.95;
      padding-left: 0.58em;
    }

    /* Light header (pastel strip): maroon wordmark */
    #main-header .brand-wordmark-main,
    #main-header .brand-wordmark-sub {
      color: var(--studio-dark-pink);
    }

    #main-header .brand-wordmark-sub {
      opacity: 1;
    }

    .brand-wordmark-mobile .brand-wordmark-main {
      color: var(--studio-dark-pink);
      font-size: 1.95rem;
      letter-spacing: 0.28em;
    }

    .brand-wordmark-mobile .brand-wordmark-sub {
      color: var(--studio-dark-pink);
      font-size: 0.58rem;
      letter-spacing: 0.52em;
      padding-left: 0.52em;
      margin-top: 0.18rem;
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
      color: #b87333;
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
      background-color: var(--studio-dark-pink);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-item-link {
      color: var(--studio-light-pink);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      padding: 8px 10px;
      transition: all 0.2s ease;
    }

    .nav-item-link:hover {
      background-color: var(--studio-light-pink);
      color: var(--studio-dark-pink);
    }

    .mega-menu-panel {
      min-width: 1040px;
      background: var(--studio-light-pink);
      border: 1px solid rgba(199, 91, 110, 0.35);
      box-shadow: 0 8px 20px rgba(199, 91, 110, 0.12);
    }

    .mega-tab {
      display: block;
      padding: 10px 14px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--studio-dark-pink);
      border-bottom: 1px solid rgba(199, 91, 110, 0.22);
      transition: all 0.2s ease;
    }

    .mega-tab.is-active {
      background: rgba(199, 91, 110, 0.12);
      color: var(--studio-dark-pink);
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
      border: 1px solid rgba(199, 91, 110, 0.4);
      box-shadow: 0 4px 12px rgba(199, 91, 110, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mega-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(199, 91, 110, 0.24);
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
      color: var(--studio-dark-pink);
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
      color: var(--studio-dark-pink);
    }

    .nav-link.sale-link:hover {
      color: #b34d60;
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
      object-fit: cover;
      object-position: center center;
      transition: transform 6s ease;
    }

    /* Search Results Styles */
    .search-result-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }
    .search-result-item:hover {
        background-color: var(--studio-light-pink);
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
        color: #1c1208;
        margin-bottom: 0.25rem;
    }
    .search-result-price {
        font-size: 0.8125rem;
        color: var(--studio-dark-pink);
        font-weight: 600;
    }
    .search-result-old-price {
        font-size: 0.75rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-left: 0.5rem;
    }
    .no-results {
        padding: 1rem;
        text-align: center;
        color: #6b7280;
        font-size: 0.875rem;
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

    #shop-by-price-static .price-badge-wrap .badge-svg path,
    #shop-by-price .price-badge-wrap .badge-svg path,
    .price-badge-wrap .badge-svg path,
    #shop-by-price-static .price-badge-wrap .badge-svg circle,
    #shop-by-price .price-badge-wrap .badge-svg circle,
    .price-badge-wrap .badge-svg circle {
      stroke: var(--studio-dark-pink) !important;
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
      background: #fff;
      width: 28px;
      border-radius: 5px;
    }

    /* Same dot scale on other home carousels */
    .just-in-swiper .swiper-pagination-bullet,
    .flash-swiper .swiper-pagination-bullet,
    .combo-swiper .swiper-pagination-bullet,
    .new-in-jewellery-swiper .swiper-pagination-bullet,
    .best-buy-static-swiper .swiper-pagination-bullet,
    .studio-edits-swiper .swiper-pagination-bullet,
    .style-swiper .swiper-pagination-bullet,
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
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
      transition: all 0.2s ease;
      color: #555;
    }

    .look-arrow:hover {
      background: #fff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.18);
      color: #111;
    }

    /* Top Collections Cards */
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
      background-color: #000;
      color: #fff;
      border-color: #000;
    }

    /* Bestselling Styles Arrows (Square) */
    .bestsell-arrow {
      width: 44px;
      height: 44px;
      background: #fff;
      border: 1px solid #eaeaea;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      transition: all 0.2s ease;
      color: #777;
    }

    .bestsell-arrow:hover {
      background: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
      color: #111;
    }

    /* Stories Swiper */
    .stories-swiper {
      padding-bottom: 40px !important;
    }

    .story-card {
      background: #fffcf9;
      border: 1px solid #ede8e0;
      border-radius: 6px;
    }

    .stories-swiper .swiper-pagination-bullet {
      background: #dfdfdf;
      opacity: 1;
      width: 8px;
      height: 8px;
      margin: 0 5px !important;
    }

    .stories-swiper .swiper-pagination-bullet-active {
      background: #2a1f14;
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
      background: linear-gradient(to right, #d4a96a, transparent);
    }

    /* Footer newsletter box */
    .footer-newsletter {
      border: 1px solid rgba(199, 91, 110, 0.35);
      padding: 24px;
      background: rgba(251, 244, 230, 0.1);
      box-shadow: 0 6px 16px rgba(199, 91, 110, 0.1);
    }

    .section-card,
    .studio-block {
      border: 1px solid rgba(199, 91, 110, 0.35);
      box-shadow: 0 6px 16px rgba(199, 91, 110, 0.1);
    }

    /* Section dividers — dark pink line between every section */
    main > #hero-slider,
    main > #just-in,
    main > #best-buy-static,
    main > #home-lookbook,
    main > #home-top-collections,
    main > #shop-by-price-static,
    main > #shop-by-style-static,
    main > #studio-edits-slider,
    main > #customer-stories,
    main > #about-story {
      border-bottom: 2px solid rgba(199, 91, 110, 0.38);
    }

    /* Slightly thicker dividers for key homepage blocks */
    main > #just-in,
    main > #shop-by-price-static,
    main > #shop-by-style-static,
    main > #best-buy-static,
    main > #home-lookbook,
    main > #home-top-collections,
    main > #customer-stories {
      border-bottom-width: 3px;
    }

    /* Keep the hero divider below the image instead of touching it */
    main > #hero-slider {
      border-bottom: 0;
      padding-bottom: 1rem;
    }

    main > #hero-slider::after {
      content: '';
      position: absolute;
      left: calc(50% - 50vw);
      bottom: 0;
      width: 100vw;
      height: 2px;
      background: rgba(119, 7, 55, 0.35);
      pointer-events: none;
    }
  </style>
  @stack('styles')
</head>

<body class="font-body antialiased bg-[#FCEFF5] text-gray-900">

  <!-- ═══════════════════════════════════════════════ -->
  <!-- TOP ANNOUNCEMENT BAR                           -->
  <!-- ═══════════════════════════════════════════════ -->
  <div id="top-bar" class="bg-mulberry slide-down">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-9 text-xs sm:text-sm">

        <!-- Left: Brand Links -->
        <div class="hidden sm:flex items-center gap-3">
          <a href="{{ route('front.home') }}" id="brand-studio"
            class="bg-pastel-pink text-mulberry text-[10px] sm:text-xs font-semibold tracking-wider px-3 py-1 rounded-sm hover:bg-mulberry hover:text-pastel-pink border border-pastel-pink transition-all duration-300">
            STUDIO
          </a>
          <a href="{{ route('front.jewellery') }}" id="brand-jewellery"
            class="text-pastel-pink font-medium hover-underline transition-colors duration-200">
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
          <a href="{{ route('front.track_order', ['theme' => 'studio']) }}" id="link-track-order" class="hover-underline font-medium text-top-bar-text transition-colors duration-200 uppercase tracking-widest">Track Order</a>
        </div>

      </div>
    </div>
  </div>

  <!-- Mobile Brand Switcher -->
  <div class="sm:hidden bg-mulberry border-t border-pastel-pink/20 border-b border-pastel-pink/20">
    <div class="max-w-[1440px] mx-auto px-4 py-2 flex items-center justify-between gap-2">
      <!-- Left: Brand Links -->
      <div class="flex items-center gap-2">
        <a href="{{ route('front.home') }}"
          class="bg-pastel-pink text-mulberry text-[10px] font-semibold tracking-[0.16em] uppercase px-3 py-1 rounded-sm border border-pastel-pink">
          Studio
        </a>
        <a href="{{ route('front.jewellery') }}"
          class="text-pastel-pink text-[10px] font-semibold tracking-[0.16em] uppercase px-3 py-1 rounded-sm border border-pastel-pink/40 hover:border-pastel-pink transition-colors">
          Jewellery
        </a>
      </div>

      <!-- Right: Utility Links -->
      <div class="flex items-center gap-3">
        <a href="{{ route('front.blog.index') }}" class="text-pastel-pink text-[10px] font-semibold tracking-[0.16em] uppercase hover:underline">Blog</a>
        <a href="{{ route('front.track_order', ['theme' => 'studio']) }}" class="text-pastel-pink text-[10px] font-semibold tracking-[0.16em] uppercase hover-underline">Track</a>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════ -->
  <!-- MAIN HEADER                                    -->
  <!-- ═══════════════════════════════════════════════ -->
  <header id="main-header"
    class="bg-header-surface border-b border-mulberry/10 transition-all duration-300">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 sm:h-20 gap-4">

        <!-- Left: Mobile Menu -->
        <div class="flex items-center gap-4 min-w-0">
          <!-- Mobile: Hamburger Menu -->
          <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 text-mulberry hover:text-[#600028] transition-colors"
            aria-label="Open menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <!-- Search Bar (Desktop, left aligned, wider to match Jewellery) -->
          <div class="hidden lg:flex w-[300px] xl:w-[380px] max-w-full">
            <div class="relative w-full" id="search-container">
              <input id="search-input" type="text" placeholder="Search for Sarees..."
                class="search-input w-full h-10 pl-4 pr-11 text-sm bg-white border border-gray-300/90 placeholder:text-mulberry/40 text-mulberry transition-all duration-200 focus:ring-1 focus:ring-mulberry/25 focus:border-mulberry/30 shadow-inner" autocomplete="off" />
              <button id="search-btn"
                class="absolute right-0 top-0 h-10 w-11 flex items-center justify-center bg-pastel-pink hover:bg-[#f5d0e0] text-mulberry transition-colors duration-200 border border-l-0 border-gray-300/90"
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
        <div class="flex flex-1 justify-center lg:w-1/3">
          <a href="{{ route('front.home') }}" id="logo" class="flex flex-col items-center shrink-0 group">
            <span class="brand-wordmark transition-all duration-500">
              <span class="brand-wordmark-main">AVNEE</span>
              <span class="brand-wordmark-sub">Collections</span>
            </span>
          </a>
        </div>

        <!-- Right: Search + Action Icons -->
        <div class="flex items-center justify-end gap-2 sm:gap-3 lg:gap-4 lg:w-1/3">

          <!-- Mobile Search Toggle -->
          <button id="mobile-search-btn" class="md:hidden text-mulberry/80 hover:text-mulberry p-2 transition-colors"
            aria-label="Search">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>

          <!-- WhatsApp -->
          <a href="#" id="icon-whatsapp" class="text-mulberry/70 hover:text-mulberry p-1.5 sm:p-2 transition-all"
            aria-label="WhatsApp" title="WhatsApp">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </a>

          <!-- Account -->
          <div class="relative group/account">
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" id="icon-account" class="text-mulberry/70 hover:text-mulberry p-1.5 sm:p-2 transition-all" aria-label="My Account" title="My Account">
              <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
            </a>
            @if(auth()->check())
            <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-[#e8ddd0] shadow-xl rounded-sm py-2 opacity-0 invisible group-hover/account:opacity-100 group-hover/account:visible transition-all duration-200 z-50">
              <div class="px-4 py-2 border-b border-gray-100 mb-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Welcome,</p>
                <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
              </div>
              <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-[#fdfaf6] hover:text-[#b87333]">My Profile</a>
              <a href="{{ route('front.orders.index') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-[#fdfaf6] hover:text-[#b87333]">My Orders</a>
              <form action="{{ route('logout') }}" method="POST" class="mt-1 pt-1 border-t border-gray-100">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-semibold uppercase tracking-widest">Logout</button>
              </form>
            </div>
            @endif
          </div>

          <!-- Wishlist -->
          <a href="{{ route('front.wishlist.index') }}" id="icon-wishlist" class="text-mulberry/70 hover:text-mulberry p-1.5 sm:p-2 transition-all" aria-label="Wishlist" title="Wishlist">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </a>

          <!-- Cart with Badge -->
          <a href="{{ route('front.cart.index') }}" id="icon-cart" class="text-mulberry/70 hover:text-mulberry p-1.5 sm:p-2 transition-all relative" aria-label="Cart" title="Shopping Cart">
            <svg class="w-5 h-5 sm:w-[22px] sm:h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            <span
              class="absolute -top-0.5 -right-0.5 sm:top-0 sm:right-0 w-4 h-4 bg-[#E89BB0] text-white text-[9px] font-bold rounded-full flex items-center justify-center badge-animate">
              {{ $cartCount }}
            </span>
          </a>

        </div>
      </div>

      <!-- Mobile Search Bar (Hidden by default) -->
      <div id="mobile-search-bar-container" class="md:hidden pb-4 px-4 overflow-hidden max-h-0 transition-all duration-300 ease-in-out opacity-0">
        <div class="relative w-full">
            <input id="mobile-search-input" type="text" placeholder="Search for Girls Collection, Sarees, Jewelry, Trinkets..."
                class="w-full h-11 pl-4 pr-12 text-sm bg-white border border-gray-300/90 placeholder:text-mulberry/40 text-mulberry focus:outline-none focus:border-mulberry/30 focus:ring-1 focus:ring-mulberry/20" />
            <button class="absolute right-0 top-0 h-11 w-11 flex items-center justify-center bg-pastel-pink text-mulberry border border-l-0 border-gray-300/90"
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
  <!-- MAIN NAVIGATION BAR                            -->
  <!-- ═══════════════════════════════════════════════ -->
  <nav class="lg:hidden bg-mulberry border-y border-pastel-pink/40">
    <div class="px-3">
      <ul class="flex items-center gap-2 py-2 overflow-x-auto whitespace-nowrap hide-scrollbar">
        <li><a href="{{ route('front.sale') }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Sale</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'new-arrivals']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">New Arrivals</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'best-sellers']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Best Sellers</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'bogo']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Bogo</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'girls-dresses']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Kids</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Sarees</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Jewellery</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'accessories']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Accessories</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'fun-trinkets']) }}" class="inline-flex px-3 py-1.5 text-[10px] font-extrabold tracking-[0.16em] uppercase text-pastel-pink border border-pastel-pink/40 rounded-sm">Fun Trinkets</a></li>
      </ul>
    </div>
  </nav>

  <nav id="main-nav" class="bg-mulberry hidden lg:block" style="border-top: 1px solid rgba(248, 200, 220, 0.35); border-bottom: 2px solid #F8C8DC;">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 relative">
      <ul class="flex items-center justify-center gap-4 xl:gap-6 h-12">
        <li class="group relative" data-mega-menu data-default-tab="category">
          <a href="{{ route('front.sale') }}" class="nav-item-link rounded-sm">SALE</a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 mega-menu-panel shadow-2xl hidden group-hover:block z-[120] border border-pastel-pink/40">
            <div class="grid grid-cols-[190px_1fr]">
              <div class="border-r border-pastel-pink/40 bg-[#fdeff5]">
                <a href="{{ route('front.products.collection', ['collection' => 'sale']) }}" class="mega-tab" data-mega-tab="category">Category</a>
                <a href="{{ route('front.products.collection', ['collection' => 'sale']) }}" class="mega-tab" data-mega-tab="discount">Discount</a>
              </div>
              <div class="p-3">
                <div class="mega-panel" data-mega-panel="category">
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'category' => 'girls-dresses']) }}" class="mega-card"><img src="{{ asset('images/shop-by-style/girls-dresses.png') }}" alt="Kids"><span>Kids</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'category' => 'sarees']) }}" class="mega-card"><img src="{{ asset('images/party-frocks/Prod2/main.png') }}" alt="Sarees"><span>Sarees</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'category' => 'jewellery-gallery']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Viraasat Floral Necklace Set/AVN-JW-NEC-EMG-C56/AVN-JW-NEC-EMG-C56-02.png') }}" alt="Jewellery"><span>Jewellery</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'category' => 'accessories']) }}" class="mega-card"><img src="{{ asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.29 AM.jpeg') }}" alt="Accessories"><span>Accessories</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'category' => 'fun-trinkets']) }}" class="mega-card"><img src="{{ asset('images/trinkets/WhatsApp Image 2026-04-06 at 3.31.28 AM (1).jpeg') }}" alt="Trinkets"><span>Trinkets</span></a>
                </div>
                <div class="mega-panel" data-mega-panel="discount">
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'min_price' => 1501, 'max_price' => 2000]) }}" class="mega-card"><img src="{{ asset('images/shop-by-style/girls-dresses.png') }}" alt="20% and Above"><span>20% And Above</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'min_price' => 1001, 'max_price' => 1500]) }}" class="mega-card"><img src="{{ asset('images/party-frocks/Prod6/main.png') }}" alt="30% and Above"><span>30% And Above</span></a>
                  <a href="{{ route('front.products.collection', ['collection' => 'sale', 'max_price' => 1000]) }}" class="mega-card"><img src="{{ asset('images/party-frocks/Prod8/main.png') }}" alt="40% and Above"><span>40% And Above</span></a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'new-arrivals']) }}" class="nav-item-link rounded-sm">NEW ARRIVALS</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'best-sellers']) }}" class="nav-item-link rounded-sm">BEST SELLERS</a></li>
        <li><a href="{{ route('front.products.collection', ['collection' => 'bogo']) }}" class="nav-item-link rounded-sm">BOGO</a></li>
        <li class="group relative">
          <a href="{{ route('front.products.index', ['category' => 'girls-dresses']) }}" class="nav-item-link rounded-sm">KIDS</a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 mega-menu-panel shadow-2xl hidden group-hover:block z-[120] border border-pastel-pink/40">
            <div class="p-3">
              <div class="mega-panel is-active">
                <a href="{{ route('front.kids.section', ['section' => 'all-girls']) }}" class="mega-card"><img src="{{ asset('images/shop-by-style/girls-dresses.png') }}" alt="All Girls"><span>All Girls</span></a>
                <a href="{{ route('front.kids.section', ['section' => 'party-frocks']) }}" class="mega-card"><img src="{{ asset('images/party-frocks/Prod1/main.png') }}" alt="Party Frocks"><span>Party Frocks</span></a>
                <a href="{{ route('front.kids.section', ['section' => 'dailywear']) }}" class="mega-card"><img src="{{ asset('images/shop-by-style/girls-dresses.png') }}" alt="Dailywear"><span>Dailywear</span></a>
                <a href="{{ route('front.kids.section', ['section' => 'festive-wear']) }}" class="mega-card"><img src="{{ asset('images/party-frocks/Prod4/main.png') }}" alt="Festive Wear"><span>Festive Wear</span></a>
              </div>
            </div>
          </div>
        </li>
        <li class="group relative" data-mega-menu data-default-tab="collections">
          <a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="nav-item-link rounded-sm">SAREES</a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 mega-menu-panel shadow-2xl hidden group-hover:block z-[120] border border-pastel-pink/40">
            <div class="grid grid-cols-[190px_1fr]">
              <div class="border-r border-pastel-pink/40 bg-[#fdeff5]">
                <a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="mega-tab" data-mega-tab="collections">Collections</a>
                <a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="mega-tab" data-mega-tab="fabric">Fabric</a>
                <a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="mega-tab" data-mega-tab="occasion">Occasion</a>
                <a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="mega-tab" data-mega-tab="color">Color</a>
              </div>
              <div class="p-3">
                <div class="mega-panel" data-mega-panel="collections">
                  <a href="{{ route('front.women.sarees.all-sarees') }}" class="mega-card"><img src="{{ asset('images/sarees/1.webp') }}" alt="All Sarees"><span>All Sarees</span></a>
                  <a href="{{ route('front.women.sarees.daily-wear-sarees') }}" class="mega-card"><img src="{{ asset('images/sarees/2.webp') }}" alt="Daily Wear Sarees"><span>Daily Wear Sarees</span></a>
                  <a href="{{ route('front.women.sarees.semi-silk-sarees') }}" class="mega-card"><img src="{{ asset('images/sarees/3.webp') }}" alt="Semi Silk Sarees"><span>Semi Silk Sarees</span></a>
                  <a href="{{ route('front.women.sarees.cotton-sarees') }}" class="mega-card"><img src="{{ asset('images/sarees/4.webp') }}" alt="Cotton Sarees"><span>Cotton Sarees</span></a>
                  <a href="{{ route('front.women.sarees.georgette-sarees') }}" class="mega-card"><img src="{{ asset('images/sarees/5.webp') }}" alt="Georgette Sarees"><span>Georgette Sarees</span></a>
                </div>
                <div class="mega-panel" data-mega-panel="fabric">
                  <a href="{{ route('front.products.fabric', ['fabric' => 'silk']) }}" class="mega-card"><img src="{{ asset('images/sarees/1.webp') }}" alt="Silk"><span>Silk</span></a>
                  <a href="{{ route('front.products.fabric', ['fabric' => 'cotton']) }}" class="mega-card"><img src="{{ asset('images/sarees/3.webp') }}" alt="Cotton"><span>Cotton</span></a>
                  <a href="{{ route('front.products.fabric', ['fabric' => 'georgette']) }}" class="mega-card"><img src="{{ asset('images/sarees/5.webp') }}" alt="Georgette"><span>Georgette</span></a>
                  <a href="{{ route('front.products.fabric', ['fabric' => 'organza']) }}" class="mega-card"><img src="{{ asset('images/sarees-sync/6.webp') }}" alt="Organza"><span>Organza</span></a>
                </div>
                <div class="mega-panel" data-mega-panel="occasion">
                  <a href="{{ route('front.products.occasion', ['occasion' => 'wedding']) }}" class="mega-card"><img src="{{ asset('images/sarees/2.webp') }}" alt="Wedding"><span>Wedding</span></a>
                  <a href="{{ route('front.products.occasion', ['occasion' => 'festive']) }}" class="mega-card"><img src="{{ asset('images/sarees/4.webp') }}" alt="Festive"><span>Festive</span></a>
                  <a href="{{ route('front.products.occasion', ['occasion' => 'daily-wear']) }}" class="mega-card"><img src="{{ asset('images/sarees/5.webp') }}" alt="Daily Wear"><span>Daily Wear</span></a>
                  <a href="{{ route('front.products.occasion', ['occasion' => 'party']) }}" class="mega-card"><img src="{{ asset('images/sarees-sync/6.webp') }}" alt="Party"><span>Party</span></a>
                </div>
                <div class="mega-panel" data-mega-panel="color">
                  <a href="{{ route('front.products.color', ['color' => 'pastel']) }}" class="mega-card"><img src="{{ asset('images/sarees/1.webp') }}" alt="Pastel"><span>Pastel Edit</span></a>
                  <a href="{{ route('front.products.color', ['color' => 'bold']) }}" class="mega-card"><img src="{{ asset('images/sarees/2.webp') }}" alt="Bold"><span>Bold Tones</span></a>
                  <a href="{{ route('front.products.color', ['color' => 'neutrals']) }}" class="mega-card"><img src="{{ asset('images/sarees/3.webp') }}" alt="Neutrals"><span>Neutrals</span></a>
                  <a href="{{ route('front.products.color', ['color' => 'vibrant']) }}" class="mega-card"><img src="{{ asset('images/sarees/4.webp') }}" alt="Vibrant"><span>Vibrant</span></a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="group relative" data-mega-menu data-default-tab="jewellery">
          <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="nav-item-link rounded-sm">JEWELLERY</a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 mega-menu-panel shadow-2xl hidden group-hover:block z-[120] border border-pastel-pink/40">
            <div class="grid grid-cols-[190px_1fr]">
              <div class="border-r border-pastel-pink/40 bg-[#fdeff5]">
                <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="mega-tab" data-mega-tab="jewellery">Jewellery</a>
                <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="mega-tab" data-mega-tab="collection">Collection</a>
              </div>
              <div class="p-3">
                <div class="mega-panel" data-mega-panel="jewellery">
                  <a href="{{ route('front.jewellery.collection.show', ['slug' => 'anti-tarnish']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Viraasat Floral Necklace Set/AVN-JW-NEC-EMG-C56/AVN-JW-NEC-EMG-C56-02.png') }}" alt="Anti Tarnish"><span>Anti Tarnish</span></a>
                  <a href="{{ route('front.jewellery.collection.show', ['slug' => 'korean']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Viraasat Floral Necklace Set/AVN-JW-NEC-RRD-C57/AVN-JW-NEC-RRD-C57-02.png') }}" alt="Korean"><span>Korean</span></a>
                  <a href="{{ route('front.jewellery.collection.show', ['slug' => 'temple-traditional']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-MAN-C54/AVN-JW-HAN-MAN-C54-01.png') }}" alt="Temple"><span>Temple/Traditional</span></a>
                  <a href="{{ route('front.jewellery.collection.show', ['slug' => 'meenakari']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-STR-C53/AVN-JW-HAN-STR-C53-01.png') }}" alt="Meenakari"><span>Meenakari</span></a>
                  <a href="{{ route('front.jewellery.collection.show', ['slug' => 'kundan']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-PIN-C47/AVN-JW-HAN-PIN-C47-01.png') }}" alt="Kundan"><span>Kundan</span></a>
                </div>
                <div class="mega-panel" data-mega-panel="collection">
                  <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery', 'collection' => 'hand-made']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-FLA-C45/AVN-JW-HAN-FLA-C45-01.png') }}" alt="Hand Made"><span>Hand Made Jewellery</span></a>
                  <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery', 'collection' => 'oxidised']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-SHL-C52/AVN-JW-HAN-SHL-C52-01.png') }}" alt="Oxidized"><span>Oxidized Jewellery</span></a>
                  <a href="{{ route('front.products.index', ['category' => 'jewellery-gallery', 'collection' => 'cultural']) }}" class="mega-card"><img src="{{ asset('images/jewellery/Avnee_s Handmade  Statement Earrings/AVN-JW-HAN-BUT-C51/AVN-JW-HAN-BUT-C51-01.png') }}" alt="Cultural"><span>Cultural Jewellery</span></a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li><a href="{{ route('front.products.index', ['category' => 'accessories']) }}" class="nav-item-link rounded-sm">ACCESSORIES</a></li>
        <li><a href="{{ route('front.products.index', ['category' => 'fun-trinkets']) }}" class="nav-item-link rounded-sm">FUN TRINKETS</a></li>
      </ul>
    </div>
  </nav>

  <main class="flex-grow min-h-screen">
    @yield("content")
  </main>
  <!-- ═══════════════════════════════════════════════ -->
  <!-- FOOTER                                         -->
  <!-- ═══════════════════════════════════════════════ -->
  <footer class="bg-mulberry text-pastel-pink pt-0 pb-4" style="border-top: 3px solid #F8C8DC;">
    <!-- Decorative gold top bar -->
    <div class="w-full h-[3px] bg-gradient-to-r from-transparent via-pastel-pink to-transparent"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Top Grid: 4 Columns -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-8 pt-10">

        <div class="pr-0 lg:pr-6">
          <h4 class="footer-heading text-pastel-pink font-semibold tracking-[0.12em] uppercase text-[17px]">About our brand</h4>
          <p class="text-pastel-pink/70 text-[18px] leading-[1.8] mb-4">
            AVNEE Collections is a thoughtfully curated space for kidswear and everyday jewelry - created with love, comfort, and style in mind.
          </p>
          <p class="text-[#b9ada3] text-[16px] leading-[1.8] mb-6">
            Inspired by little moments and the joy of dressing up, we bring together pieces that celebrate both childhood and the woman behind it - simple, elegant, and made to feel special every day.
          </p>

          <!-- Social Icons -->
          <div class="flex items-center gap-3">
            @if(!empty($settings['facebook_url']))
            <a href="{{ $settings['facebook_url'] }}" target="_blank" title="Facebook"
              class="w-8 h-8 rounded-full border border-pastel-pink/30 flex items-center justify-center text-pastel-pink hover:bg-pastel-pink hover:border-pastel-pink hover:text-mulberry transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['instagram_url']))
            <a href="{{ $settings['instagram_url'] }}" target="_blank" title="Instagram"
              class="w-8 h-8 rounded-full border border-pastel-pink/30 flex items-center justify-center text-pastel-pink hover:bg-pastel-pink hover:border-pastel-pink hover:text-mulberry transition-colors duration-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
              </svg>
            </a>
            @endif

            @if(!empty($settings['twitter_url']))
            <a href="{{ $settings['twitter_url'] }}" target="_blank" title="Twitter / X"
              class="w-8 h-8 rounded-full border border-pastel-pink/30 flex items-center justify-center text-pastel-pink hover:bg-pastel-pink hover:border-pastel-pink hover:text-mulberry transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['youtube_url']))
            <a href="{{ $settings['youtube_url'] }}" target="_blank" title="YouTube"
              class="w-8 h-8 rounded-full border border-pastel-pink/30 flex items-center justify-center text-pastel-pink hover:bg-pastel-pink hover:border-pastel-pink hover:text-mulberry transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.54 6.42a2.78 2.78 0 00-1.94-1.98C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 1.98C0 8.18 0 12 0 12s0 3.82.46 5.58a2.78 2.78 0 001.94 1.98C4.12 20 11.96 20 11.96 20s6.88 0 8.6-.46a2.78 2.78 0 001.94-1.98C24 15.82 24 12 24 12s0-3.82-.46-5.58zM9.54 15.55V8.45l6.76 3.55-6.76 3.55z"></path>
              </svg>
            </a>
            @endif

            @if(!empty($settings['whatsapp_number']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) }}" target="_blank" title="WhatsApp"
              class="w-8 h-8 rounded-full border border-pastel-pink/30 flex items-center justify-center text-pastel-pink hover:bg-pastel-pink hover:border-pastel-pink hover:text-mulberry transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.998 2C6.477 2 2 6.477 2 12c0 1.821.491 3.53 1.346 5.003L2.007 22l5.116-1.34A9.959 9.959 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 11.998 2z"/>
              </svg>
            </a>
            @endif
          </div>
        </div>

        <!-- Column 2: Shop -->
        <div>
          <h4 class="footer-heading text-pastel-pink font-semibold tracking-[0.12em] uppercase text-[15px]">Shop</h4>
          <ul class="space-y-3.5">
            <li><a href="{{ route('front.products.index', ['category' => 'kids']) }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Kids Collection</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'jewellery-gallery']) }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Jewellery</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'sarees']) }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Sarees</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'fun-trinkets']) }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Funky Trinkets</a></li>
            <li><a href="{{ route('front.products.index', ['category' => 'hair-accessories']) }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Hair Accessories</a></li>
            <li><a href="{{ route('front.products.index') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">All Collections</a></li>
          </ul>
        </div>

        <!-- Column 3: About -->
        <div>
          <h4 class="footer-heading text-pastel-pink font-semibold tracking-[0.12em] uppercase text-[15px]">About</h4>
          <ul class="space-y-3.5">
            <li><a href="{{ route('front.page', 'terms-of-service') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Terms of Service</a></li>
            <li><a href="{{ route('front.page', 'privacy-policy') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Privacy Policy</a></li>
            <li><a href="{{ route('front.page', 'return-exchange-policy') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Returns Policy</a></li>
            <li><a href="{{ route('front.page', 'shipping-policy') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Shipping Policy</a></li>
            <li><a href="{{ route('front.page', 'faqs') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">FAQ's</a></li>
            <li><a href="{{ route('front.contact') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Contact Us</a></li>
            <li><a href="{{ route('front.careers') }}" class="text-pastel-pink/75 text-[15px] hover:text-pastel-pink transition-colors">Careers</a></li>
          </ul>
        </div>

        <!-- Column 4: Newsletter -->
        <div>
          <h4 class="footer-heading text-pastel-pink font-semibold tracking-[0.12em] uppercase text-[15px]">Newsletter</h4>
          <div class="footer-newsletter border-pastel-pink/20 bg-top-bar-dark/40">
            <p class="text-pastel-pink/75 text-[15px] leading-7 mb-5">
              Subscribe to get notified about product launches, special offers and company news.
            </p>
            <form id="studio-newsletter-form" class="flex flex-col gap-3">
              @csrf
              <input type="email" name="email" id="studio-newsletter-email" placeholder="Your email address" required
                class="bg-white/5 border border-pastel-pink/20 text-pastel-pink text-[15px] px-4 py-3 focus:outline-none focus:border-pastel-pink transition-colors placeholder-pastel-pink/50" />
              <button type="submit"
                class="bg-pastel-pink hover:bg-white text-mulberry text-[13px] font-bold tracking-[0.18em] uppercase px-6 py-3.5 transition-colors w-full">
                SUBSCRIBE
              </button>
              <p id="studio-newsletter-msg" class="text-sm text-green-300 hidden">✓ Thanks for subscribing!</p>
            </form>
            <div class="mt-5 pt-4 border-t border-pastel-pink/20 text-[14px] text-pastel-pink/85 space-y-2">
              <p><span class="font-semibold">Call Us:</span> <a href="tel:+91908671144" class="hover:text-pastel-pink">+91 908671144</a></p>
              <p><span class="font-semibold">Mail:</span> <a href="mailto:studio@avneecollections.com" class="hover:text-pastel-pink">studio@avneecollections.com</a></p>
              <p><span class="font-semibold">Alt Mail:</span> <a href="mailto:avnee.collections@gmail.com" class="hover:text-pastel-pink">avnee.collections@gmail.com</a></p>
              <p><span class="font-semibold">WhatsApp:</span> <a href="https://wa.me/91908671144" target="_blank" class="hover:text-pastel-pink">+91 908671144</a></p>
            </div>
          </div>
        </div>

      </div>

      <!-- Bottom Frame -->
      <div class="pt-8 border-t border-[#2a2218] flex flex-col md:flex-row items-center justify-between gap-6">

        <!-- Left: Copyright and Dropdown -->
        <div
          class="flex items-center gap-4 text-[#b9ada3] text-[14px] w-full md:w-auto justify-center md:justify-start">
          <!-- Globe icon button mock -->
          <button class="flex items-center gap-1 hover:text-[#d4a96a] transition-colors">
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
        <div class="flex items-center gap-2">
          <!-- Mocking the payment method badges -->
          <div class="bg-white rounded-[2px] w-[34px] h-[22px] flex items-center justify-center">
            <span class="text-[9px] font-bold text-[#1434CB]">VISA</span>
          </div>
          <div class="bg-white rounded-[2px] w-[34px] h-[22px] flex items-center justify-center">
            <div class="flex -space-x-1 opacity-90">
              <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
              <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
            </div>
          </div>
          <div class="bg-white rounded-[2px] w-[34px] h-[22px] flex items-center justify-center">
            <span class="text-[7.5px] font-bold text-[#0070BA] italic leading-none text-center">AM<br />EX</span>
          </div>
          <div class="bg-white rounded-[2px] w-[34px] h-[22px] flex items-center justify-center">
            <span class="text-[9px] font-bold text-[#f2a900]">a</span>
          </div>
          <div class="bg-white rounded-[2px] w-[34px] h-[22px] flex items-center justify-center">
            <span class="text-[9px] font-bold text-[#003087] italic">PayPal</span>
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
    class="fixed top-0 left-0 h-full w-72 bg-[#F8C8DC] z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out">
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


      <!-- Mobile Nav Links -->
      <nav class="space-y-1">
        <p class="text-[10px] font-semibold tracking-widest text-gray-400 uppercase mb-3">Shop</p>
        <a href="{{ route('front.products.index') }}"
          class="block text-sm font-semibold tracking-wider uppercase py-2.5 border-b border-gray-100 text-icon-dark hover:text-brand-gold transition-colors duration-200">
          All Collections
        </a>
        @foreach($categories as $category)
        <a href="{{ route('front.products.index', ['category' => $category->slug]) }}"
          class="block text-sm font-semibold tracking-wider uppercase py-2.5 border-b border-gray-100 text-icon-dark hover:text-brand-gold transition-colors duration-200">
          {{ $category->name }}
        </a>
        @endforeach
        <div class="pt-4 space-y-3 text-xs text-gray-600">
          <p class="text-[10px] font-semibold tracking-widest text-gray-400 uppercase">Quick Links</p>
          <p><strong>Damage/Tamper Cases:</strong> Please keep a 360° unboxing video. Contact support immediately for damaged/tampered packages.</p>
          <p><strong>Address Accuracy:</strong> Please ensure address/contact details are correct to avoid failed deliveries.</p>
          <p><strong>International:</strong> Customs/import duties, if any, are customer responsibility.</p>
        </div>
      </nav>
    </div>
  </div>

  <script>
    const policyDocs = {
      faq: {
        title: 'Frequently Asked Questions',
        html: `
          <p><strong>What is Avnee Collections?</strong><br>Avnee Collections is a curated kidswear and lifestyle brand with jewellery, sarees, accessories, and trinkets.</p>
          <p><strong>How do I choose size?</strong><br>Use the size chart on each product page. Returns are not accepted for size-related issues.</p>
          <p><strong>How long does delivery take?</strong><br>Metro: 2-4 days. Other locations: 3-6 days.</p>
          <p><strong>Do you offer COD?</strong><br>Yes, in selected locations, up to ₹10,000.</p>
          <p><strong>What is your return policy?</strong><br>Returns only for damaged/incorrect/defective items within 3 days with mandatory 360° unboxing video.</p>
          <p><strong>Can I cancel my order?</strong><br>Only before dispatch.</p>
          <p><strong>Payment methods?</strong><br>UPI, Debit/Credit Cards, Net Banking, and COD.</p>
          <p><strong>How to contact support?</strong><br>studio@avneecollections.com, avnee.collections@gmail.com, +91 908671144.</p>
        `
      }
    };

    function openPolicyModal(key) {
      const modal = document.getElementById('policy-modal');
      const title = document.getElementById('policy-modal-title');
      const content = document.getElementById('policy-modal-content');
      const item = policyDocs[key];
      if (!modal || !title || !content || !item) return;

      title.textContent = item.title;
      content.innerHTML = item.html;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function closePolicyModal() {
      const modal = document.getElementById('policy-modal');
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = '';
    }

    document.getElementById('policy-modal')?.addEventListener('click', function (event) {
      if (event.target.id === 'policy-modal') {
        closePolicyModal();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closePolicyModal();
      }
    });
  </script>

  <!-- Swiper JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Home pages with custom section scripts set this marker and own initialization.
      if (window.__AVNEE_CUSTOM_SWIPERS__ === true) {
        return;
      }

      if (typeof window.Swiper === 'undefined') {
        console.warn('Swiper bundle did not load; skipping studio carousel initialization.');
        return;
      }

      const initSwiper = (selector, options, fallbackSlidesPerView = 1) => {
        const root = document.querySelector(selector);
        if (!root) return null;

        const slides = root.querySelectorAll('.swiper-slide').length;
        const config = { ...options };
        if (config.loop) {
          config.loop = slides > fallbackSlidesPerView;
        }

        if (root.swiper) {
          root.swiper.destroy(true, true);
        }

        return new window.Swiper(selector, config);
      };

      initSwiper('.hero-swiper', {
        loop: true,
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
      }, 1);

      initSwiper('.best-buys-swiper', {
        loop: true,
        speed: 600,
        spaceBetween: 16,
        slidesPerView: 2,
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
      }, 4);

      initSwiper('.bestsell-swiper', {
        loop: true,
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
      }, 5);

      initSwiper('.stories-swiper', {
        loop: true,
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
      }, 2);

      initSwiper('.look-swiper', {
        loop: true,
        speed: 800,
        centeredSlides: false,
        grabCursor: true,
        slidesPerView: 1,
        spaceBetween: 12,
        loopAdditionalSlides: 5,
        watchSlidesProgress: true,
        navigation: {
          prevEl: '#look-prev',
          nextEl: '#look-next',
        },
        breakpoints: {
          320: { slidesPerView: 1, centeredSlides: false, spaceBetween: 12 },
          480: { slidesPerView: 1, centeredSlides: false, spaceBetween: 14 },
          768: { slidesPerView: 5, centeredSlides: true, spaceBetween: -35 },
          1024: { slidesPerView: 5, centeredSlides: true, spaceBetween: -55 },
          1280: { slidesPerView: 5, centeredSlides: true, spaceBetween: -85 },
        },
      }, 5);
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
    });
  </script>

  <!-- Combo Selection Modal -->
  <div id="combo-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-white dark:bg-[#1a1a1a] w-full max-w-2xl rounded-sm shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
          <div class="flex justify-between items-center p-6 border-b dark:border-gray-800">
              <h3 id="combo-modal-title" class="font-heading text-xl uppercase tracking-widest text-gray-900 dark:text-white">Customize Your Bundle</h3>
              <button onclick="closeComboModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                  <span class="material-symbols-outlined">close</span>
              </button>
          </div>
          <div id="combo-modal-content" class="p-6 max-h-[70vh] overflow-y-auto">
              <!-- Loading State -->
              <div id="combo-loading" class="flex flex-col items-center py-12">
                  <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#b87333]"></div>
                  <p class="mt-4 text-xs text-gray-500 uppercase tracking-widest">Loading Items...</p>
              </div>
              <!-- Products List -->
              <form id="combo-selection-form" method="POST" class="hidden space-y-8">
                  @csrf
                  <div id="combo-products-list" class="space-y-6"></div>
                  <div class="pt-6 border-t dark:border-gray-800 flex items-center justify-between">
                      <div class="text-left">
                          <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">BUNDLE TOTAL</p>
                          <p id="combo-modal-price" class="text-xl font-bold text-[#b87333]"></p>
                      </div>
                      <button type="submit" class="bg-black text-white px-10 py-3 text-xs font-bold uppercase tracking-[0.2em] hover:bg-[#b87333] transition-all rounded-sm">
                          Add Bundle to Cart
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <script>
    function openComboModal(comboId, price) {
        const modal = document.getElementById('combo-modal');
        const loading = document.getElementById('combo-loading');
        const form = document.getElementById('combo-selection-form');
        const list = document.getElementById('combo-products-list');
        const titleEl = document.getElementById('combo-modal-title');
        const priceEl = document.getElementById('combo-modal-price');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        loading.classList.remove('hidden');
        form.classList.add('hidden');
        list.innerHTML = '';
        priceEl.textContent = '₹' + price;

        fetch(`/cart/combo/${comboId}/details`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Combo data received:', data);
                titleEl.textContent = data.title;
                form.action = `/cart/combo/${comboId}`;

                data.products.forEach(product => {
                    const prodDiv = document.createElement('div');
                    prodDiv.className = 'flex gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-sm';

                    let variantsHtml = '';
                    if (product.variants.length > 0) {
                        variantsHtml = `
                            <div class="mt-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Select Size</p>
                                <div class="flex flex-wrap gap-2">
                                    ${product.variants.map(v => `
                                        <label class="cursor-pointer">
                                            <input type="radio" name="variants[${product.id}]" value="${v.id}" class="peer sr-only" required>
                                            <div class="px-3 py-1 text-xs border border-gray-200 dark:border-gray-700 rounded-sm peer-checked:border-[#b87333] peer-checked:text-[#b87333] hover:border-gray-400 transition-all">
                                                ${v.size}
                                            </div>
                                        </label>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    } else {
                        variantsHtml = `<p class="mt-3 text-[10px] text-gray-400 italic">No variants available (One Size)</p>`;
                    }

                    prodDiv.innerHTML = `
                        <img src="${product.image}" class="w-20 h-24 object-cover rounded-sm border border-gray-200 dark:border-gray-800">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold uppercase tracking-tight text-gray-900 dark:text-gray-100">${product.name}</h4>
                            ${variantsHtml}
                        </div>
                    `;
                    list.appendChild(prodDiv);
                });

                loading.classList.add('hidden');
                form.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error loading combo details:', error);
                alert('Unable to load combo details. Please try again.');
                loading.classList.add('hidden');
            });
    }

    function closeComboModal() {
        const modal = document.getElementById('combo-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
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

            // Only prevent default for wishlist buttons, allow normal link navigation
            if (btn) {
                e.preventDefault();
                const productId = btn.getAttribute('data-product-id');
                const icon = btn.querySelector('.wishlist-icon');

                if (!productId) return;

                // Simple simple feedback
                btn.style.opacity = '0.5';
                btn.style.pointerEvents = 'none';

                fetch("{{ route('front.wishlist.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
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
            }
        });

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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const desktopSearch = document.getElementById('search-input');
      const mobileSearch = document.getElementById('mobile-search-input');
      const placeholders = [
        'Search for Girls Collection...',
        'Search for Sarees...',
        'Search for Jewelry...',
        'Search for Trinkets...'
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
        const form = document.getElementById('studio-newsletter-form');
        if (!form) return;
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('studio-newsletter-email').value;
            const btn = form.querySelector('button[type="submit"]');
            const msg = document.getElementById('studio-newsletter-msg');
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
                form.querySelector('input').value = '';
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
</body>

</html>
