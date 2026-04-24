<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-800 dark:text-gray-200">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Explore More Grid (Home & Products)') }}
            </h2>
            <a href="{{ route('admin.home-explore-grids.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                Add New Grid Item
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider">Brand</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider">Preview</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider">Title</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider text-center">Span</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider text-center">Order</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($grids as $grid)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded {{ $grid->brand_id == 1 ? 'bg-pink-100 text-pink-800 border border-pink-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                            {{ $grid->brand->name ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($grid->image)
                                            <img src="{{ asset('storage/' . $grid->image) }}" alt="" class="h-12 w-20 object-cover rounded shadow-sm border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div class="h-12 w-20 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded text-xs opacity-30">NO IMAGE</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-sm font-medium">{{ $grid->title }}</div>
                                        <div class="text-[10px] text-gray-500 line-clamp-1 italic italic">{{ $grid->subtitle }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-center">
                                        <span class="font-mono">{{ $grid->grid_span }}x1</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-center font-mono">{{ $grid->sort_order }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $grid->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $grid->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.home-explore-grids.edit', $grid) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 dark:bg-indigo-900/30 p-1.5 rounded transition-transform active:scale-95">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <form action="{{ route('admin.home-explore-grids.destroy', $grid) }}" method="POST" onsubmit="return confirm('Archive this record?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 dark:bg-red-900/30 p-1.5 rounded transition-transform active:scale-95">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400 italic">No grid items configured. Start by creating the 'Explore More' narrative for your brands.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $grids->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
