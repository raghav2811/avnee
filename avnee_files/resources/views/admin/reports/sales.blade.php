<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reports.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <span class="material-symbols-outlined align-middle">arrow_back</span>
                </a>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Sales Performance & Trends') }}
                </h2>
            </div>
            <div class="flex gap-4">
                <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex items-center gap-2">
                    <select name="days" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="7" {{ $days == 7 ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ $days == 30 ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $days == 90 ? 'selected' : '' }}>Last 90 Days</option>
                    </select>
                </form>
                <a href="{{ route('admin.reports.export', 'sales') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <span class="material-symbols-outlined text-sm mr-2">download</span>
                    Export CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Chart Container -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-8 text-center">Revenue Trend (Last {{ $days }} Days)</h3>
                <div class="h-[400px]">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="font-bold text-gray-900 dark:text-white">Daily Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Orders</th>
                                <th class="px-6 py-4 text-right">Revenue</th>
                                <th class="px-6 py-4 text-right">Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach($salesTrend->reverse() as $day)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 italic">{{ Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ $day->order_count }}</td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">₹{{ number_format($day->total) }}</td>
                                <td class="px-6 py-4 text-right text-gray-500 italic">
                                    ₹{{ number_format($day->order_count > 0 ? $day->total / $day->order_count : 0, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesTrendChart').getContext('2d');
            const data = JSON.parse('{!! json_encode($salesTrend) !!}');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => {
                        const date = new Date(d.date);
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    }),
                    datasets: [{
                        label: 'Daily Revenue',
                        data: data.map(d => d.total),
                        borderColor: '#4f46e5',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 14 },
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '₹' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: {
                                callback: value => '₹' + value.toLocaleString()
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
