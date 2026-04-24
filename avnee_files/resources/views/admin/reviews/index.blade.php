<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Direct Customer Feedback
            </h2>
            <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Manual Review
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900/50 dark:border-green-800 dark:text-green-300" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filters Bar -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 tracking-wider">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Comment, User or Product..." class="w-full pl-10 pr-4 py-2 rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <span class="material-symbols-outlined text-sm">search</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 tracking-wider">Status</label>
                        <select name="status" class="w-full py-2 pl-3 pr-10 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800 text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 tracking-wider">Brand</label>
                        <select name="brand_id" class="w-full py-2 pl-3 pr-10 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800 text-sm">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 tracking-wider">Rating</label>
                        <select name="rating" class="w-full py-2 pl-3 pr-10 border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800 text-sm">
                            <option value="">All Ratings</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-bold uppercase tracking-widest transition-colors shadow-sm">Filter</button>
                        <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-650 text-gray-700 dark:text-gray-300 rounded text-sm font-bold uppercase tracking-widest transition-colors border border-gray-200 dark:border-gray-600">Reset</a>
                    </div>
                </form>
            </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Context</th>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Rating</th>
                            <th class="px-6 py-3">Comment</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-6 py-4">
                                     <div class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking_wider {{ $review->brand_id == 2 ? 'bg-purple-900/40 text-purple-300 ring-1 ring-purple-500/30' : 'bg-orange-900/40 text-orange-300 ring-1 ring-orange-500/30' }}">
                                         {{ $review->brand?->name ?? 'Studio' }}
                                     </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $review->product->name }}</div>
                                    <div class="text-xs text-gray-500">SKU: {{ $review->product->sku }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-500 dark:text-gray-400 text-xs uppercase overflow-hidden">
                                            @if($review->user && $review->user->profile_photo_path)
                                                <img src="{{ $review->user->profile_photo_url }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($review->user_name ?? $review->user?->name ?? 'A', 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $review->user_name ?? $review->user?->name ?? 'Deleted User' }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $review->user_id ? ($review->user?->email ?? 'Authenticated') : 'Manual Submission' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-symbols-outlined text-sm {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                        @endfor
                                    </div>
                                    @if($review->is_verified)
                                        <div class="flex items-center gap-1 mt-1 text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full w-fit">
                                            <span class="material-symbols-outlined text-[12px]">verified</span>
                                            VERIFIED BUYER
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="truncate text-gray-700 dark:text-gray-300" title="{{ $review->comment }}">
                                        {{ $review->comment }}
                                    </p>
                                    @if($review->admin_reply)
                                        <div class="mt-2 p-2 bg-indigo-50 dark:bg-indigo-900/20 rounded border-l-4 border-indigo-400">
                                            <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Admin Reply:</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 italic">"{{ $review->admin_reply }}"</p>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    {{ $review->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($review->status == 'approved')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-widest">Approved</span>
                                    @elseif($review->status == 'rejected')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-widest">Rejected</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase tracking-widest">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    @if($review->status == 'pending')
                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 font-medium" title="Approve">
                                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:text-orange-900 font-medium" title="Reject">
                                                <span class="material-symbols-outlined text-lg">cancel</span>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.reviews.edit', $review) }}" 
                                        class="text-amber-600 hover:text-amber-900 font-medium" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>

                                    <button type="button" 
                                        onclick="toggleReplyForm('{{ $review->id }}');"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium" title="Reply">
                                        <span class="material-symbols-outlined text-lg">reply</span>
                                    </button>

                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium" title="Delete">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="reply-form-{{ $review->id }}" class="hidden bg-indigo-50/50 dark:bg-indigo-900/10">
                                <td colspan="7" class="px-6 py-4 border-b dark:border-gray-700">
                                    <form action="{{ route('admin.reviews.reply', $review) }}" method="POST" class="max-w-2xl">
                                        @csrf
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Write Admin Response</label>
                                        <textarea name="admin_reply" rows="3" required
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Your response will be visible on the product page...">{{ $review->admin_reply }}</textarea>
                                        <div class="mt-3 flex justify-end space-x-3">
                                            <button type="button" onclick="toggleReplyForm('{{ $review->id }}');" class="px-3 py-1.5 text-xs text-gray-500 hover:text-gray-700">Cancel</button>
                                            <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white rounded text-xs font-bold hover:bg-indigo-700 transition-colors">Submit Reply</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No reviews found for the selected criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleReplyForm(id) {
            const form = document.getElementById('reply-form-' + id);
            form.classList.toggle('hidden');
        }
    </script>
</x-admin-layout>
