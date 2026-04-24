<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avnee | Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-[#0e0309] relative overflow-hidden">
        <div class="absolute inset-0 z-0">
             <div class="absolute top-0 left-0 w-1/2 h-full bg-[#b87333]/5 blur-[200px]"></div>
             <div class="absolute bottom-0 right-0 w-1/2 h-full bg-purple-900/5 blur-[200px]"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
            <h1 class="text-3xl font-bold text-white tracking-[0.2em] uppercase font-heading">
                AVNEE <span class="text-[#b87333]">ADMIN</span>
            </h1>
            <p class="mt-2 text-sm text-gray-400 font-medium tracking-widest uppercase">
                Access your management console
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-white/10 backdrop-blur-xl py-10 px-6 shadow-2xl rounded-2xl sm:px-12 border border-white/10">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-100 p-4 rounded-xl text-sm italic">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form class="space-y-8" action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-300 uppercase tracking-widest mb-3">Administrator Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                            placeholder="admin@avnee.com">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-300 uppercase tracking-widest mb-3">Password Key</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#b87333] focus:ring-[#b87333] border-white/20 rounded bg-white/5 cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-400 cursor-pointer">
                                Remember session
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-semibold text-white/50 hover:text-white transition-colors">
                                Forgotten Access?
                            </a>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-xl text-sm font-bold text-black bg-white hover:bg-[#b87333] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#0e0309] focus:ring-[#b87333] transition-all duration-500 uppercase tracking-widest transform hover:-translate-y-1">
                            Authorize Login
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-xs text-gray-500 font-medium">
                    New Administrator? <a href="{{ route('admin.register') }}" class="text-[#b87333] hover:text-white ml-1 underline decoration-[#b87333]/30 underline-offset-4 decoration-2">Request Access</a>
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ route('front.home') }}" class="text-xs font-bold text-gray-500 hover:text-white uppercase tracking-widest transition-colors flex items-center justify-center gap-2 group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                    Return to Storefront
                </a>
            </div>
        </div>
    </div>
</body>
</html>
