<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AVNEE | Administrative Suite</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; }
        .font-heading { font-family: 'Playfair Display', serif; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #332d36; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #b87333; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="h-full antialiased text-gray-200 bg-[#0e0309] overflow-hidden">

    <div class="flex h-screen overflow-hidden relative">
        <!-- Background Accents -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#b87333]/5 blur-[200px] rounded-full -z-10"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-900/5 blur-[200px] rounded-full -z-10"></div>

        <!-- Sidebar (Desktop & Mobile) -->
        @include('partials.admin.sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <!-- Topbar -->
            @include('partials.admin.topbar')

            <!-- Page Layout -->
            <main class="flex-1">
                @isset($header)
                    <div class="px-6 py-8 sm:px-10">
                        <div class="max-w-[1600px] mx-auto">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <div class="px-6 pb-12 sm:px-10">
                    <div class="max-w-[1600px] mx-auto">
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                                 class="mb-6 p-4 rounded-xl glass-card border-l-4 border-green-500 flex items-center justify-between animate-in slide-in-from-top-4 duration-300">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                                    <span class="text-sm font-medium">{{ session('success') }}</span>
                                </div>
                                <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                                 class="mb-6 p-4 rounded-xl glass-card border-l-4 border-red-500 flex items-center justify-between animate-in slide-in-from-top-4 duration-300">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-red-500">error</span>
                                    <span class="text-sm font-medium">{{ session('error') }}</span>
                                </div>
                                <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </div>
            </main>
            
            <!-- Admin Footer -->
            <footer class="mt-auto px-10 py-6 border-t border-white/5 opacity-40 text-xs flex justify-between">
                <p>&copy; {{ date('Y') }} AVNEE Admin Suite. All rights reserved.</p>
                <p>Version 2.0.1 (Premium)</p>
            </footer>
        </div>
    </div>

</body>
</html>
