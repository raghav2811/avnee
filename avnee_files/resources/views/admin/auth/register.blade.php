<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0e0309]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avnee | Admin Access Request</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
             <div class="absolute top-0 right-0 w-2/3 h-full bg-[#b87333]/5 blur-[250px]"></div>
             <div class="absolute bottom-0 left-0 w-2/3 h-full bg-purple-900/5 blur-[250px]"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
            <h1 class="text-3xl font-bold text-white tracking-[0.2em] uppercase font-heading">
                AVNEE <span class="text-[#b87333]">REGISTER</span>
            </h1>
            <p class="mt-2 text-sm text-gray-400 font-medium tracking-widest uppercase italic">
                Secure Administrative Onboarding
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-lg relative z-10">
            <div class="bg-white/10 backdrop-blur-xl py-12 px-6 shadow-2xl rounded-2xl sm:px-12 border border-white/10 mx-4 sm:mx-0">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-500/20 border border-red-500/50 text-red-100 p-5 rounded-xl text-sm prose prose-invert overflow-hidden">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('admin.register.submit') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Full Identity</label>
                            <input id="name" name="name" type="text" required 
                                class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-inner placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                                placeholder="Admin Name" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Secured Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-inner placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                                placeholder="administrator@avnee.com" value="{{ old('email') }}">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Password</label>
                                <input id="password" name="password" type="password" required 
                                    class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-inner placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                                    placeholder="••••••••">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Confirm Access Key</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required 
                                    class="appearance-none block w-full px-5 py-4 border border-white/10 bg-white/5 rounded-xl shadow-inner placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#b87333] focus:border-transparent sm:text-sm transition-all duration-300"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-xl text-sm font-bold text-black bg-white hover:bg-[#b87333] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#0e0309] focus:ring-[#b87333] transition-all duration-500 uppercase tracking-widest transform hover:scale-[1.02]">
                            Initialize Admin Account
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-xs text-gray-500 font-medium font-body leading-relaxed">
                    Already an Administrator? <a href="{{ route('admin.login') }}" class="text-[#b87333] hover:text-white ml-1 font-bold tracking-widest transition-colors underline underline-offset-4 decoration-[#b87333]/50">Authorize Access</a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('front.home') }}" class="text-xs font-bold text-gray-500/80 hover:text-white transition-all uppercase tracking-[0.2em] transform inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">west</span>
                    Return to Storefront
                </a>
            </div>
        </div>
    </div>
</body>
</html>
