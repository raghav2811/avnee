<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 text-center md:text-left">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Shop By Style
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg mx-auto md:ml-0">Manage the collection styles shown on the home page.</p>
                </div>
                <a href="{{ route('admin.home-styles.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-black text-[10px] font-bold uppercase tracking-widest rounded-full hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span> Add New Style
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($styles as $style)
                <div class="glass-card group rounded-2xl overflow-hidden border border-white/5 flex flex-col shadow-2xl transition-all hover:border-white/10 {{ !$style->is_active ? 'opacity-60 grayscale' : '' }}">
                    <div class="relative aspect-square bg-gray-900 overflow-hidden">
                        <img src="{{ asset('storage/'.$style->image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $style->brand_id == 1 ? 'bg-[#b87333] text-white' : 'bg-purple-600 text-white' }}">
                                {{ $style->brand->name }}
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-left">
                             <p class="text-white font-heading text-lg mb-0.5">{{ $style->title }}</p>
                             <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.1em] truncate">{{ $style->redirect_url }}</p>
                        </div>
                    </div>
                    <div class="p-6 bg-black/40 border-t border-white/5 flex items-center justify-between">
                        <div class="flex gap-4">
                             <a href="{{ route('admin.home-styles.edit', $style) }}" class="text-gray-400 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                             </a>
                             <form action="{{ route('admin.home-styles.destroy', $style) }}" method="POST" onsubmit="return confirm('Delete this style?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                             </form>
                        </div>
                        <div class="flex items-center gap-2">
                             <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Order: {{ $style->sort_order }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($styles->isEmpty())
                <div class="glass-card rounded-2xl p-20 text-center border-dashed border-2 border-white/5">
                    <span class="material-symbols-outlined text-gray-800 text-6xl mb-4">style</span>
                    <p class="text-gray-600 uppercase tracking-widest text-[10px] font-bold">No styles found</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
