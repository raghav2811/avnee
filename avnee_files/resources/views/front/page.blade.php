@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
@php
    $isTermsPage = request()->route('slug') === 'terms-of-service';
    $displayTitle = $isTermsPage ? 'Terms & conditions' : $page->title;
@endphp
<div class="bg-[#e6e6e6] min-h-screen py-3 sm:py-5">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-[11px] sm:text-[12px] text-gray-800 mb-2 sm:mb-4">
            <a href="{{ route('front.home') }}" class="hover:text-black transition-colors">Home</a>
            <span class="mx-1.5">/</span>
            <span>{{ $displayTitle }}</span>
        </nav>

        <header class="text-center mb-4 sm:mb-6">
            <h1 class="terms-title text-[44px] sm:text-[56px] text-[#1f2a44] leading-tight">
                {{ $displayTitle }}
            </h1>
        </header>

        <article class="legal-content text-[#111111] py-0.5">
            {!! $page->content !!}
        </article>
    </div>
</div>
@endsection

@push('styles')
<style>
    .terms-title {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 500;
        letter-spacing: 0;
    }

    .legal-content {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
        line-height: 1.55;
        letter-spacing: 0;
        max-width: none;
    }

    .legal-content h1,
    .legal-content h2,
    .legal-content h3,
    .legal-content h4 {
        font-family: "Helvetica Neue", Arial, sans-serif;
        line-height: 1.3;
        margin-top: 20px;
        margin-bottom: 8px;
        color: #000;
        font-weight: 700;
    }

    .legal-content h3,
    .legal-content h4 {
        font-size: 28px;
        margin-left: 0;
        margin-top: 26px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .legal-content p {
        font-size: 15px;
        margin-bottom: 12px;
        padding-left: 0;
    }

    .legal-content ul,
    .legal-content ol {
        margin: 8px 0 14px 24px;
        padding: 0;
    }

    .legal-content ul {
        list-style: disc;
    }

    .legal-content ol {
        list-style: decimal;
    }

    .legal-content li {
        margin-bottom: 8px;
        font-size: 15px;
    }

    .legal-content strong {
        font-weight: 800;
        color: #000;
    }

    .legal-content img {
        width: 100%;
        height: auto;
        margin: 10px 0;
        border: 1px solid #ddd;
    }

    .legal-content hr {
        border: 0;
        border-top: 1px solid #ddd;
        margin: 14px 0;
    }

    @media (max-width: 768px) {
        .terms-title {
            font-size: 36px;
        }

        .legal-content {
            font-size: 13px;
            line-height: 1.45;
        }

        .legal-content h3,
        .legal-content h4 {
            font-size: 22px;
            margin-left: 0;
        }

        .legal-content p {
            font-size: 13px;
            padding-left: 0;
        }

        .legal-content li {
            font-size: 13px;
        }

        .legal-content ul,
        .legal-content ol {
            margin-left: 16px;
        }
    }
</style>
@endpush
