<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Flash Sale') }}: {{ $flashSale->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.flash-sales.update', $flashSale) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Details -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 border-b pb-2">Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="title" :value="__('Campaign Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $flashSale->title)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="image" :value="__('Campaign Banner (1200x400 recommended)')" />
                                    @if($flashSale->image)
                                        <div class="relative group mt-2 mb-4">
                                            <img src="{{ asset('storage/' . $flashSale->image) }}" class="w-full h-32 object-cover rounded shadow-sm border p-1 bg-gray-50" />
                                            <div class="mt-2 flex items-center">
                                                <input type="checkbox" name="remove_image" id="remove_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                                <label for="remove_image" class="ml-2 text-xs text-red-600 font-bold uppercase tracking-widest">Remove Current Banner</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input id="image" name="image" type="file" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                </div>

                                <div>
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <input id="start_time" name="start_time" type="datetime-local" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('start_time', $flashSale->start_time->format('Y-m-d\TH:i'))" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                                </div>

                                <div>
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <input id="end_time" name="end_time" type="datetime-local" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('end_time', $flashSale->end_time->format('Y-m-d\TH:i'))" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                                </div>

                                <div class="flex items-center">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $flashSale->is_active ? 'checked' : '' }} />
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-medium">Is Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.flash-sales.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Campaign') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Right Column: Products Selection -->
                    @php
                        $selectedProductIds = $flashSale->items->pluck('product_id')->toArray();
                        $itemsByProductId = $flashSale->items->keyBy('product_id');
                    @endphp
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 border-b pb-2">Select Products & Discounts</h3>
                            
                            <div class="mb-4">
                                <input type="text" id="product-search" placeholder="Search products..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 p-2 focus:ring-indigo-500" />
                            </div>

                            <div class="max-h-[600px] overflow-y-auto pr-2 space-y-4" id="products-list">
                                @foreach($products as $product)
                                @php
                                    $isSelected = in_array($product->id, $selectedProductIds);
                                    $item = $isSelected ? $itemsByProductId[$product->id] : null;
                                @endphp
                                <div class="flex items-center justify-between p-3 border {{ $isSelected ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/10' : 'dark:border-gray-700' }} rounded-lg product-item" data-name="{{ strtolower($product->name) }}">
                                    <div class="flex items-center space-x-4">
                                        <input type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}" class="product-check rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $isSelected ? 'checked' : '' }} />
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded" />
                                        @endif
                                        <div>
                                            <div class="text-sm font-bold">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="text-right">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400">Discount %</label>
                                            <input type="number" name="products[{{ $loop->index }}][discount_percentage]" placeholder="15" min="1" max="100" class="w-20 text-xs rounded border-gray-300 dark:bg-gray-900 p-1" value="{{ $item ? $item->discount_percentage : '' }}" />
                                        </div>
                                        <div class="text-right">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400">Order</label>
                                            <input type="number" name="products[{{ $loop->index }}][sort_order]" placeholder="0" class="w-14 text-xs rounded border-gray-300 dark:bg-gray-900 p-1" value="{{ $item ? $item->sort_order : 0 }}" />
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('product-search').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(term)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        // Add visual highlighting for selected products
        document.querySelectorAll('.product-check').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const parent = this.closest('.product-item');
                if (this.checked) {
                    parent.classList.add('border-indigo-600', 'bg-indigo-50', 'dark:bg-indigo-900/10');
                } else {
                    parent.classList.remove('border-indigo-600', 'bg-indigo-50', 'dark:bg-indigo-900/10');
                }
            });
        });
    </script>
</x-admin-layout>
