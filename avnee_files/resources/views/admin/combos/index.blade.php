<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
                Combo Deals
            </h2>
            <a href="{{ route('admin.combos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <span class="material-symbols-outlined text-sm mr-2">add</span> Add New Combo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-3 font-semibold text-sm uppercase">Title</th>
                                    <th class="px-4 py-3 font-semibold text-sm uppercase text-center">Price</th>
                                    <th class="px-4 py-3 font-semibold text-sm uppercase text-center">Products</th>
                                    <th class="px-4 py-3 font-semibold text-sm uppercase text-center">Status</th>
                                    <th class="px-4 py-3 font-semibold text-sm uppercase text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($combos as $combo)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            @if($combo->image)
                                                <img src="{{ asset('storage/' . $combo->image) }}" class="w-12 h-12 object-cover rounded mr-3" />
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded mr-3">
                                                    <span class="material-symbols-outlined text-gray-400">image</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold">{{ $combo->title }}</div>
                                                <div class="text-xs text-gray-500">{{ $combo->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="font-bold text-indigo-600 dark:text-indigo-400">₹{{ number_format($combo->price, 2) }}</div>
                                        @if($combo->original_price)
                                            <div class="text-xs text-gray-500 line-through">₹{{ number_format($combo->original_price, 2) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">
                                            {{ $combo->products_count }} Products
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($combo->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase tracking-wider">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.combos.edit', $combo->id) }}" class="p-1 text-blue-600 hover:text-blue-800 transition-colors">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <form action="{{ route('admin.combos.destroy', $combo->id) }}" method="POST" onsubmit="return confirm('Delete this combo deal?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 italic">No combo deals found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $combos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
