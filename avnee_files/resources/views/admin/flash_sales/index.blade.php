<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Flash Sales') }}
            </h2>
            <a href="{{ route('admin.flash-sales.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <span class="material-symbols-outlined text-sm mr-2">add</span>
                Create Flash Sale
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Campaign</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Timing</th>
                                    <th class="px-6 py-3">Products</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($flashSales as $sale)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($sale->image)
                                                <img src="{{ asset('storage/' . $sale->image) }}" class="w-10 h-10 object-cover rounded mr-3" />
                                            @endif
                                            <div>
                                                <div class="font-bold">{{ $sale->title }}</div>
                                                <div class="text-xs text-gray-500 font-mono">{{ $sale->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($sale->isActiveNow())
                                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active Now</span>
                                        @elseif($sale->is_active)
                                            <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Scheduled</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs">
                                            <div><span class="text-gray-400">Start:</span> {{ $sale->start_time->format('M d, Y H:i') }}</div>
                                            <div><span class="text-gray-400">End:</span> {{ $sale->end_time->format('M d, Y H:i') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium">{{ $sale->items_count }}</span> Products
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.flash-sales.edit', $sale) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <form action="{{ route('admin.flash-sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Delete this flash sale?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $flashSales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
