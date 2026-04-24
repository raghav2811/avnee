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
<article class="{{ $bgColor }} {{ $textColor }} min-h-screen pt-24 pb-16 transition-colors duration-700">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center text-[9px] font-bold uppercase tracking-[0.3em] {{ $mutedColor }} mb-8 border-b {{ $lineColor }} pb-4">
            <a href="/" class="hover:{{ $textColor }} transition-colors text-inherit underline underline-offset-4 decoration-current/10">Home</a>
            <span class="mx-3 text-[8px] opacity-30">/</span>
            <a href="{{ route('front.blog.index') }}" class="hover:{{ $textColor }} transition-colors text-inherit underline underline-offset-4 decoration-current/10">Journal</a>
            <span class="mx-3 text-[8px] opacity-30">/</span>
            <span class="{{ $textColor }}">{{ optional($post->category)->name ?? 'Journal' }}</span>
        </nav>

        <!-- Header -->
        <header class="mb-12">
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] mb-4 {{ $mutedColor }}">Editorial Record — {{ $post->created_at->format('Y') }}</p>
            <h1 class="text-3xl md:text-5xl font-heading font-normal leading-tight mb-8 uppercase tracking-tight {{ $textColor }}">{{ $post->title }}</h1>
            <div class="flex items-center text-[9px] font-bold {{ $mutedColor }} uppercase tracking-[0.3em] gap-5">
                <span class="flex items-center gap-2">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $post->created_at->format('M d, Y') }}
                </span>
                <span class="w-1 h-1 bg-current opacity-20 rounded-full"></span>
                <span class="flex items-center gap-2">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    {{ number_format($post->views) }} Records
                </span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($post->image)
            <div class="mb-16 aspect-[16/9] bg-black/10 overflow-hidden rounded-sm shadow-2xl group">
                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[3s]">
            </div>
        @endif

        <!-- Content -->
        <div class="max-w-none mb-24 {{ $isDark ? 'text-gray-300' : 'text-gray-800' }} leading-[2] font-light tracking-wide first-letter:text-6xl first-letter:font-heading first-letter:{{ $isDark ? 'text-[#d4af37]' : 'text-gray-900' }} first-letter:mr-4 first-letter:float-left first-letter:mt-2">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Footer -->
        <footer class="border-t {{ $lineColor }} pt-16 mt-16">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-5">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $mutedColor }}">Social Echo:</span>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full border {{ $lineColor }} flex items-center justify-center {{ $mutedColor }} hover:{{ $textColor }} hover:border-current transition-all">FB</a>
                        <a href="#" class="w-10 h-10 rounded-full border {{ $lineColor }} flex items-center justify-center {{ $mutedColor }} hover:{{ $textColor }} hover:border-current transition-all">TW</a>
                        <a href="#" class="w-10 h-10 rounded-full border {{ $lineColor }} flex items-center justify-center {{ $mutedColor }} hover:{{ $textColor }} hover:border-current transition-all">PN</a>
                    </div>
                </div>
                <a href="{{ route('front.blog.index') }}" class="text-[10px] font-bold uppercase tracking-[0.4em] px-12 py-5 border {{ $lineColor }} hover:{{ $isDark ? 'bg-[#d4af37] text-white' : 'bg-black text-white' }} transition-all rounded-sm">
                    Back to Journal
                </a>
            </div>
        </footer>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="mt-32 py-32 border-t {{ $lineColor }} bg-black/[0.03]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-xs font-bold uppercase tracking-[0.5em] mb-20 text-center {{ $mutedColor }}">Suggested Reading</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('front.blog.show', $related->slug) }}" class="group block">
                            <article>
                            <div class="relative aspect-[4/5] overflow-hidden mb-8 bg-black/10 rounded-sm shadow-lg">
                                @if($related->image)
                                    <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                                @endif
                            </div>
                            <div class="space-y-4">
                                <h4 class="text-lg font-heading font-normal leading-snug group-hover:opacity-60 transition-opacity uppercase tracking-wide {{ $textColor }}">
                                    {{ \Illuminate\Support\Str::limit($related->title, 50) }}
                                </h4>
                                <div class="text-[9px] font-bold uppercase tracking-[0.3em] {{ $mutedColor }}">
                                    {{ $related->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</article>

<style>
    .font-light p { margin-bottom: 2.5rem; }
</style>
@endsection
