@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $bgColor = $isDark ? 'bg-[#0f0a14]' : 'bg-[#F8C8DC]';
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-700';
    $lineColor = $isDark ? 'border-white/10' : 'border-black/10';
@endphp
<main class="{{ $bgColor }} {{ $textColor }} min-h-screen pt-24 pb-16 transition-colors duration-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-heading font-normal tracking-tight mb-4 uppercase {{ $textColor }}">The Journal</h1>
            <p class="{{ $mutedColor }} max-w-2xl mx-auto text-sm md:text-base tracking-wide font-light italic">
                Exploring the intersection of tradition, luxury, and contemporary style.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <a href="{{ route('front.blog.index') }}" 
               class="px-6 py-2 rounded-full border {{ $lineColor }} text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all {{ !request('category') ? 'bg-black text-white' : ($isDark ? 'bg-white/5 border-white/10' : 'bg-black/5 border-black/5') }}">
                All Stories
            </a>
            @foreach($categories as $category)
                <a href="{{ route('front.blog.index', ['category' => $category->slug]) }}" 
                   class="px-6 py-2 rounded-full border {{ $lineColor }} text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all {{ request('category') == $category->slug ? 'bg-black text-white' : ($isDark ? 'bg-white/5 border-white/10' : 'bg-black/5 border-black/5') }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            @forelse($posts as $post)
                <a href="{{ route('front.blog.show', $post->slug) }}" class="group block">
                    <article>
                    <div class="relative aspect-[4/5] overflow-hidden mb-6 bg-gray-900">
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-black/50 backdrop-blur-md text-[10px] font-bold uppercase tracking-[0.2em] px-3 py-1 border border-white/10">
                                {{ optional($post->category)->name ?? 'Journal' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-heading font-normal mb-3 leading-tight hover:text-[#b87333] transition-colors line-clamp-2 uppercase tracking-wide {{ $textColor }}">
                            {{ $post->title }}
                        </h2>
                        <div class="flex items-center text-[9px] {{ $mutedColor }} uppercase tracking-[0.2em] gap-4 font-bold">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span class="w-1 h-1 {{ $isDark ? 'bg-gray-700' : 'bg-gray-300' }} rounded-full"></span>
                            <span>{{ number_format($post->views) }} Views</span>
                        </div>
                    </div>
                </article>
                </a>
            @empty
                <div class="col-span-full text-center py-20 border border-dashed border-gray-800">
                    <p class="text-gray-500 uppercase tracking-widest text-sm">No stories found in this category.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</main>
@endsection
