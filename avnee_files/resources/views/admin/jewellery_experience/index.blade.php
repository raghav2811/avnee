<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-[1200px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                        Jewellery Experience
                    </h1>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-lg">Control the artisanal storytelling section for your Jewellery storefront.</p>
                </div>
            </div>

            <form action="{{ route('admin.jewellery-experience.update', $setting) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left: Content Settings -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="glass-card rounded-2xl p-8 space-y-6 shadow-2xl">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-purple-400 mb-4">Master Copy</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Subtitle (Heading Top)</label>
                                    <input type="text" name="subtitle" value="{{ $setting->subtitle }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-purple-500 transition-all" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Main Title</label>
                                    <input type="text" name="title" value="{{ $setting->title }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 font-heading tracking-widest focus:outline-none focus:ring-1 focus:ring-purple-500 transition-all" required>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Heritage Description</label>
                                <textarea name="description" rows="4" 
                                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-purple-500 transition-all">{{ $setting->description }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Button Text</label>
                                    <input type="text" name="button_text" value="{{ $setting->button_text }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-purple-500 transition-all" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] items-center px-4 py-2 font-bold uppercase tracking-[0.2em] text-gray-500">Target URL</label>
                                    <input type="text" name="button_link" value="{{ $setting->button_link }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-purple-500 transition-all" required>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card rounded-2xl p-8 shadow-2xl">
                             <h3 class="text-sm font-bold uppercase tracking-widest text-purple-400 mb-8">Craft Details (3 Images)</h3>
                             <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                @for($i=1; $i<=3; $i++)
                                <div class="space-y-4">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Detail #{{ $i }}</label>
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
                                    <input type="file" name="detail_image_{{ $i }}" class="block w-full text-[9px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-purple-900/10 file:text-purple-400 hover:file:bg-purple-900/20 transition-all">
                                </div>
                                @endfor
                             </div>
                        </div>
                    </div>

                    <!-- Right: Sticky Main Image & Master Toggle -->
                    <div class="space-y-8 lg:sticky lg:top-8 lg:h-fit">
                        <div class="glass-card rounded-2xl p-8 shadow-2xl">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-purple-400 mb-6">Main Campaign</h3>
                            <div class="relative group aspect-[3/4] rounded-2xl overflow-hidden bg-gray-900 border border-white/10 mb-6">
                                @if($setting->main_image)
                                    <img src="{{ asset('storage/'.$setting->main_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-700">
                                        <span class="material-symbols-outlined text-6xl">photo_camera</span>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="main_image" class="block w-full text-[9px] text-gray-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-purple-900/10 file:text-purple-400 hover:file:bg-purple-900/20 transition-all">

                            <div class="mt-8 pt-6 border-t border-white/5 space-y-4">
                                <h3 class="text-[10px] font-bold uppercase tracking-widest text-purple-400">Atmospheric Video</h3>
                                @if($setting->main_video)
                                    <div class="aspect-[3/4] rounded-xl overflow-hidden bg-black border border-white/10 mb-4">
                                        <video src="{{ asset('storage/'.$setting->main_video) }}" class="w-full h-full object-cover" autoplay muted loop></video>
                                    </div>
                                @endif
                                <input type="file" name="main_video" class="block w-full text-[9px] text-gray-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-purple-900/10 file:text-purple-400 hover:file:bg-purple-900/20 transition-all focus:outline-none">
                                <p class="text-[9px] text-gray-600 italic">Portrait MP4 recommended (Max 20MB)</p>
                            </div>

                            <div class="pt-6 mt-6 border-t border-white/5 flex items-center justify-between">
                                 <span class="text-xs font-bold text-gray-400 tracking-wider">VISIBILITY</span>
                                 <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $setting->is_active ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button type="submit" class="w-full py-4 bg-purple-600 text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-full shadow-lg shadow-purple-600/12 hover:bg-purple-700 transition-all active:scale-95 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">auto_fix_high</span>
                                Update Showcase
                            </button>
                            <p class="text-[9px] text-gray-600 text-center italic uppercase tracking-widest opacity-60">Manifests on Jewellery storefront</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
