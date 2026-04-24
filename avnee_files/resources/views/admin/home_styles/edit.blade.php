<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[700px] mx-auto">
            <div class="bg-gradient-to-br from-[#1c181d] to-[#120e11] rounded-[40px] p-12 border border-white/5 shadow-2xl">
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-[#b87333]/10 rounded-3xl flex items-center justify-center mb-8 border border-[#b87333]/20 shadow-xl">
                        <span class="material-symbols-outlined text-[#b87333] text-3xl">style</span>
                    </div>
                    <h1 class="text-4xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent mb-2">Refine Style</h1>
                    <p class="text-sm text-gray-500 mb-12 uppercase tracking-[0.2em] font-bold">Adjust Style Presentation</p>
                </div>

                <form action="{{ route('admin.home-styles.update', $homeStyle) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-8">
                        <div class="space-y-4">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-[#b87333]">Brand Context</label>
                            <select name="brand_id" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all appearance-none" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $homeStyle->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Style Title</label>
                            <input type="text" name="title" value="{{ $homeStyle->title }}" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" placeholder="e.g., Infant Sets" required>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Redirect Link</label>
                            <input type="text" name="redirect_url" value="{{ $homeStyle->redirect_url }}" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" placeholder="/products?category=infant-sets">
                        </div>

                        <div class="space-y-4">
                             <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Style Image (Target: 1:1 Aspect)</label>
                             <div class="mt-2 flex justify-center px-6 pt-10 pb-12 border-2 border-white/10 border-dashed rounded-[32px] hover:border-[#b87333]/30 transition-all cursor-pointer bg-black/20 group relative overflow-hidden">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <div class="space-y-2 text-center group-hover:scale-110 transition-transform duration-500">
                                    <span class="material-symbols-outlined text-4xl text-gray-600 group-hover:text-[#b87333]">upload_file</span>
                                    <div class="flex text-xs text-gray-500 font-bold uppercase tracking-widest">
                                        <span>Click to refresh source image</span>
                                    </div>
                                    @if($homeStyle->image)
                                        <div class="mt-4 px-4 py-2 bg-black/40 rounded-full border border-white/5 mx-auto w-max max-w-[200px] truncate">
                                            <p class="text-[9px] text-gray-400 font-mono italic">{{ basename($homeStyle->image) }}</p>
                                        </div>
                                    @endif
                                </div>
                             </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="space-y-4">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Priority Order</label>
                                <input type="number" name="sort_order" value="{{ $homeStyle->sort_order }}" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300">
                            </div>
                            <div class="flex items-center gap-3 pt-6">
                                <input type="checkbox" name="is_active" value="1" {{ $homeStyle->is_active ? 'checked' : '' }} class="w-4 h-4 rounded-sm bg-[#350047] border-white/10 text-[#b87333] focus:ring-Offset-0 focus:ring-transparent transition-all">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Is Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-8">
                        <button type="submit" class="flex-1 py-5 bg-white text-black text-[11px] font-bold uppercase tracking-[0.3em] rounded-full shadow-2xl hover:bg-gray-200 transition-all active:scale-95">
                             Refine Style
                        </button>
                        <a href="{{ route('admin.home-styles.index') }}" class="py-5 px-10 border border-white/5 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] rounded-full hover:text-white transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
