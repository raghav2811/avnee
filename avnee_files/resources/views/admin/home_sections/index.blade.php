<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1600px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Home Experience
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg">Manage dynamic product sections for both Studio and Jewellery storefronts.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.home-sections.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#b87333] hover:bg-[#a0632d] text-white text-xs font-bold uppercase tracking-[0.2em] rounded-xl shadow-[0_10px_20px_rgba(184,115,51,0.2)] transition-all transform hover:-translate-y-0.5 active:scale-95">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        New Section
                    </a>
                </div>
            </div>

            <div class="glass-card rounded-2xl overflow-hidden shadow-2xl border border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10 uppercase tracking-[0.15em] text-[10px] font-bold text-gray-400">
                                <th class="py-5 px-8">Context</th>
                                <th class="py-5 px-8">Section / Content</th>
                                <th class="py-5 px-8 text-center">Products</th>
                                <th class="py-5 px-8 text-center">Display Order</th>
                                <th class="py-5 px-8">Status</th>
                                <th class="py-5 px-8 text-right">Settings</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @php 
                                $sortedSections = $sections->sortBy(function($s) {
                                    return $s->brand_id * 1000 + $s->sort_order;
                                });
                            @endphp
                            @forelse($sortedSections as $section)
                            <tr class="group hover:bg-white/[0.03] transition-colors duration-200">
                                <td class="py-5 px-8">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $section->brand_id == 2 ? 'bg-purple-900/40 text-purple-300 ring-1 ring-purple-500/30' : 'bg-orange-900/40 text-orange-300 ring-1 ring-orange-500/30' }}">
                                        {{ $section->brand?->name ?? 'Unset' }}
                                    </div>
                                </td>
                                <td class="py-5 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-14 h-14 rounded-xl overflow-hidden bg-gray-900/50 border border-white/10 group-hover:border-[#b87333]/30 transition-colors">
                                            @if($section->image)
                                                <img src="{{ asset('storage/' . $section->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-gray-700">texture</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-white group-hover:text-[#b87333] transition-colors uppercase tracking-widest">{{ $section->title }}</p>
                                            <p class="text-[10px] text-gray-500 mt-0.5 font-mono opacity-60">ID: #{{ $section->section_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-8 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-gray-300">
                                        {{ is_array($section->product_ids) ? count($section->product_ids) : '0' }}
                                    </span>
                                </td>
                                <td class="py-5 px-8 text-center text-gray-400">
                                     <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                                         <span class="material-symbols-outlined text-[10px]">reorder</span>
                                         <span class="text-[10px] font-bold uppercase tracking-widest">{{ $section->sort_order }}</span>
                                     </div>
                                </td>
                                <td class="py-5 px-8">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $section->is_active ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-gray-600' }}"></div>
                                        <span class="text-[10px] uppercase font-bold tracking-widest {{ $section->is_active ? 'text-green-500' : 'text-gray-500' }}">
                                            {{ $section->is_active ? 'Active' : 'Hidden' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-5 px-8">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.home-sections.edit', $section) }}" 
                                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition-all"
                                           title="Edit Section">
                                            <span class="material-symbols-outlined text-sm">stylus</span>
                                        </a>
                                        <form action="{{ route('admin.home-sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Archive this experience section?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-red-500/5 border border-red-500/10 text-red-400 hover:text-white hover:bg-red-500 transition-all">
                                                <span class="material-symbols-outlined text-sm">archive</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-gray-500">
                                    <span class="material-symbols-outlined text-4xl opacity-20">segment</span>
                                    <p class="text-sm font-medium mt-2 uppercase tracking-widest text-[10px]">No experience sections established yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
