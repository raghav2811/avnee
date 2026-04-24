<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Analytics & Reports') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.export', 'sales') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <span class="material-symbols-outlined text-sm mr-2">download</span>
                    Export Sales
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Revenue (This Month)</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">₹{{ number_format($thisMonthRevenue) }}</h3>
                            <p class="mt-2 text-sm {{ $revenueGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">
                                    {{ $revenueGrowth >= 0 ? 'trending_up' : 'trending_down' }}
                                </span>
                                {{ number_format(abs($revenueGrowth), 1) }}% vs last month
                            </p>
                        </div>
                        <div class="p-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400">
                            <span class="material-symbols-outlined text-3xl">payments</span>
                        </div>
                    </div>
                </div>

                <!-- Top Products Small List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 col-span-1 md:col-span-2">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-4">Top 5 Selling Products</h3>
                    <div class="space-y-4">
                        @foreach($topProducts as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="max-w-[200px] truncate">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase">{{ $item->total_qty }} units sold</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">₹{{ number_format($item->total_revenue) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Nav Cards -->
                <div class="lg:col-span-1 space-y-6">
                    <a href="{{ route('admin.reports.sales') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:border-indigo-500 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">monitoring</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Sales Trends</h4>
                                <p class="text-xs text-gray-500">Deep dive into revenue and order volume.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports.coupons') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:border-indigo-500 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">sell</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Coupon ROI</h4>
                                <p class="text-xs text-gray-500">Analyze the efficacy of your promotions.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Coupon Table Summary -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6">Coupon Performance Overview</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-[10px] text-gray-400 uppercase tracking-widest border-b dark:border-gray-700">
                                char:
                                <tr>
                                    <th class="pb-3 px-2">Code</th>
                                    <th class="pb-3 px-2">Uses</th>
                                    <th class="pb-3 px-2 text-right">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach($topCoupons as $coupon)
                                <tr>
                                    <td class="py-4 px-2 font-mono text-xs text-indigo-600 dark:text-indigo-400 font-bold">{{ $coupon->coupon_code }}</td>
                                    <td class="py-4 px-2">{{ $coupon->usage_count }}</td>
                                    <td class="py-4 px-2 text-right font-bold text-gray-900 dark:text-white">₹{{ number_format($coupon->generated_revenue) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
