@php
    $isJewellery = ($theme ?? session('theme', 'studio')) === 'jewellery';
@endphp

<section class="mt-14 mb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-[1320px] mx-auto {{ $isJewellery ? 'bg-[#3b1a63] border-[#a47dab]/35' : 'bg-[#efedf0] border-[#e2dde2]' }} border px-4 sm:px-6 lg:px-10 py-8 sm:py-10 lg:py-12">
        <h2 class="text-center font-heading text-3xl sm:text-4xl lg:text-5xl leading-tight {{ $isJewellery ? 'text-[#c7a4cc]' : 'text-[#2f2725]' }} mb-6 sm:mb-8">Explore More</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4">
            <a href="{{ $isJewellery ? route('front.products.index', ['category' => 'jewellery-gallery']) : route('front.products.index', ['category' => 'party-frocks']) }}" class="lg:col-span-6 {{ $isJewellery ? 'bg-[#44206f]' : 'bg-white' }} relative min-h-[230px] sm:min-h-[260px] overflow-hidden group">
                <img src="{{ $isJewellery ? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?auto=format&fit=crop&w=1400&q=80' : 'https://images.unsplash.com/photo-1519340241574-2cec6aef0c01?auto=format&fit=crop&w=1400&q=80' }}" alt="{{ $isJewellery ? 'Jewellery Edit' : 'Party Edit' }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/75 to-transparent"></div>
                <div class="relative z-10 p-6 sm:p-8 max-w-[66%]">
                    <h3 class="font-heading text-2xl sm:text-3xl lg:text-4xl leading-[1.06] text-[#312725]">{{ $isJewellery ? 'Jewellery Edit' : 'Party Frocks Edit' }}</h3>
                    <p class="mt-2 text-sm sm:text-base lg:text-lg leading-snug text-[#3d322f]">{{ $isJewellery ? 'All That Jewels You Must Own' : 'Statement looks for birthdays & celebrations' }}</p>
                    <p class="mt-5 text-base sm:text-lg lg:text-xl font-medium text-[#231b19]">Shop Now</p>
                </div>
            </a>

            <a href="{{ $isJewellery ? route('front.products.index', ['category' => 'earrings']) : route('front.products.index', ['category' => 'festive-wear']) }}" class="lg:col-span-6 {{ $isJewellery ? 'bg-[#44206f]' : 'bg-white' }} relative min-h-[230px] sm:min-h-[260px] overflow-hidden group">
                <img src="{{ $isJewellery ? 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1400&q=80' : 'https://images.unsplash.com/photo-1518831959646-742c3a14ebf7?auto=format&fit=crop&w=1400&q=80' }}" alt="{{ $isJewellery ? 'Earrings Edit' : 'Festive Edit' }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/75 to-transparent"></div>
                <div class="relative z-10 p-6 sm:p-8 max-w-[66%]">
                    <h3 class="font-heading text-2xl sm:text-3xl lg:text-4xl leading-[1.06] text-[#312725]">{{ $isJewellery ? 'Earrings Edit' : 'Festive Edit' }}</h3>
                    <p class="mt-2 text-sm sm:text-base lg:text-lg leading-snug text-[#3d322f]">{{ $isJewellery ? 'Jhumkas | Chandbalis | Studs' : 'Traditional sets for every festive moment' }}</p>
                    <p class="mt-5 text-base sm:text-lg lg:text-xl font-medium text-[#231b19]">Shop Now</p>
                </div>
            </a>

            <a href="{{ $isJewellery ? route('front.products.index', ['category' => 'organizers']) : route('front.products.index', ['category' => 'girls-dresses']) }}" class="lg:col-span-3 {{ $isJewellery ? 'bg-[#44206f]' : 'bg-white' }} relative min-h-[220px] sm:min-h-[250px] overflow-hidden group">
                <img src="{{ $isJewellery ? 'https://images.unsplash.com/photo-1579022273876-132b63f7f5cb?auto=format&fit=crop&w=900&q=80' : 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $isJewellery ? 'Organizers Edit' : 'Girls Dresses Edit' }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-white/95 via-white/55 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                    <h3 class="font-heading text-xl sm:text-2xl lg:text-3xl leading-[1.08] text-[#312725]">{{ $isJewellery ? 'Organizers Edit' : 'Girls Dresses Edit' }}</h3>
                    <p class="mt-2 text-sm sm:text-base leading-snug text-[#3d322f]">{{ $isJewellery ? 'Keep Your Precious Jewels Organized' : 'Everyday comfort with elegant detailing' }}</p>
                    <p class="mt-4 text-base sm:text-lg font-medium text-[#231b19]">Shop Now</p>
                </div>
            </a>

            <a href="{{ $isJewellery ? route('front.products.index', ['category' => 'storage']) : route('front.products.index', ['category' => '2-4-years']) }}" class="lg:col-span-3 {{ $isJewellery ? 'bg-[#44206f]' : 'bg-white' }} relative min-h-[220px] sm:min-h-[250px] overflow-hidden group">
                <img src="{{ $isJewellery ? 'https://images.unsplash.com/photo-1598560917807-1bae44a5f6a1?auto=format&fit=crop&w=900&q=80' : 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $isJewellery ? 'Storage Edit' : 'Toddler Edit' }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-white/95 via-white/55 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                    <h3 class="font-heading text-xl sm:text-2xl lg:text-3xl leading-[1.08] text-[#312725]">{{ $isJewellery ? 'Storage Edit' : 'Toddler Edit' }}</h3>
                    <p class="mt-2 text-sm sm:text-base leading-snug text-[#3d322f]">{{ $isJewellery ? 'Shop smart organizers for clean styling space' : 'Special picks for 2-4 years' }}</p>
                    <p class="mt-4 text-base sm:text-lg font-medium text-[#231b19]">Shop Now</p>
                </div>
            </a>

            <a href="{{ $isJewellery ? route('front.products.index', ['category' => 'hair-accessories']) : route('front.products.index', ['category' => 'infant-sets']) }}" class="lg:col-span-6 {{ $isJewellery ? 'bg-[#44206f]' : 'bg-white' }} relative min-h-[230px] sm:min-h-[260px] overflow-hidden group">
                <img src="{{ $isJewellery ? 'https://images.unsplash.com/photo-1563170351-be82bc888aa4?auto=format&fit=crop&w=1400&q=80' : 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?auto=format&fit=crop&w=1400&q=80' }}" alt="{{ $isJewellery ? 'Hair Accessories Edit' : 'Infant Sets Edit' }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/75 to-transparent"></div>
                <div class="relative z-10 p-6 sm:p-8 max-w-[66%]">
                    <h3 class="font-heading text-2xl sm:text-3xl lg:text-5xl leading-[0.98] text-[#312725]">{{ $isJewellery ? 'Hair Accessories Edit' : 'Infant Sets Edit' }}</h3>
                    <p class="mt-3 text-sm sm:text-base lg:text-lg leading-snug text-[#3d322f]">{{ $isJewellery ? 'Elegant pieces to adorn your locks' : 'Soft, playful and occasion-ready baby styles' }}</p>
                    <p class="mt-5 text-base sm:text-lg lg:text-xl font-medium text-[#231b19]">Shop Now</p>
                </div>
            </a>
        </div>
    </div>
</section>
