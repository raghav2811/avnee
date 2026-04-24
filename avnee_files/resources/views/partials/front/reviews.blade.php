@if(isset($reviews) && $reviews->count() > 0)
@php
    $isJewellery = request()->is('jewellery*') || (isset($theme) && $theme === 'jewellery');
    $bgColor = $isJewellery ? 'bg-[#2B003A]' : 'bg-[#F8C8DC]';
    $accentColor = $isJewellery ? 'text-[#d4af37]' : 'text-mulberry';
    $headingColor = $isJewellery ? 'text-[#f3d9ff]' : 'text-gray-900';
    $subtitleColor = $isJewellery ? 'text-[#e9d5ff]/70' : 'text-mulberry/70';
    $captionColor = $isJewellery ? 'text-[#e9d5ff]/50' : 'text-gray-500';
    $cardBg = $isJewellery ? 'bg-[#350047]/20 border-white/5' : 'bg-white border-mulberry/5';
    $primaryNavColor = $isJewellery ? '#d4af37' : '#770737';
    $displayReviews = $reviews->take(9);
    $storyImageMap = [
        'aishwarya rao' => asset('images/customer-stories/aishwarya-rao.png'),
        'divya menon' => asset('images/customer-stories/divya-menon.png'),
        'kavya nair' => asset('images/customer-stories/kavya-nair.png'),
        'latha iyer' => asset('images/customer-stories/latha-iyer.png'),
        'meena sharma' => asset('images/customer-stories/meena-sharma.png'),
        'pooja verma' => asset('images/customer-stories/pooja-verma.png'),
        'priya patel' => asset('images/customer-stories/priya-patel.png'),
        'riya mehta' => asset('images/customer-stories/riya-mehta.png'),
        'sneha reddy' => asset('images/customer-stories/sneha-reddy.png'),
    ];
    $storyImageFallbacks = array_values($storyImageMap);
@endphp

