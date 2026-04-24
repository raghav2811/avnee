@extends('layouts.front.' . ($theme ?? 'studio'))

@section('content')
@php
    $isDark = ($theme ?? 'studio') === 'jewellery';
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#e9d5ff]' : 'text-gray-600';
    $bgColor = $isDark ? 'bg-[#2B003A]' : 'bg-[#F8C8DC]';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-mulberry/20';

    $faqs = [
        ['q' => 'How long does delivery take?', 'a' => 'Orders are usually dispatched within 24-48 hours. Delivery timelines vary by pincode and courier availability.'],
        ['q' => 'Do you offer returns or exchanges?', 'a' => 'Returns and exchanges are accepted as per product category and policy conditions. Items must be unused and in original condition.'],
        ['q' => 'Can I track my order?', 'a' => 'Yes. Use the Track Order page with your order number and checkout email to see the latest shipment status.'],
        ['q' => 'What payment methods are available?', 'a' => 'We currently support Razorpay online payments and Cash on Delivery where applicable.'],
        ['q' => 'How do I contact AVNEE support?', 'a' => 'You can submit a message from the Contact page or write to avnee.collections@gmail.com / studio@avneecollections.com.'],
        ['q' => 'Do you ship across India?', 'a' => 'Yes, we ship to serviceable pincodes across India based on courier coverage.'],
    ];
@endphp

<div class="{{ $bgColor }} py-16 sm:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="font-heading text-3xl sm:text-5xl font-normal uppercase tracking-[0.15em] {{ $textColor }}">FAQs</h1>
            <p class="mt-4 text-sm {{ $mutedColor }}">Answers to commonly asked questions about orders, delivery, returns, and support.</p>
        </div>

        <div class="space-y-3">
            @foreach($faqs as $faq)
                <details class="group border {{ $borderColor }} {{ $isDark ? 'bg-[#230030]' : 'bg-white/70' }} px-5 py-4">
                    <summary class="list-none cursor-pointer flex items-center justify-between gap-4">
                        <span class="text-sm sm:text-base font-semibold {{ $textColor }}">{{ $faq['q'] }}</span>
                        <span class="text-xl leading-none {{ $textColor }} transition-transform group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed {{ $mutedColor }}">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</div>
@endsection
