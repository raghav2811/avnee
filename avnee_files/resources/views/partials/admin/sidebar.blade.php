<!-- Sidebar (Mobile Overlays) -->
<div 
    x-show="sidebarOpen" 
    class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden h-full w-full overflow-hidden transition-opacity duration-300"
    x-transition:enter="ease-out"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    style="display: none;"
></div>

<!-- Actual Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-50 flex flex-col w-[280px] h-full bg-[#140610] lg:static lg:flex border-r border-white/5 transition-transform duration-300 ease-in-out transform shadow-2xl overflow-hidden"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'lg:translate-x-0': true}"
    x-cloak
>
    <!-- Logo Section -->
    <div class="flex items-center justify-between flex-shrink-0 p-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-[#b87333] to-purple-800 rounded-xl flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-xl">diamond</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-[0.2em] text-white uppercase font-heading leading-tight">AVNEE</span>
                <span class="text-[10px] font-bold text-[#b87333] tracking-[0.3em] uppercase opacity-80">Admin Pro</span>
            </div>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-gray-400 hover:text-white transition-colors">
            <span class="material-symbols-outlined">menu_open</span>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-1.5 overflow-y-auto mt-4 pb-12 custom-scrollbar">
        <!-- Section: Dashboard -->
        <p class="px-4 py-2 text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mb-1">General</p>
        
        <x-admin-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <x-slot name="icon">dashboard</x-slot>
            Dashboard
        </x-admin-sidebar-link>

        <p class="px-4 py-6 text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mb-1 mt-2">Inventory Room</p>
        
        <x-admin-sidebar-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
            <x-slot name="icon">inventory_2</x-slot>
            Product Suite
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
            <x-slot name="icon">category</x-slot>
            Collections
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.combos.index')" :active="request()->routeIs('admin.combos.*')">
            <x-slot name="icon">shopping_bag</x-slot>
            Combo Deals
        </x-admin-sidebar-link>

        <p class="px-4 py-6 text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mb-1 mt-2">Logistics & Sales</p>
        
        <x-admin-sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
            <x-slot name="icon">package_2</x-slot>
            Management
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
            <x-slot name="icon">group</x-slot>
            Loyalists
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.coupons.index')" :active="request()->routeIs('admin.coupons.*')">
            <x-slot name="icon">sell</x-slot>
            Prviledges
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.flash-sales.index')" :active="request()->routeIs('admin.flash-sales.*')">
            <x-slot name="icon">bolt</x-slot>
            Flash Events
        </x-admin-sidebar-link>

        <p class="px-4 py-6 text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mb-1 mt-2">Digital Presence</p>

        <x-admin-sidebar-link :href="route('admin.banners.index')" :active="request()->routeIs('admin.banners.*')">
            <x-slot name="icon">ad_units</x-slot>
            Promotions
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.home-sections.index')" :active="request()->routeIs('admin.home-sections.*')">
            <x-slot name="icon">dashboard_customize</x-slot>
            Home Sections
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.just-in-experiences.index')" :active="request()->routeIs('admin.just-in-experiences.*')">
            <x-slot name="icon">new_releases</x-slot>
            Just In Experience
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.price-bands.index')" :active="request()->routeIs('admin.price-bands.*')">
            <x-slot name="icon">payments</x-slot>
            Price Experience
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.home-styles.index')" :active="request()->routeIs('admin.home-styles.*')">
            <x-slot name="icon">style</x-slot>
            Style Experience
        </x-admin-sidebar-link>

        
        <x-admin-sidebar-link :href="route('admin.home-explore-grids.index')" :active="request()->routeIs('admin.home-explore-grids.*')">
            <x-slot name="icon">grid_view</x-slot>
            Explore Grid
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.blog-posts.index')" :active="request()->routeIs('admin.blog-*')">
            <x-slot name="icon">article</x-slot>
            Editorial
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
            <x-slot name="icon">description</x-slot>
            Pages
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')">
            <x-slot name="icon">star</x-slot>
            Feedback
        </x-admin-sidebar-link>

        <p class="px-4 py-6 text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mb-1 mt-2">Executive</p>

        <x-admin-sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
            <x-slot name="icon">analytics</x-slot>
            Insights
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.newsletter.index')" :active="request()->routeIs('admin.newsletter.*')">
            <x-slot name="icon">mail</x-slot>
            Newsletter
        </x-admin-sidebar-link>

        <x-admin-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
            <x-slot name="icon">settings</x-slot>
            Configurations
        </x-admin-sidebar-link>
    </nav>

    <!-- User Mini Profile -->
    <div class="mt-auto border-t border-white/5 p-6 bg-black/20">
        <div class="flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30 text-indigo-400">
                  <span class="material-symbols-outlined text-sm">person</span>
             </div>
             <div class="flex flex-col">
                  <span class="text-xs font-bold text-white uppercase">{{ auth()->guard('admin')->user()->name }}</span>
                  <span class="text-[9px] text-gray-500 uppercase tracking-widest">{{ auth()->guard('admin')->user()->role }} Account</span>
             </div>
        </div>
    </div>
</aside>
