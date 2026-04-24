@extends('layouts.front.studio')

@section('title', 'Sale')

@section('content')
<section class="py-10 sm:py-14 bg-[#FCEFF5] min-h-[70vh]">
  <div class="max-w-[1360px] mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 sm:mb-10 flex items-end justify-between gap-4">
      <div>
        <h1 class="font-heading text-3xl sm:text-5xl text-[#2B003A]">Sale</h1>
        <p class="text-sm sm:text-base text-[#5d2d47] mt-2">Curated dresses from our collection.</p>
      </div>
      <span class="hidden sm:inline-flex bg-[#2B003A] text-white text-xs font-bold tracking-[0.2em] px-3 py-2 uppercase">No Return No Exchange</span>
    </div>

    @if($saleProducts->isNotEmpty())
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
        @foreach($saleProducts as $product)
          <div class="group relative flex flex-col">
            <a href="{{ route('front.product.detail', $product->slug ?? $product->id) }}" class="relative block overflow-hidden bg-white aspect-[3/4] border border-[#e7ccd9] rounded-lg">
              <img src="{{ $product->image ? asset('storage/' . ltrim($product->image, '/')) : asset('images/shop-by-style/girls-dresses.png') }}"
                   alt="{{ $product->name }}"
                   class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" />

              <div class="absolute top-2 right-2 inline-flex items-center overflow-hidden rounded-sm shadow-md">
                <span class="bg-[#8f0d45] text-white text-[9px] font-black uppercase tracking-[0.12em] px-2 py-1">Sale</span>
                <span class="bg-[#2f3133] text-white text-[9px] font-bold uppercase tracking-[0.08em] px-2 py-1">No Return No Exchange</span>
              </div>
            </a>

            <div class="pt-4">
              <h3 class="text-sm font-semibold text-[#2B003A] leading-snug line-clamp-2 uppercase">{{ $product->name }}</h3>
              <div class="flex items-baseline gap-2 mt-1">
                <span class="text-base font-bold text-[#2B003A]">₹{{ number_format((float) $product->price, 0) }}</span>
                @if((float) $product->compare_price > (float) $product->price)
                  <span class="text-xs text-[#7f5a70] line-through">₹{{ number_format((float) $product->compare_price, 0) }}</span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @elseif(!empty($saleFallbackCards))
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
        @foreach($saleFallbackCards as $card)
          <div class="group relative flex flex-col">
            <a href="{{ route('front.products.index', ['collection' => 'sale']) }}" class="relative block overflow-hidden bg-white aspect-[3/4] border border-[#e7ccd9] rounded-lg">
              <img src="{{ $card['image'] }}"
                   alt="{{ $card['title'] }}"
                   class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" />

              <div class="absolute top-2 right-2 inline-flex items-center overflow-hidden rounded-sm shadow-md">
                <span class="bg-[#8f0d45] text-white text-[9px] font-black uppercase tracking-[0.12em] px-2 py-1">Sale</span>
                <span class="bg-[#2f3133] text-white text-[9px] font-bold uppercase tracking-[0.08em] px-2 py-1">No Return No Exchange</span>
              </div>
            </a>

            <div class="pt-4">
              <h3 class="text-sm font-semibold text-[#2B003A] leading-snug line-clamp-2 uppercase">{{ $card['title'] }}</h3>
              <p class="text-xs text-[#7f5a70] mt-1">{{ $card['label'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="bg-white border border-[#e7ccd9] rounded-xl p-10 text-center text-[#5d2d47]">
        No sale products available right now.
      </div>
    @endif
  </div>
</section>
@endsection
