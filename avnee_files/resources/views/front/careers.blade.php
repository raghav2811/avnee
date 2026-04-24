@extends('layouts.front.' . ($theme ?? 'studio'))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
@endphp

<div class="min-h-screen py-20 px-4 {{ $isDark ? 'bg-[#1a0023] text-[#fdf2f8]' : 'bg-[#F8C8DC] text-gray-900' }}">
    <div class="max-w-[960px] mx-auto text-center">
        <p class="text-[10px] font-bold uppercase tracking-[0.4em] {{ $isDark ? 'text-[#e9d5ff]/60' : 'text-mulberry/60' }} mb-6">Join AVNEE</p>
        <h1 class="text-4xl md:text-5xl font-heading font-normal tracking-[0.12em] uppercase mb-6">Careers at AVNEE Collections</h1>
        <p class="text-base {{ $isDark ? 'text-[#e9d5ff]' : 'text-gray-700' }} max-w-2xl mx-auto leading-relaxed">
            If you are looking to work with us, get in touch with us at
            <a class="underline font-semibold" href="mailto:studio@avneecollections.com">studio@avneecollections.com</a>
            or
            <a class="underline font-semibold" href="mailto:avnee.collections@gmail.com">avnee.collections@gmail.com</a>.
        </p>
    </div>
</div>
@endsection
