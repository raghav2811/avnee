<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[700px] mx-auto">
            <div class="bg-gradient-to-br from-[#1c181d] to-[#120e11] rounded-[40px] p-12 border border-white/5 shadow-2xl animate-fadeIn">
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-[#b87333]/10 rounded-3xl flex items-center justify-center mb-8 border border-[#b87333]/20 shadow-xl overflow-hidden relative">
                        <img src="{{ asset('storage/'.$justInExperience->image) }}" class="absolute inset-0 w-full h-full object-cover grayscale opacity-40">
                        <span class="material-symbols-outlined text-[#b87333] text-3xl relative z-10">edit</span>
                    </div>
                    <h1 class="text-4xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent mb-2">Refine Visual</h1>
                    <p class="text-sm text-gray-500 mb-12 uppercase tracking-[0.2em] font-bold">{{ $justInExperience->brand->name }} Card Override</p>
                </div>

                <form action="{{ route('admin.just-in-experiences.update', $justInExperience) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-8">
                        <div class="space-y-4">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-[#b87333]">Storefront Brand</label>
                            <select name="brand_id" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all appearance-none" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == $justInExperience->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="space-y-4">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Main Title</label>
                                <input type="text" name="title" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" value="{{ $justInExperience->title }}" required>
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Subtitle</label>
                                <input type="text" name="subtitle" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" value="{{ $justInExperience->subtitle }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="space-y-4">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Button Text</label>
                                <input type="text" name="button_text" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" value="{{ $justInExperience->button_text }}" required>
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Redirect Link</label>
                                <input type="text" name="button_link" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-[#b87333] transition-all" value="{{ $justInExperience->button_link }}">
                            </div>
                        </div>

                        <div class="space-y-4">
                             <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Update Campaign Image (16:10 Ratio, 1600x1000)</label>
                             <div class="mt-2 flex flex-col items-center justify-center px-6 pt-10 pb-12 border-2 border-white/10 border-dashed rounded-[32px] hover:border-[#b87333]/30 transition-all cursor-pointer bg-black/20 group relative overflow-hidden">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <div class="space-y-2 text-center group-hover:scale-110 transition-transform duration-500">
                                    <span class="material-symbols-outlined text-4xl text-gray-600 group-hover:text-[#b87333]">photo_library</span>
                                    <div class="flex text-xs text-gray-500 font-bold uppercase tracking-widest">
                                        <span>Click to refresh source image</span>
                                    </div>
                                    <p class="text-[9px] text-gray-700 italic">Portrait (4:5) Recommended</p>
                                </div>
                             </div>
                             @if($justInExperience->image)
                             <div class="flex items-center justify-center pt-2">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="remove_image" value="1" class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-500 relative transition-all"></div>
                                    <span class="ml-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-red-400 transition-colors">Discard existing image</span>
                                </label>
                             </div>
                             @endif
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Sort Priority</label>
                            <input type="number" name="sort_order" class="w-full bg-[#350047]/50 border border-white/10 rounded-2xl px-6 py-4 text-sm text-gray-300" value="{{ $justInExperience->sort_order }}">
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-8">
                        <button type="submit" class="flex-1 py-5 bg-white text-black text-[11px] font-bold uppercase tracking-[0.3em] rounded-full shadow-2xl hover:bg-gray-200 transition-all active:scale-95">
                             Override & Refine
                        </button>
                        <a href="{{ route('admin.just-in-experiences.index') }}" class="py-5 px-10 border border-white/5 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] rounded-full hover:text-white transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
