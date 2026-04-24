<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Homepage Sections Editor (Studio + Jewellery)') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.brand-experiences.create') }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-xs font-bold text-white uppercase hover:bg-white/10 transition-all">Add Extra Slot</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            {{-- STUDIO EXPERIENCES --}}
            <div class="bg-gray-900/60 backdrop-blur-3xl rounded-[2.5rem] border border-white/5 p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/10 blur-[100px]"></div>
                
                <div class="flex items-center gap-4 mb-12">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-600/20">
                        <span class="material-symbols-outlined">auto_awesome</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-heading font-bold text-white uppercase tracking-widest">AVNEE Studio</h3>
                        <p class="text-xs text-indigo-400 font-bold uppercase tracking-widest mt-1">Management Suite • 3 Active Slots</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($studioExperiences as $index => $exp)
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-[2rem] opacity-0 group-hover:opacity-20 transition-all duration-700 blur"></div>
                        <div class="relative bg-[#1a161e] border border-white/5 rounded-[2rem] overflow-hidden flex flex-col h-full shadow-xl">
                            <div class="h-44 relative bg-black overflow-hidden">
                                @if($exp->image_1)
                                    <img src="{{ asset('storage/'.$exp->image_1) }}" class="w-full h-full object-cover opacity-70 group-hover:scale-110 transition-all duration-1000" />
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1a161e] via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/10 backdrop-blur-md text-[10px] text-white font-black uppercase tracking-tighter rounded-full border border-white/10">SLOT {{ $index + 1 }}</span>
                                </div>
                            </div>
                            
                            <div class="p-8 flex-1 flex flex-col">
                                <span class="text-[10px] text-indigo-400 font-black uppercase tracking-widest mb-2">
                                    @switch($exp->layout_type)
                                        @case('layout_1') Editorial Stack @break
                                        @case('layout_2') Visual Grid @break
                                        @case('layout_3') Classic Split Grid @break
                                        @default {{ $exp->layout_type }}
                                    @endswitch
                                </span>
                                <h4 class="text-xl font-heading font-medium text-white mb-4">{{ $exp->title }}</h4>
                                <p class="text-gray-400 text-xs leading-relaxed line-clamp-2 italic mb-10 flex-1">"{{ $exp->content_description ?? 'Describe this experience...' }}"</p>
                                
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.brand-experiences.edit', $exp) }}" class="flex-1 flex items-center justify-center gap-3 py-4 bg-indigo-600 hover:bg-indigo-500 rounded-2xl text-[10px] font-black text-white uppercase tracking-widest shadow-lg shadow-indigo-600/20 transition-all">
                                        <span class="material-symbols-outlined text-sm">edit_square</span>
                                        Edit Content
                                    </a>
                                    <form action="{{ route('admin.brand-experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Completely remove this experience?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-4 bg-white/5 hover:bg-red-600 group/del border border-white/10 hover:border-red-500 rounded-2xl transition-all">
                                            <span class="material-symbols-outlined text-sm text-red-500 group-hover/del:text-white">delete_forever</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- JEWELLERY EXPERIENCES --}}
            <div class="bg-gray-900/60 backdrop-blur-3xl rounded-[2.5rem] border border-white/5 p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-600/10 blur-[100px]"></div>
                
                <div class="flex items-center gap-4 mb-12">
                    <div class="w-12 h-12 rounded-2xl bg-rose-600 flex items-center justify-center text-white shadow-xl shadow-rose-600/20">
                        <span class="material-symbols-outlined">diamond</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-heading font-bold text-white uppercase tracking-widest">AVNEE Jewellery</h3>
                        <p class="text-xs text-rose-400 font-bold uppercase tracking-widest mt-1">Management Suite • 3 Active Slots</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($jewelExperiences as $index => $exp)
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-rose-600 to-orange-600 rounded-[2rem] opacity-0 group-hover:opacity-20 transition-all duration-700 blur"></div>
                        <div class="relative bg-[#1a161e] border border-white/5 rounded-[2rem] overflow-hidden flex flex-col h-full shadow-xl">
                            <div class="h-44 relative bg-black overflow-hidden">
                                @if($exp->image_1)
                                    <img src="{{ asset('storage/'.$exp->image_1) }}" class="w-full h-full object-cover opacity-70 group-hover:scale-110 transition-all duration-1000" />
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1a161e] via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/10 backdrop-blur-md text-[10px] text-white font-black uppercase tracking-tighter rounded-full border border-white/10">SLOT {{ $index + 1 }}</span>
                                </div>
                            </div>
                            
                            <div class="p-8 flex-1 flex flex-col">
                                <span class="text-[10px] text-rose-400 font-black uppercase tracking-widest mb-2">
                                    @switch($exp->layout_type)
                                        @case('layout_1') Editorial Stack @break
                                        @case('layout_2') Visual Grid @break
                                        @case('layout_3') Classic Split Grid @break
                                        @default {{ $exp->layout_type }}
                                    @endswitch
                                </span>
                                <h4 class="text-xl font-heading font-medium text-white mb-4">{{ $exp->title }}</h4>
                                <p class="text-gray-400 text-xs leading-relaxed line-clamp-2 italic mb-10 flex-1">"{{ $exp->content_description ?? 'Describe this heritage story...' }}"</p>
                                
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.brand-experiences.edit', $exp) }}" class="flex-1 flex items-center justify-center gap-3 py-4 bg-rose-600 hover:bg-rose-500 rounded-2xl text-[10px] font-black text-white uppercase tracking-widest shadow-lg shadow-rose-600/20 transition-all">
                                        <span class="material-symbols-outlined text-sm">edit_square</span>
                                        Edit Content
                                    </a>
                                    <form action="{{ route('admin.brand-experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Completely remove this experience?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-4 bg-white/5 hover:bg-red-600 group/del border border-white/10 hover:border-red-500 rounded-2xl transition-all">
                                            <span class="material-symbols-outlined text-sm text-red-500 group-hover/del:text-white">delete_forever</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        body { background: #0c0a10 !important; }
        .font-heading { font-family: 'Playfair Display', serif; }
    </style>
</x-admin-layout>
