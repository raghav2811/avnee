<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1000px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Refine Price Band
                    </h1>
                </div>
            </div>

            <form action="{{ route('admin.price-bands.update', $priceBand) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                <div class="glass-card rounded-2xl p-8 space-y-6 shadow-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Target Page Context</label>
                            <select name="brand_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" required>
                                <option value="">-- Select Storefront --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $priceBand->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Label (e.g., Under)</label>
                            <input type="text" name="label" value="{{ $priceBand->label }}" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Price Limit (INR)</label>
                            <input type="number" name="price_limit" value="{{ $priceBand->price_limit }}" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ $priceBand->sort_order }}" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" required>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Redirect Link (Optional)</label>
                        <input type="text" name="redirect_url" value="{{ $priceBand->redirect_url }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all">
                        <p class="text-[10px] text-gray-600 italic">Example: /products?max_price={{ $priceBand->price_limit }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-10 py-3.5 bg-[#b87333] text-white text-sm font-bold rounded-full shadow-lg shadow-[#b87333]/12 hover:bg-[#a6682d] transition-all active:scale-95">Save Changes</button>
                    <a href="{{ route('admin.price-bands.index') }}" class="text-sm font-bold text-gray-500 hover:text-white transition-colors">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
