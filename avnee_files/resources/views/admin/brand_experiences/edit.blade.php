<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Brand Experience') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.brand-experiences.update', $brandExperience) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Left Column: Core Details -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 border-b pb-2">Experience Settings</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <x-input-label for="brand_id" :value="__('Select Brand')" />
                                    <select id="brand_id" name="brand_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $brandExperience->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('brand_id')" />
                                </div>
                                <div>
                                    <x-input-label for="layout_type" :value="__('Layout Type')" />
                                    <select id="layout_type" name="layout_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="layout_1" {{ $brandExperience->layout_type == 'layout_1' ? 'selected' : '' }}>Layout 1 (Editorial Stack)</option>
                                        <option value="layout_2" {{ $brandExperience->layout_type == 'layout_2' ? 'selected' : '' }}>Layout 2 (Visual Grid)</option>
                                        <option value="layout_3" {{ $brandExperience->layout_type == 'layout_3' ? 'selected' : '' }}>Layout 3 (Classic Split Grid)</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('layout_type')" />
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="title" :value="__('Main Title (e.g. The Fun Trinkets Edit)')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $brandExperience->title)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="content_title" :value="__('Accent Title (e.g. Discover Cute Trinkets!)')" />
                                    <x-text-input id="content_title" name="content_title" type="text" class="mt-1 block w-full" :value="old('content_title', $brandExperience->content_title)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('content_title')" />
                                </div>

                                <div>
                                    <x-input-label for="content_description" :value="__('Description Text')" />
                                    <textarea id="content_description" name="content_description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content_description', $brandExperience->content_description) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('content_description')" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="button_text" :value="__('Button Text')" />
                                        <x-text-input id="button_text" name="button_text" type="text" class="mt-1 block w-full" :value="old('button_text', $brandExperience->button_text)" />
                                    </div>
                                    <div>
                                        <x-input-label for="button_link" :value="__('Button Link')" />
                                        <x-text-input id="button_link" name="button_link" type="text" class="mt-1 block w-full" :value="old('button_link', $brandExperience->button_link)" />
                                    </div>
                                </div>

                                <div class="flex items-center gap-6">
                                    <div>
                                        <x-input-label for="sort_order" :value="__('Order')" />
                                        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-20" :value="old('sort_order', $brandExperience->sort_order)" />
                                    </div>
                                    <div class="flex items-center pt-6">
                                        <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $brandExperience->is_active ? 'checked' : '' }} />
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-medium">Is Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.brand-experiences.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Experience') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Right Column: Images & Labels -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 border-b pb-2">Visuals & Grid</h3>
                            
                            <div class="space-y-6">
                                <!-- Image 1 -->
                                <div class="p-4 border border-dashed rounded-lg bg-gray-50 dark:bg-gray-700/30">
                                    <x-input-label for="image_1" :value="__('Image 1 (Large Image in Layout 1)')" />
                                    @if($brandExperience->image_1)
                                        <div class="mb-2 relative w-32">
                                            <img src="{{ asset('storage/'.$brandExperience->image_1) }}" class="rounded shadow-sm" />
                                            <label class="flex items-center mt-1">
                                                <input type="checkbox" name="remove_image_1" value="1" class="rounded border-gray-300 text-red-600 shadow-sm mr-1">
                                                <span class="text-[10px] text-red-600 font-bold uppercase">Remove</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input id="image_1" name="image_1" type="file" class="mt-1 block w-full text-xs" />
                                    <x-text-input name="image_1_label" placeholder="Panda Cuteness" class="mt-2 block w-full text-sm" :value="$brandExperience->image_1_label" />
                                </div>

                                <!-- Image 2 -->
                                <div class="p-4 border border-dashed rounded-lg bg-gray-50 dark:bg-gray-700/30">
                                    <x-input-label for="image_2" :value="__('Image 2 (Middle Top Stack in Layout 1)')" />
                                    @if($brandExperience->image_2)
                                        <div class="mb-2 relative w-32">
                                            <img src="{{ asset('storage/'.$brandExperience->image_2) }}" class="rounded shadow-sm" />
                                            <label class="flex items-center mt-1">
                                                <input type="checkbox" name="remove_image_2" value="1" class="rounded border-gray-300 text-red-600 shadow-sm mr-1">
                                                <span class="text-[10px] text-red-600 font-bold uppercase">Remove</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input id="image_2" name="image_2" type="file" class="mt-1 block w-full text-xs" />
                                    <x-text-input name="image_2_label" placeholder="Label for image 2" class="mt-2 block w-full text-sm" :value="$brandExperience->image_2_label" />
                                </div>

                                <!-- Image 3 -->
                                <div class="p-4 border border-dashed rounded-lg bg-gray-50 dark:bg-gray-700/30">
                                    <x-input-label for="image_3" :value="__('Image 3 (Middle Bottom Stack in Layout 1)')" />
                                    @if($brandExperience->image_3)
                                        <div class="mb-2 relative w-32">
                                            <img src="{{ asset('storage/'.$brandExperience->image_3) }}" class="rounded shadow-sm" />
                                            <label class="flex items-center mt-1">
                                                <input type="checkbox" name="remove_image_3" value="1" class="rounded border-gray-300 text-red-600 shadow-sm mr-1">
                                                <span class="text-[10px] text-red-600 font-bold uppercase">Remove</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input id="image_3" name="image_3" type="file" class="mt-1 block w-full text-xs" />
                                    <x-text-input name="image_3_label" placeholder="Adorable Characters" class="mt-2 block w-full text-sm" :value="$brandExperience->image_3_label" />
                                </div>

                                <!-- Image 4 (Layout 2 Only) -->
                                <div class="p-4 border border-dashed rounded-lg bg-gray-50 dark:bg-gray-700/30">
                                    <x-input-label for="image_4" :value="__('Image 4 (Grid Item 4 in Layout 2)')" />
                                    @if($brandExperience->image_4)
                                        <div class="mb-2 relative w-32">
                                            <img src="{{ asset('storage/'.$brandExperience->image_4) }}" class="rounded shadow-sm" />
                                            <label class="flex items-center mt-1">
                                                <input type="checkbox" name="remove_image_4" value="1" class="rounded border-gray-300 text-red-600 shadow-sm mr-1">
                                                <span class="text-[10px] text-red-600 font-bold uppercase">Remove</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input id="image_4" name="image_4" type="file" class="mt-1 block w-full text-xs" />
                                    <x-text-input name="image_4_label" placeholder="Elegant & Trendy for Women" class="mt-2 block w-full text-sm" :value="$brandExperience->image_4_label" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
