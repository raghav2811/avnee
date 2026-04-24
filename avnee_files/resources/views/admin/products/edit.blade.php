<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">
                    <span class="material-symbols-outlined align-middle">arrow_back</span>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Product: ') . $product->name }}
                </h2>
            </div>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm flex items-center">
                    <span class="material-symbols-outlined mr-1 text-sm">delete</span> Delete
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6" x-data="productForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Content Column -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Basic Info -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Basic Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div>
                                    <label for="care_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Care Information</label>
                                    <textarea name="care_instructions" id="care_instructions" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('care_instructions', $product->care_instructions) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Media / Photos & Video -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Media</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Images Section -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manage Images</label>
                                    @if($product->images->count() > 0)
                                    <div class="mb-4 grid grid-cols-3 gap-2">
                                        @foreach($product->images as $image)
                                            <div class="relative group border rounded-md overflow-hidden bg-gray-50 flex items-center justify-center p-1">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="object-contain h-16 w-16">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="h-4 w-4 text-red-600 bg-white border-none rounded focus:ring-red-500 cursor-pointer">
                                                    <span class="ml-1 text-[8px] text-white font-bold uppercase">DELETE</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="mt-1">
                                        <!-- New Uploads Preview -->
                                        <div class="mb-4 grid grid-cols-4 gap-2" x-show="imagePreviews.length > 0">
                                            <template x-for="(src, index) in imagePreviews" :key="index">
                                                <div class="relative group border rounded-md overflow-hidden bg-gray-50 dark:bg-gray-700 flex items-center justify-center p-1 aspect-square">
                                                    <img :src="src" class="object-cover w-full h-full">
                                                    <button type="button" @click="removePreview(index)" class="absolute top-0 right-0 bg-red-500 text-white rounded-bl-md p-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                                            <div class="space-y-1 text-center">
                                                <span class="material-symbols-outlined text-4xl text-gray-400">add_photo_alternate</span>
                                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                                    <label for="images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                        <span>Upload New Images</span>
                                                        <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only" @change="previewImages($event)">
                                                    </label>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video Section -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hover Video</label>
                                    @if($product->video)
                                    <div class="mb-4 bg-gray-50 border rounded-md p-2 flex flex-col items-center">
                                        <video class="h-24 w-full bg-black rounded" controls>
                                            <source src="{{ asset('storage/' . $product->video) }}" type="video/mp4">
                                        </video>
                                        <div class="mt-2 flex items-center">
                                            <input type="checkbox" name="remove_video" id="remove_video" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                            <label for="remove_video" class="ml-2 text-[10px] text-red-600 font-bold uppercase tracking-[0.2em]">Remove Video</label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <span class="material-symbols-outlined text-4xl text-gray-400">videocam</span>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="video" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                    <span>{{ $product->video ? 'Change' : 'Upload' }} Video</span>
                                                    <input id="video" name="video" type="file" accept="video/*" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-400">MP4 recommended (Max 20MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Variants -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Product Variants</h3>
                            <div class="space-y-3">
                                <template x-for="(variant, index) in variants" :key="index">
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700/50 relative">
                                        <button type="button" @click="removeVariant(index)" class="absolute top-2 right-2 text-red-500 hover:text-red-700" :disabled="variants.length === 1">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                            <div class="col-span-1">
                                                <label class="block text-[10px] font-bold uppercase text-gray-500 dark:text-gray-400">SKU</label>
                                                <input type="text" x-model="variant.sku" :name="`variants[${index}][sku]`" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-xs shadow-sm focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold uppercase text-gray-500 dark:text-gray-400">Stock</label>
                                                <input type="number" x-model="variant.stock" :name="`variants[${index}][stock]`" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-xs shadow-sm focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold uppercase text-gray-500 dark:text-gray-400">Selling Price</label>
                                                <input type="number" step="0.01" x-model="variant.price" :name="`variants[${index}][price]`" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-xs shadow-sm focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold uppercase text-gray-500 dark:text-gray-400">Strike Price (Compare)</label>
                                                <input type="number" step="0.01" x-model="variant.compare_price" :name="`variants[${index}][compare_price]`" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-xs shadow-sm focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="addVariant" class="mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-500 flex items-center">
                                    <span class="material-symbols-outlined mr-1 text-sm">add</span> ADD VARIANT
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar Column -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Organization</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand *</label>
                                    <select name="brand_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                        <option value="">None</option>
                                        @foreach($categories->whereNull('parent_id') as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Category (Optional)</label>
                                    <select name="subcategory_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                        <option value="">None</option>
                                        @foreach($categories->whereNotNull('parent_id') as $sub)
                                            <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }} (Parent: {{ $sub->parent->name ?? 'None' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Status & Logistics</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center">
                                        <input type="hidden" name="is_active" value="0">
                                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ $product->is_active ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 focus:ring-indigo-500">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Active</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="hidden" name="is_featured" value="0">
                                        <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ $product->is_featured ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 focus:ring-indigo-500">
                                        <label for="is_featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Featured Product</label>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <input type="hidden" name="is_returnable" value="0">
                                    <input id="is_returnable" name="is_returnable" type="checkbox" value="1" {{ $product->is_returnable ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 focus:ring-indigo-500">
                                    <label for="is_returnable" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">This product is returnable</label>
                                </div>
                                
                                <div>
                                    <label for="weight_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight (grams)</label>
                                    <input type="number" step="0.01" name="weight_grams" id="weight_grams" value="{{ old('weight_grams', $product->weight_grams) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">SEO Context</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <button type="submit" class="w-full justify-center inline-flex rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                Update Product
                            </button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productForm', () => ({
                variants: @json($product->variants),
                imagePreviews: [],
                allCategories: @json($categories),
                currentBrandId: '{{ $product->brand_id }}',
                addVariant() { this.variants.push({ sku: '', colour: '', size: '', stock: 0, price: '', compare_price: '' }); },
                removeVariant(index) { if (this.variants.length > 1) { this.variants.splice(index, 1); } },
                previewImages(event) {
                    const files = event.target.files;
                    this.imagePreviews = [];
                    for (let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                },
                removePreview(index) {
                    this.imagePreviews.splice(index, 1);
                },
                init() {
                    this.filterCategories();
                    // Add event listener for brand change
                    document.querySelector('select[name="brand_id"]').addEventListener('change', () => {
                        this.filterCategories();
                    });
                },
                filterCategories() {
                    const brandId = document.querySelector('select[name="brand_id"]').value;
                    const categorySelect = document.querySelector('select[name="category_id"]');
                    const subcategorySelect = document.querySelector('select[name="subcategory_id"]');
                    
                    // Store current selections
                    const currentCategoryId = categorySelect.value;
                    const currentSubcategoryId = subcategorySelect.value;
                    
                    // Clear current options
                    categorySelect.innerHTML = '<option value="">None</option>';
                    subcategorySelect.innerHTML = '<option value="">None</option>';
                    
                    // Filter and populate categories based on selected brand
                    const filteredCategories = this.allCategories.filter(cat => cat.parent_id === null);
                    
                    if (brandId) {
                        // Show only categories for selected brand
                        filteredCategories.forEach(category => {
                            if (category.brand_id == brandId) {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                option.selected = category.id == currentCategoryId;
                                categorySelect.appendChild(option);
                            }
                        });
                    } else {
                        // Show all categories with brand names
                        filteredCategories.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = `${category.name} (${category.brand.name})`;
                            option.selected = category.id == currentCategoryId;
                            categorySelect.appendChild(option);
                        });
                    }
                    
                    // Populate subcategories
                    this.allCategories.filter(cat => cat.parent_id !== null).forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = `${subcategory.name} (Parent: ${subcategory.parent?.name || 'None'})`;
                        option.selected = subcategory.id == currentSubcategoryId;
                        subcategorySelect.appendChild(option);
                    });
                }
            }))
        })
    </script>
</x-admin-layout>
