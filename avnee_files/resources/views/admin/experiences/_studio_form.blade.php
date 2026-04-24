<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <div class="lg:col-span-2 space-y-8">
        <div class="glass-card rounded-2xl p-8 space-y-6 shadow-2xl">
            <h3 class="text-sm font-bold uppercase tracking-widest text-[#b87333] mb-4">Studio Copy</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ $setting->subtitle }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Title</label>
                    <input type="text" name="title" value="{{ $setting->title }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 font-heading tracking-widest">
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Description</label>
                <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300">{{ $setting->description }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Button Text</label>
                    <input type="text" name="button_text" value="{{ $setting->button_text }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Button Link</label>
                    <input type="text" name="button_link" value="{{ $setting->button_link }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 font-mono">
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <h3 class="text-sm font-bold uppercase tracking-widest text-[#b87333] mb-8">Detail Showcase (Square 800x800)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @for($i=1; $i<=3; $i++)
                <div class="space-y-4">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500 text-center block">Detail Image #{{ $i }}</label>
                    <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-900 border border-white/10">
                        @php $field = "detail_image_$i"; @endphp
                        @if($setting->$field)
                            <img src="{{ asset('storage/'.$setting->$field) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-700">
                                <span class="material-symbols-outlined text-4xl">image</span>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="detail_image_{{ $i }}" class="text-[9px] text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:bg-[#b87333]/10 file:text-[#b87333] hover:file:bg-[#b87333]/20 mb-2">
                    @if($setting->$field)
                    <label class="flex items-center gap-1.5 cursor-pointer group">
                        <input type="checkbox" name="remove_detail_image_{{ $i }}" class="sr-only peer">
                        <div class="w-3.5 h-3.5 border border-white/20 rounded flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-all">
                            <span class="material-symbols-outlined text-[10px] text-white opacity-0 peer-checked:opacity-100">close</span>
                        </div>
                        <span class="text-[9px] text-gray-500 font-bold uppercase tracking-widest group-hover:text-red-400 transition-colors">Remove Image</span>
                    </label>
                    @endif
                </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="space-y-10">
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <h3 class="text-sm font-bold uppercase tracking-widest text-[#b87333] mb-6 block text-center">Main Campaign (3:4 Ratio, 1200x1600)</h3>
            <div class="relative group aspect-[3/4] rounded-2xl overflow-hidden bg-gray-900 border border-white/10 mb-6">
                @if($setting->main_video)
                    <video src="{{ asset('storage/'.$setting->main_video) }}" class="w-full h-full object-cover" autoplay muted loop></video>
                @elseif($setting->main_image)
                    <img src="{{ asset('storage/'.$setting->main_image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-700">
                        <span class="material-symbols-outlined text-6xl">videocam</span>
                    </div>
                @endif
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Image (3:4)</label>
                    <input type="file" name="main_image" class="text-[9px] text-gray-500 w-full mb-2">
                    @if($setting->main_image)
                    <label class="flex items-center gap-1.5 cursor-pointer group">
                        <input type="checkbox" name="remove_main_image" class="sr-only peer">
                        <div class="w-3.5 h-3.5 border border-white/20 rounded flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-all">
                            <span class="material-symbols-outlined text-[10px] text-white opacity-0 peer-checked:opacity-100">close</span>
                        </div>
                        <span class="text-[9px] text-gray-500 font-bold uppercase tracking-widest group-hover:text-red-400 transition-colors">Remove Current Image</span>
                    </label>
                    @endif
                </div>
                <div>
                    <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Video (Optional, 3:4)</label>
                    <input type="file" name="main_video" class="text-[9px] text-gray-500 w-full mb-2" accept="video/mp4,video/quicktime">
                    @if($setting->main_video)
                    <label class="flex items-center gap-1.5 cursor-pointer group">
                        <input type="checkbox" name="remove_main_video" class="sr-only peer">
                        <div class="w-3.5 h-3.5 border border-white/20 rounded flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-all">
                            <span class="material-symbols-outlined text-[10px] text-white opacity-0 peer-checked:opacity-100">close</span>
                        </div>
                        <span class="text-[9px] text-gray-500 font-bold uppercase tracking-widest group-hover:text-red-400 transition-colors">Remove Current Video</span>
                    </label>
                    @endif
                </div>
            </div>
            <div class="pt-6 border-t border-white/5 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 tracking-wider">VISIBILITY</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $setting->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#b87333]"></div>
                </label>
            </div>
        </div>
        <button type="submit" class="w-full py-4 bg-[#b87333] text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-full shadow-lg shadow-[#b87333]/30 hover:bg-[#a6682d] transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm">auto_fix_high</span> PUBLISH STUDIO EXPERIENCE
        </button>
    </div>
</div>
