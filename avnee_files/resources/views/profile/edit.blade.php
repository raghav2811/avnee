@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $bgColor = $isDark ? 'bg-[#0a060d]' : 'bg-[#F8C8DC]';
    $cardBg = $isDark ? 'bg-[#2B003A]' : 'bg-white';
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-600';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $lineColor = $isDark ? 'border-white/10' : 'border-black/10';
@endphp

<div class="py-24 {{ $bgColor }} transition-colors duration-700 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
        <header class="mb-12 text-center">
            <h1 class="text-4xl font-heading font-normal {{ $textColor }} tracking-[0.2em] uppercase mb-2 italic">Client Profile</h1>
            <p class="text-[10px] {{ $mutedColor }} font-black uppercase tracking-[0.4em]">Manage your luxury account details</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="p-8 {{ $cardBg }} backdrop-blur-md border {{ $lineColor }} rounded-sm shadow-xl">
                    <div class="w-20 h-20 rounded-full bg-{{ $isDark ? 'white/5' : 'black/5' }} border {{ $lineColor }} flex items-center justify-center mb-6 mx-auto">
                        <span class="material-symbols-outlined text-3xl {{ $accentColor }}">person</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold {{ $textColor }} tracking-wider uppercase mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-[11px] {{ $mutedColor }} tracking-[0.1em]">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Forms Area -->
            <div class="lg:col-span-2 space-y-8">
                <div class="p-8 sm:p-12 {{ $cardBg }} backdrop-blur-md border {{ $lineColor }} rounded-sm shadow-2xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-8 sm:p-12 {{ $cardBg }} backdrop-blur-md border {{ $lineColor }} rounded-sm shadow-2xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-8 sm:p-12 bg-red-500/5 backdrop-blur-md border border-red-500/10 rounded-sm shadow-xl">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the breeze-default partials to fit luxury theme */
    label { font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 0.2em !important; font-weight: 900 !important; color: {{ $isDark ? '#9ca3af' : '#6b7280' }} !important; margin-bottom: 0.5rem !important; display: block; }
    input { background-color: transparent !important; border-bottom: 1.5px solid {{ $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)' }} !important; border-top: 0 !important; border-left: 0 !important; border-right: 0 !important; border-radius: 0 !important; padding: 0.75rem 0 !important; color: {{ $isDark ? 'white' : 'black' }} !important; font-size: 14px !important; letter-spacing: 0.05em !important; }
    input:focus { border-color: {{ $isDark ? '#f3d9ff' : '#b87333' }} !important; border-bottom-width: 2px !important; box-shadow: none !important; }
    button[type="submit"]:not(.text-red-600) { background-color: {{ $isDark ? '#7C3AED' : 'black' }} !important; color: white !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.3em !important; font-weight: 900 !important; padding: 1rem 2rem !important; border-radius: 2px !important; transition: all 0.3s !important; margin-top: 1rem !important; }
    button[type="submit"]:hover { opacity: 0.9 !important; transform: translateY(-1px) !important; }
</style>
@endsection
