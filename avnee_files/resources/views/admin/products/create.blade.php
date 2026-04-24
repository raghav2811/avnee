<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <span class="material-symbols-outlined align-middle">arrow_back</span>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="productForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Content Column -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Basic Info -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Basic Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name *</label>
                                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"></textarea>
                                </div>

                                <div>
                                    <label for="care_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Care Instructions</label>
                                    <textarea name="care_instructions" id="care_instructions" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Media / Photos & Video -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Media</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Images -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Images</label>
                                    <div class="mt-1">
                                        <!-- Preview Container -->
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
                                                        <span>Upload Images</span>
                                                        <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only" @change="previewImages($event)">
                                                    </label>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Video (Hover Play)</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                                        <div class="space-y-1 text-center">
                                            <span class="material-symbols-outlined text-4xl text-gray-400">videocam</span>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                                <label for="video" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                    <span>Upload Video</span>
                                                    <input id="video" name="video" type="file" accept="video/*" class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">MP4, MOV up to 20MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Variants -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Product Variants</h3>
                            
                            <div class="space-y-4">
                                <template x-for="(variant, index) in variants" :key="index">
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-700/50 relative">
                                        <button type="button" @click="removeVariant(index)" class="absolute top-2 right-2 text-red-500 hover:text-red-700" :disabled="variants.length === 1">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">SKU *</label>
                                                <input type="text" x-model="variant.sku" :name="`variants[${index}][sku]`" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                <input type="text" x-model="variant.colour" :name="`variants[${index}][colour]`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                <input type="text" x-model="variant.size" :name="`variants[${index}][size]`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Stock *</label>
                                                <input type="number" x-model="variant.stock" :name="`variants[${index}][stock]`" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Price (₹) *</label>
                                                <input type="number" step="0.01" x-model="variant.price" :name="`variants[${index}][price]`" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Compare Price</label>
                                                <input type="number" step="0.01" x-model="variant.compare_price" :name="`variants[${index}][compare_price]`" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white sm:text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <button type="button" @click="addVariant" class="mt-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 flex items-center">
                                    <span class="material-symbols-outlined mr-1 text-sm">add_circle</span> Add another variant
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar Column -->
                    <div class="space-y-6">
                        
                        <!-- Organization -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Organization</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand / Site *</label>
                                    <select name="brand_id" id="brand_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        <option value="">No Category</option>
                                        @foreach($categories->whereNull('parent_id') as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->brand->name }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="subcategory_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Category (Optional)</label>
                                    <select name="subcategory_id" id="subcategory_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        <option value="">No Sub Category</option>
                                        @foreach($categories->whereNotNull('parent_id') as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->name }} (Parent: {{ $sub->parent->name ?? 'None' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Visibility -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Status</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Active (Visible)</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input id="is_featured" name="is_featured" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Featured</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="hidden" name="is_returnable" value="0">
                                    <input id="is_returnable" name="is_returnable" type="checkbox" value="1" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_returnable" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">This product is returnable</label>
                                </div>
                                
                                <div>
                                    <label for="weight_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight (grams)</label>
                                    <input type="number" step="0.01" name="weight_grams" id="weight_grams" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">SEO Context</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="w-full justify-center inline-flex rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                Save Product
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
                variants: [{ sku: '', colour: '', size: '', stock: 0, price: '', compare_price: '' }],
                imagePreviews: [],
                allCategories: @json($categories),
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
                    // Note: This doesn't remove from the input.files which is read-only, 
                    // but it helps visual feedback. For full control, complex JS is needed.
                },
                init() {
                    this.filterCategories();
                    // Add event listener for brand change
                    document.getElementById('brand_id').addEventListener('change', () => {
                        this.filterCategories();
                    });
                },
                filterCategories() {
                    const brandId = document.getElementById('brand_id').value;
                    const categorySelect = document.getElementById('category_id');
                    const subcategorySelect = document.getElementById('subcategory_id');
                    
                    // Clear current options
                    categorySelect.innerHTML = '<option value="">No Category</option>';
                    subcategorySelect.innerHTML = '<option value="">No Sub Category</option>';
                    
                    // Filter and populate categories based on selected brand
                    const filteredCategories = this.allCategories.filter(cat => cat.parent_id === null);
                    
                    if (brandId) {
                        // Show only categories for selected brand
                        filteredCategories.forEach(category => {
                            if (category.brand_id == brandId) {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                categorySelect.appendChild(option);
                            }
                        });
                    } else {
                        // Show all categories with brand names
                        filteredCategories.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = `${category.name} (${category.brand.name})`;
                            categorySelect.appendChild(option);
                        });
                    }
                    
                    // Populate subcategories
                    this.allCategories.filter(cat => cat.parent_id !== null).forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = `${subcategory.name} (Parent: ${subcategory.parent?.name || 'None'})`;
                        subcategorySelect.appendChild(option);
                    });
                }
            }))
        })
    </script>
</x-admin-layout>
