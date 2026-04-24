<x-admin-layout>
    <div class="px-6 py-8 sm:px-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <a href="{{ route('admin.reviews.index') }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-3xl font-heading font-normal tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Manual Feedback</h1>
                    <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest text-[10px]">Add collected reviews from other platforms</p>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 sm:p-10 border border-white/5 shadow-2xl relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-64 h-64 bg-indigo-500/5 rounded-full blur-[100px]"></div>

                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8" x-data="{ imagePreview: null }">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Brand Selection -->
                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Select Storefront</label>
                            <select name="brand_id" required class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-[#b87333]/50 focus:ring-0 transition-all text-sm appearance-none">
                                <option value="" disabled selected>— Select Storefront —</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Product Selection -->
                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Select Product</label>
                            <select name="product_id" required class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-[#b87333]/50 focus:ring-0 transition-all text-sm appearance-none">
                                <option value="" disabled selected>— Product Selection —</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customer Name -->
                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Customer Name</label>
                            <input type="text" name="user_name" required placeholder="e.g. Priyansha Sharma" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-[#b87333]/50 focus:ring-0 transition-all text-sm">
                            @error('user_name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Location -->
                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Customer Location</label>
                            <input type="text" name="location" placeholder="e.g. Bangalore, India" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-[#b87333]/50 focus:ring-0 transition-all text-sm">
                            @error('location') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="space-y-4">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Feature Image</label>
                            <div class="flex items-start gap-6">
                                <div class="relative w-32 h-32 rounded-2xl border-2 border-dashed border-white/10 flex items-center justify-center overflow-hidden bg-white/5 mx-auto sm:mx-0">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <span class="material-symbols-outlined text-white/20 text-3xl">image</span>
                                    </template>
                                </div>
                                <div class="flex-1 space-y-3">
                                    <input type="file" name="image" @change="imagePreview = URL.createObjectURL($event.target.files[0])" class="hidden" id="review_image" accept="image/*">
                                    <label for="review_image" class="inline-flex items-center px-6 py-2.5 bg-white/5 border border-white/10 rounded-xl text-xs font-bold text-white uppercase tracking-widest hover:bg-white/10 transition-all cursor-pointer">
                                        Select Image
                                    </label>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest leading-relaxed">Square image recommended (Max 2MB). Ideal for customer portrait.</p>
                                </div>
                            </div>
                            @error('image') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Rating & Status -->
                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Experience Tier</label>
                            <div class="flex gap-4">
                                @for($i=1;$i<=5;$i++)
                                <label class="cursor-pointer group flex-1">
                                    <input type="radio" name="rating" value="{{ $i }}" class="peer hidden" {{ $i == 5 ? 'checked' : '' }}>
                                    <div class="w-full py-3 bg-white/5 border border-white/5 rounded-xl flex flex-col items-center justify-center transition-all peer-checked:bg-[#b87333]/20 peer-checked:border-[#b87333]/40 group-hover:bg-white/10">
                                        <span class="material-symbols-outlined text-sm peer-checked:text-[#b87333] {{ $i <= 5 ? 'text-yellow-500' : 'text-gray-500' }}">star</span>
                                        <span class="text-[10px] font-bold mt-1 text-gray-400 peer-checked:text-white">{{ $i }}</span>
                                    </div>
                                </label>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="space-y-2">
                        <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Customer Narrative</label>
                        <textarea name="comment" rows="6" required placeholder="Paste the customer's exact words here..." class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-[#b87333]/50 focus:ring-0 transition-all text-sm resize-none"></textarea>
                        @error('comment') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-gradient-to-r from-[#b87333] to-purple-800 text-white px-10 py-3.5 text-xs font-bold uppercase tracking-[0.25em] hover:shadow-[0_0_20px_rgba(184,115,51,0.3)] transition-all rounded-sm active:scale-95">
                            Publish Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
