<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Banner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b mb-6">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Title (Optional)</label>
                                <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>

                            <!-- Sub Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Subtitle (Optional)</label>
                                <input type="text" name="sub_title" value="{{ old('sub_title', $banner->sub_title) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>
                        </div>
                            <!-- Image -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image (1920x800 recommended)</label>
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="" class="h-32 rounded shadow-sm border p-1 bg-gray-50">
                                    <div class="mt-2 flex items-center">
                                        <input type="checkbox" name="remove_image" id="remove_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                        <label for="remove_image" class="ml-2 text-xs text-red-600 font-bold uppercase tracking-widest">Remove Current Image</label>
                                    </div>
                                </div>
                                <input type="file" name="image" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 mt-1 italic">Selecting a new file will automatically replace the existing one.</p>
                                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Link -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link URL</label>
                                <input type="text" name="link" value="{{ old('link', $banner->link) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                                <select name="location" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="home_top" {{ $banner->location == 'home_top' ? 'selected' : '' }}>Studio Page - Main Slider</option>
                                    <option value="jewellery_top" {{ $banner->location == 'jewellery_top' ? 'selected' : '' }}>Jewellery Page - Main Slider</option>
                                    <option value="home_first_sale" {{ $banner->location == 'home_first_sale' ? 'selected' : '' }}>Studio Page - First Sale 3-Block Rail</option>
                                    <option value="jewellery_first_sale" {{ $banner->location == 'jewellery_first_sale' ? 'selected' : '' }}>Jewellery Page - First Sale 3-Block Rail</option>
                                </select>
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Context (Type)</label>
                                <select name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="studio" {{ $banner->type == 'studio' ? 'selected' : '' }}>Studio</option>
                                    <option value="jewellery" {{ $banner->type == 'jewellery' ? 'selected' : '' }}>Jewellery</option>
                                </select>
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <!-- Is Active -->
                            <div class="flex items-center mt-6">
                                <input type="checkbox" name="is_active" id="is_active" {{ $banner->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300 italic">Is Active</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border rounded hover:bg-gray-50">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Banner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
