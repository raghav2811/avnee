<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1600px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Price Experience
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg">Curate the 'Shop By Price' options for both Studio and Jewellery storefronts.</p>
                </div>
                <a href="{{ route('admin.price-bands.create') }}" 
                   class="group relative flex items-center gap-2 px-6 py-2.5 bg-[#b87333] hover:bg-[#a6682d] text-white text-sm font-semibold rounded-full shadow-lg shadow-[#b87333]/12 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Establish Band
                </a>
            </div>

            <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10 uppercase tracking-[0.15em] text-[10px] font-bold text-gray-400">
                                <th class="py-5 px-8">Context</th>
                                <th class="py-5 px-8">Label</th>
                                <th class="py-5 px-8">Limit (INR)</th>
                                <th class="py-5 px-8">Redirect / Path</th>
                                <th class="py-5 px-8 text-center">Order</th>
                                <th class="py-5 px-8 text-right">Settings</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($bands as $band)
                            <tr class="group hover:bg-white/[0.03] transition-colors duration-200">
                                <td class="py-5 px-8">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $band->brand_id == 2 ? 'bg-purple-900/40 text-purple-300 ring-1 ring-purple-500/30' : 'bg-orange-900/40 text-orange-300 ring-1 ring-orange-500/30' }}">
                                        {{ $band->brand?->name }}
                                    </div>
                                </td>
                                <td class="py-5 px-8">
                                    <p class="text-sm font-semibold text-white">{{ $band->label }}</p>
                                </td>
                                <td class="py-5 px-8">
                                    <span class="text-sm font-bold text-[#b87333]">₹{{ number_format($band->price_limit, 0) }}</span>
                                </td>
                                <td class="py-5 px-8">
                                    <span class="text-[11px] font-mono text-gray-500 opacity-60">{{ $band->redirect_url ?? 'Auto-calculated' }}</span>
                                </td>
                                <td class="py-5 px-8 text-center">
                                    <span class="text-xs font-bold text-gray-400">#{{ $band->sort_order }}</span>
                                </td>
                                <td class="py-5 px-8 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.price-bands.edit', $band) }}" 
                                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                                            <span class="material-symbols-outlined text-sm">stylus</span>
                                        </a>
                                        <form action="{{ route('admin.price-bands.destroy', $band) }}" method="POST" onsubmit="return confirm('Archive this price band?')">
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
                                <td colspan="6" class="py-20 text-center text-gray-500 italic">No price bands established.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
