<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <span class="material-symbols-outlined align-middle">arrow_back</span>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Page') }}: {{ $page->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="title" :value="__('Page Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $page->title)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="content" :value="__('Page Content')" />
                                    <textarea id="content" name="content" rows="20" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>{{ old('content', $page->content) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Settings -->
                    <div class="space-y-6">
                        <!-- Status & Link -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Status & Link</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <x-checkbox id="is_active" name="is_active" :checked="old('is_active', $page->is_active)" />
                                    <x-input-label for="is_active" :value="__('Page is Active')" class="ml-2" />
                                </div>
                                <div class="mt-4 pt-4 border-t dark:border-gray-700">
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Public URL</p>
                                    <a href="{{ route('front.page', $page->slug) }}" target="_blank" class="text-sm text-indigo-600 hover:underline inline-flex items-center">
                                        /p/{{ $page->slug }}
                                        <span class="material-symbols-outlined text-xs ml-1">open_in_new</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">SEO Metadata</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="meta_title" :value="__('Meta Title')" />
                                    <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title', $page->meta_title)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('meta_title')" />
                                </div>

                                <div>
                                    <x-input-label for="meta_description" :value="__('Meta Description')" />
                                    <textarea id="meta_description" name="meta_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('meta_description', $page->meta_description) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('meta_description')" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <x-primary-button class="w-full justify-center py-3">
                                {{ __('Update Page') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
