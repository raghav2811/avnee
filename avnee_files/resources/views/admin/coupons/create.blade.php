<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Coupon') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="code" :value="__('Coupon Code')" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full uppercase" :value="old('code')" required autofocus placeholder="E.g. SUMMER25" />
                                <x-input-error class="mt-2" :messages="$errors->get('code')" />
                            </div>

                            <div>
                                <x-input-label for="type" :value="__('Coupon Type')" />
                                <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="free_shipping" {{ old('type') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>

                            <div>
                                <x-input-label for="reward" :value="__('Reward Value')" />
                                <x-text-input id="reward" name="reward" type="number" step="0.01" class="mt-1 block w-full" :value="old('reward', 0)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('reward')" />
                            </div>

                            <div>
                                <x-input-label for="min_order_amount" :value="__('Min Order Amount (₹)')" />
                                <x-text-input id="min_order_amount" name="min_order_amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('min_order_amount', 0)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('min_order_amount')" />
                            </div>

                            <div>
                                <x-input-label for="max_discount" :value="__('Max Discount (₹) - For % type')" />
                                <x-text-input id="max_discount" name="max_discount" type="number" step="0.01" class="mt-1 block w-full" :value="old('max_discount')" placeholder="Leave blank for no limit" />
                                <x-input-error class="mt-2" :messages="$errors->get('max_discount')" />
                            </div>

                            <div>
                                <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                                <x-text-input id="expiry_date" name="expiry_date" type="date" class="mt-1 block w-full" :value="old('expiry_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                            </div>

                            <div>
                                <x-input-label for="usage_limit" :value="__('Usage Limit')" />
                                <x-text-input id="usage_limit" name="usage_limit" type="number" class="mt-1 block w-full" :value="old('usage_limit')" placeholder="Leave blank for unlimited" />
                                <x-input-error class="mt-2" :messages="$errors->get('usage_limit')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button>
                                {{ __('Create Coupon') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
