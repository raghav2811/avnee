<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 text-center md:text-left">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Just In Experience
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg mx-auto md:ml-0">Manage the dual campaign visuals for the 'Just In' section across storefronts.</p>
                </div>
                <a href="{{ route('admin.just-in-experiences.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-black text-[10px] font-bold uppercase tracking-widest rounded-full hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span> Establish New Card
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($experiences as $exp)
                <div class="glass-card group rounded-2xl overflow-hidden border border-white/5 flex flex-col shadow-2xl transition-all hover:border-white/10">
                    <div class="relative aspect-[16/10] bg-gray-900 overflow-hidden">
                        <img src="{{ asset('storage/'.$exp->image) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $exp->brand_id == 1 ? 'bg-[#b87333] text-white' : 'bg-purple-600 text-white' }}">
                                {{ $exp->brand->name }}
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-black/10 to-black/60"></div>
                        <div class="absolute bottom-4 right-4 text-right">
                             <p class="text-white font-heading text-lg mb-0.5 italic">{{ $exp->title }}</p>
                             <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em]">{{ $exp->button_text }}</p>
                        </div>
                    </div>
                    <div class="p-6 bg-black/40 border-t border-white/5 flex items-center justify-between">
                        <div class="flex gap-4">
                             <a href="{{ route('admin.just-in-experiences.edit', $exp) }}" class="text-gray-400 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                             </a>
                             <form action="{{ route('admin.just-in-experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Archive this experience?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                             </form>
                        </div>
                        <div class="flex items-center gap-2">
                             <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Order: {{ $exp->sort_order }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($experiences->isEmpty())
                <div class="glass-card rounded-2xl p-20 text-center border-dashed border-2 border-white/5">
                    <span class="material-symbols-outlined text-gray-800 text-6xl mb-4">analytics</span>
                    <p class="text-gray-600 uppercase tracking-widest text-[10px] font-bold">Waiting for your first campaign</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
