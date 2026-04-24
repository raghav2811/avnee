@props(['active', 'href'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3.5 rounded-xl bg-[#b87333]/15 text-[#b87333] border border-[#b87333]/20 font-bold transition-all shadow-sm'
            : 'flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-500 hover:bg-white/5 hover:text-white border border-transparent transition-all font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'href' => $href]) }}>
    <div class="flex-shrink-0">
        <span class="material-symbols-outlined text-[20px] {{ ($active ?? false) ? 'text-[#b87333]' : 'text-gray-500 group-hover:text-white transition-colors' }}">
            {{ $icon }}
        </span>
    </div>
    <span class="text-xs uppercase tracking-[0.12em]">{{ $slot }}</span>
</a>
