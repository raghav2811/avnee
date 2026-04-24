<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Customer Details: {{ $user->name }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.customers.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    &larr; Back to Customers
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Stats -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-center">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl">person</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->phone ?? 'No phone number provided' }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                            @if($user->is_blocked)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Blocked</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Joined</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('admin.customers.toggle-block', $user) }}" method="POST" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border {{ $user->is_blocked ? 'bg-green-600 border-transparent text-white' : 'bg-white border-red-300 text-red-700' }} rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:{{ $user->is_blocked ? 'bg-green-700' : 'bg-red-50' }} focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            onclick="return confirm('Are you sure you want to {{ $user->is_blocked ? 'unblock' : 'block' }} this customer?')">
                            {{ $user->is_blocked ? 'Unblock User' : 'Block User' }}
                        </button>
                    </form>
                </div>

                <!-- Sales Stats -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase mb-4">Customer Stats</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Orders</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->orders->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Lifetime Value</span>
                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">₹{{ number_format($totalSpend, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Order History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Order #</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Payment</th>
                                    <th class="px-6 py-3 text-right">Total</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($user->orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            ₹{{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            This customer hasn't placed any orders yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
