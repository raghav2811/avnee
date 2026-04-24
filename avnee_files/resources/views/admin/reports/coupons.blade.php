<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reports.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <span class="material-symbols-outlined align-middle">arrow_back</span>
                </a>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Coupon ROI & Efficacy') }}
                </h2>
            </div>
            <a href="{{ route('admin.reports.export', 'coupons') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm shadow-sm">
                <span class="material-symbols-outlined text-sm mr-2">download</span>
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- ROI Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Coupons Used</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $coupons->sum('total_uses') }}</h3>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Coupon Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($coupons->sum('total_revenue')) }}</h3>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4">Coupon Code</th>
                                <th class="px-6 py-4">Usage Count</th>
                                <th class="px-6 py-4 text-right">Revenue Generated</th>
                                <th class="px-6 py-4 text-right">Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700 text-gray-600 dark:text-gray-300">
                            @forelse($coupons as $coupon)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-indigo-600 dark:text-indigo-400 uppercase italic">{{ $coupon->coupon_code }}</td>
                                <td class="px-6 py-4">{{ $coupon->total_uses }}</td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">₹{{ number_format($coupon->total_revenue) }}</td>
                                <td class="px-6 py-4 text-right italic font-medium">
                                    ₹{{ number_format($coupon->total_uses > 0 ? $coupon->total_revenue / $coupon->total_uses : 0, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">No coupon data available for the selected period.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-md border border-indigo-100 dark:border-indigo-800">
                <p class="text-xs text-indigo-700 dark:text-indigo-300 flex items-center">
                    <span class="material-symbols-outlined text-sm mr-2">lightbulb</span>
                    Tip: Coupons with higher Average Order Value (AOV) are often more profitable than those with high volume but low revenue.
                </p>
            </div>
        </div>
    </div>
</x-admin-layout>
