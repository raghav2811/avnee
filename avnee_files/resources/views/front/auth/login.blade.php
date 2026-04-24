@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
@php
    $brandId = session('brand_id', 1);
    $isDark = $brandId == 2;
    $bgColor = $isDark ? 'bg-[#0a060d]' : 'bg-[#F8C8DC]';
    $cardBg = $isDark ? 'bg-[#2B003A]' : 'bg-white shadow-2xl';
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-gray-400' : 'text-gray-600';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $btnBg = $isDark ? 'bg-[#7C3AED] text-white' : 'bg-black text-white hover:bg-[#b87333]';
@endphp
<div class="min-h-screen flex items-center justify-center {{ $bgColor }} py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-700">
    <!-- Background Decor (Gradient or Image) -->
    <div class="absolute top-0 right-0 w-96 h-96 {{ $isDark ? 'bg-purple-900/20' : 'bg-[#f8c8dc]/20' }} blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 {{ $isDark ? 'bg-[#b87333]/10' : 'bg-[#b87333]/5' }} blur-[120px] rounded-full"></div>

    <div class="max-w-md w-full space-y-8 relative z-10 backdrop-blur-md {{ $cardBg }} p-10 rounded-2xl border {{ $isDark ? 'border-white/10' : 'border-black/5' }} shadow-2xl">
        <div>
            <h2 class="mt-6 text-center text-3xl font-heading font-semibold {{ $textColor }} tracking-widest uppercase">
                Welcome Back
            </h2>
            <p class="mt-2 text-center text-sm {{ $mutedColor }} font-body">
                Please enter your details to sign in
            </p>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-lg text-xs">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-5">
                    <label for="email-address" class="block text-[10px] font-bold {{ $mutedColor }} uppercase tracking-widest mb-2">Email Address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required 
                        class="appearance-none rounded-none relative block w-full px-4 py-3 border {{ $isDark ? 'border-white/10 bg-white/5 text-white' : 'border-gray-200 bg-gray-50 text-gray-900' }} placeholder-gray-500 focus:outline-none focus:ring-{{ $isDark ? '[#b87333]' : 'black' }} focus:border-{{ $isDark ? '[#b87333]' : 'black' }} focus:z-10 sm:text-sm transition-all shadow-sm" 
                        placeholder="john@example.com">
                </div>
                <div>
                    <label for="password" class="block text-[10px] font-bold {{ $mutedColor }} uppercase tracking-widest mb-2">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none rounded-none relative block w-full px-4 py-3 border {{ $isDark ? 'border-white/10 bg-white/5 text-white' : 'border-gray-200 bg-gray-50 text-gray-900' }} placeholder-gray-500 focus:outline-none focus:ring-{{ $isDark ? '[#b87333]' : 'black' }} focus:border-{{ $isDark ? '[#b87333]' : 'black' }} focus:z-10 sm:text-sm transition-all shadow-sm" 
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-[#b87333] focus:ring-[#b87333] border-gray-300 rounded {{ $isDark ? 'bg-white/5' : '' }}">
                    <label for="remember-me" class="ml-2 block text-xs {{ $mutedColor }}">
                        Remember me
                    </label>
                </div>

                <div class="text-xs">
                    <a href="#" class="font-medium {{ $accentColor }} hover:opacity-80 transition-opacity">
                        Forgot password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-xs font-bold rounded-sm {{ $btnBg }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#b87333] transition-all uppercase tracking-widest shadow-lg">
                    Sign In
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs text-gray-400">
                Don't have an eye? 
                <a href="{{ route('register') }}" class="font-bold text-[#b87333] hover:text-[#d48c4a] ml-1 uppercase tracking-widest">Register Now</a>
            </p>
        </div>
    </div>
</div>
@endsection
