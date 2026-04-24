<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
                Edit Combo: {{ $combo->title }}
            </h2>
            <a href="{{ route('admin.combos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.combos.update', $combo->id) }}" enctype="multipart/form-data" class="py-12">
        @csrf @method('PUT')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-semibold uppercase tracking-wider mb-2">Combo Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $combo->title) }}" required class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500" />
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-semibold uppercase tracking-wider mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500">{{ old('description', $combo->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="original_price" class="block text-sm font-semibold uppercase tracking-wider mb-2">Original Price Sum (₹)</label>
                                <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $combo->original_price) }}" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500" />
                                @error('original_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-semibold uppercase tracking-wider mb-2">Combo Special Price (₹)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $combo->price) }}" step="0.01" required class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500" />
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $combo->is_active ? 'checked' : '' }} />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Mark as Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold">Manage Products (Selected: {{ count($selectedProducts) }})</h3>
                            <div class="relative w-64">
                                <span class="absolute left-3 top-2 material-symbols-outlined text-gray-400 text-lg">search</span>
                                <input type="text" id="product_search" placeholder="Filter products..." class="w-full pl-10 pr-4 py-2 text-sm rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2" id="products_grid">
                            @foreach($products as $product)
                            <label class="product-item cursor-pointer block border border-transparent hover:border-indigo-300 dark:hover:border-indigo-600 rounded-lg p-2 transition-all relative" data-name="{{ strtolower($product->name) }}">
                                <input type="checkbox" name="products[]" value="{{ $product->id }}" class="peer sr-only" {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }} />
                                <div class="flex items-center gap-3 bg-white dark:bg-gray-700 p-2 rounded-lg peer-checked:border-2 peer-checked:border-indigo-500 shadow-sm h-full">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-20 object-cover rounded" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold truncate">{{ $product->name }}</p>
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400">₹{{ number_format($product->price, 2) }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase tracking-tighter">{{ $product->category->name }}</p>
                                    </div>
                                    <div class="opacity-0 peer-checked:opacity-100 translate-x-2 peer-checked:translate-x-0 transition-all">
                                        <span class="material-symbols-outlined text-indigo-500 font-bold">check_circle</span>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('products') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-center">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <label class="block text-sm font-semibold uppercase tracking-wider mb-4">Combo Image</label>
                        <div class="relative group cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-2 aspect-square flex flex-col items-center justify-center hover:bg-gray-50 transition-colors" onclick="document.getElementById('image').click()">
                            <img id="image_preview" src="{{ $combo->image ? asset('storage/' . $combo->image) : '' }}" class="absolute inset-0 w-full h-full object-cover rounded-lg {{ $combo->image ? '' : 'hidden' }}" />
                            <div id="image_placeholder" class="{{ $combo->image ? 'hidden' : '' }}">
                                <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">add_photo_alternate</span>
                                <p class="text-xs text-gray-500">Click to change image</p>
                            </div>
                            @if($combo->image)
                                <div class="mt-2 flex items-center justify-center relative z-10">
                                    <input type="checkbox" name="remove_image" id="remove_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                    <label for="remove_image" class="ml-2 text-[10px] text-red-600 font-bold uppercase tracking-widest">Remove Current</label>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)" />
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <button type="submit" class="w-full h-14 bg-indigo-600 text-white font-bold uppercase tracking-widest rounded-lg hover:bg-indigo-700 transition-colors shadow-lg">
                        Update Combo deal
                    </button>
                    <p class="mt-4 text-[10px] text-gray-500 text-center uppercase tracking-tight">Changes will reflect immediately <br/> on the storefront if active</p>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <h4 class="text-red-800 dark:text-red-400 font-bold text-xs uppercase mb-2">Danger Zone</h4>
                    <p class="text-[10px] text-red-600 dark:text-red-500 mb-3">Deleting this combo will remove the bundle from the store, but won't delete individual products.</p>
                </div>
            </div>
        </div>
    </form>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            const placeholder = document.getElementById('image_placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Product search filter
        document.getElementById('product_search').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                if (item.getAttribute('data-name').includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</x-admin-layout>
