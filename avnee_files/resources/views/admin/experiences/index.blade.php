<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1200px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Brand Experiences
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg">Manage premium storytelling sections for both Studio and Jewellery storefronts.</p>
                </div>
            </div>

            <div x-data="{ tab: 'studio' }" class="space-y-10">
                <!-- Tab Navigation -->
                <div class="flex items-center gap-8 border-b border-white/5 pb-1">
                    <button @click="tab = 'studio'" :class="tab === 'studio' ? 'text-white border-b-2 border-[#b87333]' : 'text-gray-500 hover:text-gray-300'" class="pb-4 text-xs font-bold uppercase tracking-widest transition-all">
                        Studio (Saree Edit)
                    </button>
                    <button @click="tab = 'jewellery'" :class="tab === 'jewellery' ? 'text-white border-b-2 border-purple-500' : 'text-gray-500 hover:text-gray-300'" class="pb-4 text-xs font-bold uppercase tracking-widest transition-all">
                        Jewellery Heritage
                    </button>
                </div>

                <!-- Studio Tab -->
                <div x-show="tab === 'studio'" class="animate-fadeIn">
                    <form action="{{ route('admin.experiences.studio.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.experiences._studio_form', ['setting' => $studio])
                    </form>
                </div>

                <!-- Jewellery Tab -->
                <div x-show="tab === 'jewellery'" class="animate-fadeIn">
                    <form action="{{ route('admin.experiences.jewellery.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.experiences._jewellery_form', ['setting' => $jewellery])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
