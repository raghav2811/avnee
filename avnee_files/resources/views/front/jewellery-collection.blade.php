@extends('layouts.front.jewellery')

@section('content')
@php
    $listItems = collect($collection['images'])->map(function ($image, $index) use ($collection) {
        return [
            'name' => $collection['title'] . ' Design ' . ($index + 1),
            'price' => 699 + (($index % 4) * 200),
            'image' => $image,
        ];
    });
@endphp
<section class="py-12 sm:py-16 bg-[#2B003A] min-h-[70vh]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center gap-2 text-[10px] font-bold tracking-[0.24em] uppercase text-[#e9d5ff] overflow-x-auto whitespace-nowrap">
            <a href="{{ route('front.jewellery') }}" class="hover:text-white transition-colors">Home</a>
            <span class="opacity-40">/</span>
            <span class="text-white">{{ $collection['title'] }}</span>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-8">
            <h1 class="font-heading text-3xl sm:text-4xl font-normal tracking-tight text-white uppercase">{{ $collection['title'] }}</h1>
            <p class="text-xs text-[#e9d5ff] font-bold uppercase tracking-widest">{{ $listItems->count() }} Items</p>
        </div>

        <section class="mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 p-4 bg-[#350047] border border-[#4f006a] rounded-lg">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-[#4f006a] text-[#e9d5ff] text-xs font-semibold">Standard</span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-[#4f006a] text-[#e9d5ff] text-xs font-semibold">Free Size</span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-[#4f006a] text-[#e9d5ff] text-xs font-semibold">Delivery Days</span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-[#4f006a] text-[#e9d5ff] text-xs font-semibold">Occasion</span>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-xs text-[#e9d5ff] font-bold uppercase tracking-wide">SORT BY</label>
                <select class="h-9 px-3 rounded-lg border border-[#4f006a] bg-[#1f0028] text-white text-sm font-semibold">
                    <option>Trending</option>
                    <option>Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>
        </section>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <div class="w-full lg:w-[300px] flex-shrink-0">
                <div class="space-y-5 p-5 bg-[#350047] border border-[#4f006a] rounded-lg">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#e9d5ff] mb-3">Select Gallery</label>
                        <div class="max-h-[260px] overflow-y-auto space-y-1.5 pr-1">
                            @foreach(['Earrings', 'Necklace', 'Rings', 'Bangles', 'Necklace Set', 'Belt', 'Maangtikkas'] as $chip)
                                <span class="flex items-center justify-between px-3 py-2 rounded-lg border border-[#4f006a] text-sm font-medium text-[#f3d9ff]">
                                    <span>{{ $chip }}</span>
                                    <span class="text-xs opacity-70">{{ rand(6, 29) }}</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#e9d5ff] mb-3">Available Sizes</label>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex px-3 py-1.5 rounded-lg border text-xs font-semibold border-[#d4af37] text-[#f3d9ff]">All</span>
                            <span class="inline-flex px-3 py-1.5 rounded-lg border text-xs font-semibold border-[#4f006a] text-[#e9d5ff]">Standard</span>
                            <span class="inline-flex px-3 py-1.5 rounded-lg border text-xs font-semibold border-[#4f006a] text-[#e9d5ff]">Free Size</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#e9d5ff] mb-3">Price Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" placeholder="Min" class="w-full text-sm border border-[#4f006a] rounded-lg px-3 py-2 bg-[#1f0028] text-white" />
                            <input type="number" placeholder="Max" class="w-full text-sm border border-[#4f006a] rounded-lg px-3 py-2 bg-[#1f0028] text-white" />
                        </div>
                        <button type="button" class="mt-3 w-full py-2.5 bg-black text-white text-xs font-bold uppercase tracking-[0.2em] hover:bg-[#d4af37] hover:text-[#2B003A] transition-all rounded-lg">Apply Filters</button>
                    </div>
                </div>
            </div>

            <div class="flex-1 min-w-0">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-x-5 gap-y-8">
                    @foreach($listItems as $item)
                        <article class="group relative flex flex-col">
                            <a href="#" class="relative block overflow-hidden bg-black aspect-[3/4] rounded-lg">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                            </a>
                            <div class="pt-4 relative">
                                <span class="text-[9px] font-black uppercase tracking-[0.3em] text-[#e9d5ff] mb-2 block opacity-60">Collection</span>
                                <h3 class="text-sm font-semibold text-white leading-snug tracking-wide line-clamp-2 min-h-[2.5rem] uppercase">{{ $item['name'] }}</h3>
                                <div class="flex items-baseline gap-3 mt-3">
                                    <span class="text-base font-bold text-white tracking-tighter">₹{{ number_format($item['price'], 0) }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
