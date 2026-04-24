<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Home Experience: ') . $homeSection->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 mb-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Section ID:</strong> <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-indigo-600 font-mono">{{ $homeSection->section_id }}</span>
                    <br>
                    <span class="mt-1 block italic opacity-70">Control which products appear in this section by checking them below.</span>
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Settings -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                            <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Context</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target Page (Studio or Jewellery)</label>
                                <select name="brand_id" id="brand_id_select" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required onchange="filterProductsByBrand(this.value)">
                                    <option value="">-- Select Page --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $homeSection->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                            <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Display Settings</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Public Title</label>
                                    <input type="text" name="title" value="{{ old('title', $homeSection->title) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Layout Template</label>
                                    <select name="section_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Choose Layout --</option>
                                        <option value="shop_by_style" {{ old('section_id', $homeSection->section_id) == 'shop_by_style' ? 'selected' : '' }}>Shop By Style (Square Grid)</option>
                                        <option value="just_in" {{ old('section_id', $homeSection->section_id) == 'just_in' || old('section_id', $homeSection->section_id) == 'just_in_jewellery'  ? 'selected' : '' }}>Just In (Banner Experience)</option>
                                        <option value="shop_by_price" {{ old('section_id', $homeSection->section_id) == 'shop_by_price' || old('section_id', $homeSection->section_id) == 'shop_by_price_jewellery' ? 'selected' : '' }}>Shop By Price (Round Badges)</option>
                                        <option value="best_buys" {{ old('section_id', $homeSection->section_id) == 'best_buys' || old('section_id', $homeSection->section_id) == 'best_buys_jewellery' ? 'selected' : '' }}>Best Buys (Product Slider)</option>
                                        <option value="shop_the_look" {{ old('section_id', $homeSection->section_id) == 'shop_the_look' || old('section_id', $homeSection->section_id) == 'shop_the_look_jewellery' ? 'selected' : '' }}>Shop The Look (Video/Image Grid)</option>
                                        <option value="top_collections" {{ old('section_id', $homeSection->section_id) == 'top_collections' || old('section_id', $homeSection->section_id) == 'top_collections_jewellery' ? 'selected' : '' }}>Top Collections (Featured Grid)</option>
                                        <option value="popular_pieces" {{ old('section_id', $homeSection->section_id) == 'popular_pieces' || old('section_id', $homeSection->section_id) == 'popular_pieces_jewellery' ? 'selected' : '' }}>Bestselling Styles (Simple Slider)</option>
                                    </select>
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Determines the visual style and behavior on the homepage.</p>
                                    @error('section_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle / Tagline</label>
                                    <input type="text" name="subtitle" value="{{ old('subtitle', $homeSection->subtitle) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @error('subtitle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Products</label>
                                    <input type="number" name="limit" value="{{ old('limit', $homeSection->limit) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @error('limit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $homeSection->sort_order) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @error('sort_order') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center pt-2">
                                    <input type="checkbox" name="is_active" id="is_active" {{ $homeSection->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition cursor-pointer">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300 font-bold">Enabled</label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                            <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Image & Link</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Redirect URL</label>
                                    <input type="text" name="redirect_url" value="{{ old('redirect_url', $homeSection->redirect_url) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Feature Image</label>
                                    @if($homeSection->image)
                                        <div class="mt-2 mb-4 bg-gray-50 border p-2 rounded">
                                            <img src="{{ asset('storage/' . $homeSection->image) }}" alt="" class="max-h-32 mx-auto rounded">
                                            <div class="mt-2 flex items-center justify-center">
                                                <input type="checkbox" name="remove_image" id="remove_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                                <label for="remove_image" class="ml-2 text-xs text-red-600 font-bold uppercase tracking-widest">Remove Current</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col gap-3">
                            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-lg transform transition active:scale-95">Save Changes</button>
                            <a href="{{ route('admin.home-sections.index') }}" class="w-full px-6 py-3 text-center text-sm text-gray-700 dark:text-gray-300 border rounded-lg hover:bg-gray-50 font-medium tracking-wide">Return to List</a>
                        </div>
                    </div>

                    <!-- Right Column: Product Picker -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg flex flex-col h-full overflow-hidden">
                            <div class="p-6 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pin Products to this Section</h3>
                                <span class="text-xs text-gray-500 italic">Select context first to see products</span>
                            </div>
                            
                            <div class="p-4 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                <input type="text" id="productSearch" placeholder="Search by name..." class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500">
                            </div>

                            <div id="product-grid" class="flex-1 min-h-[500px] max-h-[800px] overflow-y-auto p-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 bg-gray-50/30 dark:bg-gray-900/10">
                                @foreach($products as $product)
                                    <label class="product-item hidden relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all {{ is_array($homeSection->product_ids) && in_array($product->id, $homeSection->product_ids) ? 'bg-indigo-50 border-indigo-500 dark:bg-indigo-900/20' : 'bg-white border-transparent dark:bg-gray-800' }}" 
                                           data-name="{{ strtolower($product->name) }}" data-brand="{{ $product->brand_id }}">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer"
                                                {{ is_array($homeSection->product_ids) && in_array($product->id, $homeSection->product_ids) ? 'checked' : '' }}
                                                onchange="toggleProductStyle(this)">
                                        </div>
                                        <div class="ml-4 flex gap-3 w-full min-w-0">
                                            <div class="h-14 w-14 shrink-0 overflow-hidden rounded bg-gray-50 border">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-gray-300">
                                                        <span class="material-symbols-outlined text-sm">image</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $product->name }}</p>
                                                <p class="text-[10px] text-gray-500 truncate">{{ $product->category?->name }}</p>
                                                <p class="text-[11px] font-bold text-indigo-600 mt-1">₹{{ number_format($product->price, 0) }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('product_ids')
                                <div class="px-6 py-2 bg-red-50 text-red-600 text-xs border-t border-red-100">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterProductsByBrand(brandId) {
            const products = document.querySelectorAll('.product-item');
            const searchContainer = document.querySelector('.italic');
            
            if(!brandId) {
                products.forEach(p => p.classList.add('hidden'));
                searchContainer.textContent = 'Select context first to see products';
                return;
            }

            searchContainer.textContent = 'Filtering available products...';
            products.forEach(p => {
                const brandMatch = p.getAttribute('data-brand') == brandId;
                const isChecked = p.querySelector('input[type="checkbox"]').checked;
                
                if(brandMatch || isChecked) {
                    p.classList.remove('hidden');
                } else {
                    p.classList.add('hidden');
                }
            });
        }

        function toggleProductStyle(cb) {
            const item = cb.closest('.product-item');
            if(cb.checked) {
                item.classList.add('bg-indigo-50', 'border-indigo-500', 'dark:bg-indigo-900/20');
            } else {
                item.classList.remove('bg-indigo-50', 'border-indigo-500', 'dark:bg-indigo-900/20');
            }
        }

        document.getElementById('productSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const brandId = document.getElementById('brand_id_select').value;
            
            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.getAttribute('data-name');
                const brandMatch = !brandId || item.getAttribute('data-brand') == brandId;
                const nameMatch = name.includes(term);
                const isChecked = item.querySelector('input[type="checkbox"]').checked;
                
                if ((brandMatch && nameMatch) || (isChecked && nameMatch)) {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('flex');
                }
            });
        });

        // Run filter on load
        document.addEventListener('DOMContentLoaded', function() {
            filterProductsByBrand(document.getElementById('brand_id_select').value);
        });
    </script>
</x-admin-layout>
