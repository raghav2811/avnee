<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-5 text-gray-800 dark:text-gray-200">
            <a href="{{ route('admin.home-explore-grids.index') }}" class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all active:scale-90">
                <span class="material-symbols-outlined align-middle">arrow_back</span>
            </a>
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Add Explore Grid Item') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.home-explore-grids.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Brand Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 border border-gray-100 dark:border-gray-700">
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="brand_id" :value="__('Target Brand')" class="text-xs uppercase tracking-widest font-bold text-gray-500" />
                                    <select id="brand_id" name="brand_id" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('brand_id')" />
                                </div>

                                <div>
                                    <x-input-label for="title" :value="__('Narrative Title')" class="text-xs uppercase tracking-widest font-bold text-gray-500" />
                                    <x-text-input id="title" name="title" type="text" class="mt-2 block w-full bg-gray-50/50" :value="old('title')" required placeholder="e.g. Jewellery Edit" />
                                    <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="subtitle" :value="__('Contextual Subtitle')" class="text-xs uppercase tracking-widest font-bold text-gray-500" />
                                    <x-text-input id="subtitle" name="subtitle" type="text" class="mt-2 block w-full bg-gray-50/50" :value="old('subtitle')" placeholder="e.g. All That Jewels You Must Own" />
                                    <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('subtitle')" />
                                </div>

                                <div>
                                    <x-input-label for="redirect_url" :value="__('Redirection Target (Link)')" class="text-xs uppercase tracking-widest font-bold text-gray-500" />
                                    <x-text-input id="redirect_url" name="redirect_url" type="text" class="mt-2 block w-full bg-gray-50/50 font-mono text-sm" :value="old('redirect_url')" placeholder="/products?category=jewellery" />
                                    <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('redirect_url')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layout & Lifecycle -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 border border-gray-100 dark:border-gray-700">
                            <h3 class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">Grid Layout</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="grid_span" :value="__('Width Span')" class="text-xs uppercase tracking-widest font-bold text-gray-400" />
                                    <select id="grid_span" name="grid_span" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 bg-gray-50 font-bold" required>
                                        <option value="1" {{ old('grid_span') == 1 ? 'selected' : '' }}>1/4 Width (Small)</option>
                                        <option value="2" {{ old('grid_span') == 2 ? 'selected' : '' }}>2/4 Width (Large)</option>
                                    </select>
                                    <p class="mt-2 text-[10px] text-gray-400 italic">Determines if the block spans one or two grid columns. Top row usually spans 2.</p>
                                </div>

                                <div>
                                    <x-input-label for="sort_order" :value="__('Priority Order')" class="text-xs uppercase tracking-widest font-bold text-gray-400" />
                                    <x-text-input id="sort_order" name="sort_order" type="number" class="mt-2 block w-full font-mono" :value="old('sort_order', 0)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                                </div>

                                <div class="flex items-center pt-2">
                                    <x-checkbox id="is_active" name="is_active" :checked="old('is_active', true)" />
                                    <x-input-label for="is_active" :value="__('Status Active')" class="ml-2 text-xs uppercase tracking-widest font-bold text-gray-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 border border-gray-100 dark:border-gray-700">
                            <h3 class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">Media Asset</h3>
                            <div class="space-y-4">
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md bg-gray-50/50 hover:bg-gray-50 hover:border-gray-400 dark:hover:bg-gray-700/50 transition-all cursor-pointer relative">
                                    <div class="space-y-1 text-center">
                                        <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <label for="image" class="relative cursor-pointer font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload Asset</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">750x1000 recommended for 3:4 aspect</p>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center py-4 bg-gray-900 border-none shadow-xl hover:bg-black transition-all">
                            {{ __('Protocol Transmission') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