<section id="customer-stories" class="py-16 sm:py-24 {{ $bgColor }} relative overflow-hidden transition-colors duration-700">
    <!-- Decorative Sparkles -->
    <div class="absolute top-20 left-[10%] {{ $accentColor }} opacity-10 animate-pulse">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
    </div>
    <div class="absolute top-40 right-[8%] {{ $accentColor }} opacity-10 animate-bounce delay-700">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
    </div>
    <div class="absolute bottom-20 left-[5%] {{ $accentColor }} opacity-5">
        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
    </div>

    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 sm:mb-20">
            @if($isJewellery)
            <h3 class="{{ $accentColor }} font-logo text-2xl sm:text-3xl uppercase tracking-[0.4em] mb-4">Customer Stories</h3>
            <h2 class="font-heading text-3xl sm:text-[2.6rem] font-normal {{ $headingColor }} mb-12 tracking-[0.2em] uppercase decoration-[#f3d9ff]/30 underline underline-offset-[12px]">
                Cherished Moments...
            </h2>
            @else
            <h2 class="studio-section-heading mb-6 sm:mb-10">Customer Stories</h2>
            <p class="font-heading text-2xl sm:text-4xl text-mulberry/90 font-normal tracking-[0.12em] mb-10 max-w-2xl mx-auto leading-snug">Loved by Little Princesses...</p>
            @endif
            <div class="max-w-2xl mx-auto space-y-4">
                <p class="{{ $subtitleColor }} text-base sm:text-lg leading-relaxed uppercase tracking-wider font-bold">
                    {{ $isJewellery ? 'Explore why customers choose AVNEE for timeless elegance.' : 'Explore why parents love Avnee Collection for their little ones.' }}
                </p>
                <p class="{{ $captionColor }} text-sm sm:text-base leading-relaxed tracking-wide font-medium">
                    {{ $isJewellery ? 'Authentic stories from our valued customers who found their perfect sparkle.' : 'Heartwarming stories from real customers who chose our curated selection for girls aged 0-12 years.' }}
                </p>
            </div>
        </div>

        <div class="relative group px-2 sm:px-12">
            <!-- Custom Navigation Arrows -->
            <button id="stories-prev" class="absolute -left-2 sm:left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center {{ $accentColor }} hover:scale-125 transition-transform">
                <svg class="w-11 h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button id="stories-next" class="absolute -right-2 sm:right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center {{ $accentColor }} hover:scale-125 transition-transform">
                <svg class="w-11 h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7" /></svg>
            </button>

            <!-- Swiper Container -->
            <div class="swiper stories-swiper overflow-hidden pb-10">
                <div class="swiper-wrapper items-stretch">
                    @foreach($displayReviews as $review)
                    @php
                        $reviewNameKey = strtolower(trim((string) ($review->user_name ?? $review->user?->name ?? '')));
                        $storyImage = $storyImageMap[$reviewNameKey] ?? $storyImageFallbacks[$loop->index % count($storyImageFallbacks)];
                    @endphp
                    <div class="swiper-slide h-auto self-stretch">
                        <div class="{{ $cardBg }} rounded-sm overflow-hidden flex flex-col h-full shadow-[0_20px_50px_rgba(0,0,0,0.05)] border group/card hover:shadow-2xl transition-all duration-700 backdrop-blur-sm">
                            <!-- Customer Image -->
                            <div class="relative aspect-[4/3] overflow-hidden {{ $isJewellery ? 'bg-[#1a0023]' : 'bg-[#fef5f7]' }}">
                                <img src="{{ $storyImage }}" alt="{{ $review->user_name ?? $review->user?->name ?? 'AVNEE Customer' }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover/card:scale-110" />
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/20 opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                            </div>

                            <!-- Review Content -->
                            <div class="p-8 sm:p-10 flex flex-col items-center text-center flex-1">
                                <p class="{{ $isJewellery ? 'text-[#e9d5ff]/90' : 'text-gray-700' }} text-base sm:text-lg leading-relaxed italic mb-8 flex-1 font-medium tracking-tight px-2 min-h-[120px]">
                                    {{ $review->comment }}
                                </p>

                                <div class="space-y-1.5 mb-8">
                                    <h4 class="{{ $accentColor }} font-bold text-xl tracking-tight uppercase leading-tight">{{ $review->user_name ?? $review->user?->name ?? 'AVNEE Customer' }}</h4>
                                    <p class="text-xs {{ $isJewellery ? 'text-[#e9d5ff]/40' : 'text-gray-400' }} font-bold uppercase tracking-[0.2em]">{{ $review->location ?? 'AVNEE Customer' }}</p>
                                </div>

                                @if($review->product)
                                <a href="{{ route('front.product.detail', $review->product->slug) }}" class="inline-block text-xs font-black uppercase tracking-[0.3em] {{ $isJewellery ? 'text-[#1a0023] bg-[#d4af37] hover:bg-white' : 'text-mulberry bg-mulberry/5 hover:bg-mulberry hover:text-white' }} px-6 py-2.5 rounded-sm transition-all">
                                    View Product
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Navigation Sync -->
            <div class="flex justify-center gap-16 mt-12 sm:hidden relative z-20">
                <button id="m-stories-prev" class="{{ $accentColor }} p-2"><svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" /></svg></button>
                <button id="m-stories-next" class="{{ $accentColor }} p-2"><svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" /></svg></button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            const reviewCount = {{ $displayReviews->count() }};
            new Swiper('.stories-swiper', {
                slidesPerView: 1,
                spaceBetween: 16,
                centeredSlides: false,
                loop: reviewCount > 3,
                watchOverflow: true,
                autoplay: { delay: 6000, disableOnInteraction: false },
                navigation: {
                    nextEl: '#stories-next, #m-stories-next',
                    prevEl: '#stories-prev, #m-stories-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 18 },
                    768: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, slidesPerGroup: 3, spaceBetween: 24 }
                }
            });
        }
    });
</script>
@endpush
@endif
