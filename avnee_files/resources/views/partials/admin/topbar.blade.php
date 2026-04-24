<header class="flex items-center justify-between px-8 py-5 border-b border-white/5 bg-[#140610]/80 backdrop-blur-xl sticky top-0 z-30">
    <div class="flex items-center gap-6">
        <button @click="sidebarOpen = true" class="p-2 text-gray-400 hover:text-white transition-colors lg:hidden bg-white/5 rounded-lg border border-white/5 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <div class="hidden md:flex items-center gap-3">
             <div class="px-4 py-2 rounded-full glass-card border border-white/5 flex items-center gap-2">
                 <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]"></div>
                 <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Global Server Online</span>
             </div>
        </div>
    </div>

    <div class="flex items-center gap-6">
        <!-- Storefront Link -->
        <a href="/" target="_blank" class="px-4 py-2.5 rounded-xl border border-[#b87333]/30 text-[#b87333] hover:bg-[#b87333] hover:text-white transition-all text-xs font-bold uppercase tracking-widest flex items-center gap-2 group shadow-xl">
            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Live Site
        </a>

        <!-- Notifications (Mock) -->
        <button class="relative p-2.5 text-gray-400 hover:text-white transition-colors bg-white/5 rounded-xl border border-white/5 shadow-inner group">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
             <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-indigo-500 border-2 border-[#140610]"></span>
        </button>

        <!-- Divider -->
        <div class="h-8 w-px bg-white/5 mx-2"></div>

        <!-- Profile Dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 p-1.5 pr-4 pl-1.5 rounded-full hover:bg-white/5 border border-transparent hover:border-white/5 transition-all focus:outline-none">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-purple-800 to-[#b87333] flex items-center justify-center font-bold text-white text-sm shadow-lg uppercase">
                    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                </div>
                <div class="hidden sm:flex flex-col text-left">
                    <span class="text-xs font-bold text-white uppercase tracking-wider">{{ Auth::guard('admin')->user()->name }}</span>
                    <span class="text-[9px] text-[#b87333] font-bold uppercase opacity-80 mt-0.5 tracking-[0.15em] leading-none">Super Administrator</span>
                </div>
                <span class="transition-transform duration-300" :class="{'rotate-180': dropdownOpen}">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </span>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 w-64 mt-4 origin-top-right bg-[#1a131b] border border-white/10 rounded-2xl shadow-2xl p-2 outline-none z-50 overflow-hidden" 
                 x-cloak>
                
                <div class="px-4 py-4 border-b border-white/5 mb-2">
                    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1">Signed in as</p>
                    <p class="text-xs font-bold text-white truncate">{{ Auth::guard('admin')->user()->email }}</p>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest text-gray-400 hover:bg-[#b87333] hover:text-white rounded-xl transition-all group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Account Profile
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest text-gray-400 hover:bg-[#b87333] hover:text-white rounded-xl transition-all group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Access Logs
                    </a>

                    <div class="h-px bg-white/5 my-2"></div>

                    <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            System Logout
                        </button>
                    </form>
                </div>

                <div class="mt-4 p-4 bg-black/20 rounded-xl">
                     <div class="flex items-center justify-between mb-1.5">
                          <span class="text-[9px] font-bold text-gray-500 uppercase">System Integrity</span>
                          <span class="text-[9px] font-bold text-green-500 uppercase">Secure</span>
                     </div>
                     <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                          <div class="bg-[#b87333] h-full w-[95%]"></div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</header>
