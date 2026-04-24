<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-heading font-bold text-white tracking-tight">Executive Summary</h2>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em] mt-1">Real-time Performance Metrics & Insights</p>
            </div>
            <div class="flex items-center gap-3">
                 <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all flex items-center gap-2">
                      <span class="material-symbols-outlined text-sm">calendar_today</span>
                      Today
                 </button>
                 <button class="px-4 py-2 bg-[#b87333] border border-[#b87333] rounded-xl text-xs font-bold uppercase tracking-widest text-white shadow-lg shadow-[#b87333]/20 hover:scale-105 transition-all">
                      Download Report
                 </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 mt-2">
        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Revenue Card -->
            <div class="p-8 glass-card rounded-[2rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                     <span class="material-symbols-outlined text-8xl text-[#b87333]">payments</span>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Gross Revenue</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg font-bold text-[#b87333]">₹</span>
                        <h3 class="text-4xl font-heading font-bold text-white">{{ number_format($totalSales) }}</h3>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-[10px] font-bold text-green-500 uppercase tracking-tighter">
                         <span class="material-symbols-outlined text-sm">trending_up</span>
                         +12.5% from last month
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="p-8 glass-card rounded-[2rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                     <span class="material-symbols-outlined text-8xl text-indigo-500">shopping_cart_checkout</span>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Order Velocity</p>
                    <h3 class="text-4xl font-heading font-bold text-white">{{ number_format($totalOrders) }}</h3>
                    <div class="mt-6 flex items-center gap-2 text-[10px] font-bold text-indigo-400 uppercase tracking-tighter">
                         <span class="material-symbols-outlined text-sm">cycle</span>
                         Processing {{ $recentOrders->count() }} active
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="p-8 glass-card rounded-[2rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                     <span class="material-symbols-outlined text-8xl text-purple-500">account_circle</span>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Customer Base</p>
                    <h3 class="text-4xl font-heading font-bold text-white">{{ number_format($totalCustomers) }}</h3>
                    <div class="mt-6 flex items-center gap-2 text-[10px] font-bold text-purple-400 uppercase tracking-tighter">
                         <span class="material-symbols-outlined text-sm">verified_user</span>
                         Loyalty growth active
                    </div>
                </div>
            </div>

            <!-- Flash Sales Card -->
            <div class="p-8 glass-card rounded-[2rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500 border-l-[#b87333]/30">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                     <span class="material-symbols-outlined text-8xl text-yellow-500">bolt</span>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Live Campaigns</p>
                    <h3 class="text-4xl font-heading font-bold text-white">
                        {{ $activeSalesCount }}
                    </h3>
                    @if($activeSalesCount > 0)
                        <div class="mt-6 flex items-center gap-2 text-[10px] font-bold text-yellow-500 uppercase tracking-tighter">
                             <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                             Conversion Pulse Active
                        </div>
                    @else
                        <div class="mt-6 text-[10px] font-bold text-gray-600 uppercase tracking-tighter">
                             No Active Events
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Charts & Secondary Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Chart Area -->
            <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-10">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h4 class="text-base font-bold text-white uppercase tracking-widest">Revenue Forecast</h4>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">7-Day performance cycle</p>
                    </div>
                    <div class="flex items-center gap-5">
                         <div class="flex items-center gap-2">
                              <span class="w-2.5 h-2.5 rounded-full bg-[#b87333]"></span>
                              <span class="text-[10px] font-bold text-gray-400 uppercase">Sales</span>
                         </div>
                    </div>
                </div>
                <div class="h-[300px] w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Inventory Insights -->
            <div class="glass-card rounded-[2.5rem] p-10 flex flex-col justify-between">
                <div>
                    <h4 class="text-base font-bold text-white uppercase tracking-widest mb-8 text-center">Order Status Hub</h4>
                    <div class="relative h-[220px] mb-8">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                
                <!-- Legend Grid -->
                <div class="grid grid-cols-2 gap-3 mt-4">
                     @foreach($orderStatuses as $status)
                     <div class="p-3 bg-white/5 rounded-xl border border-white/5 flex items-center justify-between">
                          <span class="text-[9px] font-bold text-gray-400 uppercase truncate pr-1">{{ $status->status }}</span>
                          <span class="text-xs font-bold text-white">{{ $status->count }}</span>
                     </div>
                     @endforeach
                </div>
            </div>
        </div>

        <!-- Order Ledger -->
        <div class="glass-card rounded-[2.5rem] overflow-hidden">
            <div class="px-10 py-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                <div>
                    <h4 class="text-base font-bold text-white uppercase tracking-widest">Transaction Ledger</h4>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">Reviewing latest customer interactions</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 rounded-xl text-[10px] font-bold uppercase tracking-widest text-[#b87333] transition-all border border-[#b87333]/20 shadow-lg">
                    Access Full Ledger
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-black/20">
                        <tr>
                            <th class="px-10 py-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Identifier</th>
                            <th class="px-10 py-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Patron</th>
                            <th class="px-10 py-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Lifecycle</th>
                            <th class="px-10 py-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-right">Value (INR)</th>
                            <th class="px-10 py-5 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentOrders as $order)
                        <tr class="group hover:bg-white/[0.03] transition-colors">
                            <td class="px-10 py-6 font-mono text-xs text-[#b87333]">#{{ $order->order_number }}</td>
                            <td class="px-10 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">{{ $order->user->name ?? 'Private Patron' }}</span>
                                    <span class="text-[10px] text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        @if($order->status == 'pending') bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                                        @elseif($order->status == 'delivered') bg-green-500/10 text-green-500 border border-green-500/20
                                        @elseif($order->status == 'cancelled') bg-red-500/10 text-red-500 border border-red-500/20
                                        @else bg-blue-500/10 text-blue-500 border border-blue-500/20 @endif">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-right font-heading font-bold text-gray-300">
                                ₹{{ number_format($order->total_amount) }}
                            </td>
                            <td class="px-10 py-6 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="p-2.5 rounded-xl bg-white/5 hover:bg-[#b87333] hover:text-white text-gray-500 transition-all flex-inline items-center justify-center">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                     <span class="material-symbols-outlined text-6xl mb-4">move_to_inbox</span>
                                     <p class="text-xs font-bold uppercase tracking-widest">No Recent Transactions Detected</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Configuration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // High Resolution Charts
            const salesData = JSON.parse('{!! json_encode($salesData) !!}');
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            
            const gradient = salesCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(184, 115, 51, 0.2)');
            gradient.addColorStop(1, 'rgba(184, 115, 51, 0)');

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesData.map(d => d.date),
                    datasets: [{
                        label: 'Sales Revenue',
                        data: salesData.map(d => d.total),
                        borderColor: '#b87333',
                        borderWidth: 4,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.5,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#b87333',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a131b',
                            titleFont: { family: 'Outfit', size: 10, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 15,
                            displayColors: false,
                            callbacks: {
                                label: function(context) { return '₹' + context.raw.toLocaleString(); }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                            ticks: { 
                                color: 'rgba(255, 255, 255, 0.3)', 
                                font: { size: 10, weight: 'bold' },
                                callback: function(value) { return '₹' + (value/1000) + 'k'; }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: 'rgba(255, 255, 255, 0.3)', font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });

            // Status Distribution Hub
            const statusData = JSON.parse('{!! json_encode($orderStatuses) !!}');
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(d => d.status.toUpperCase()),
                    datasets: [{
                        data: statusData.map(d => d.count),
                        backgroundColor: [
                            '#b87333', // gold-ish
                            '#4f46e5', // indigo
                            '#d4af37', // purple
                            '#10b981', // green
                            '#ef4444'  // red
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a131b',
                            padding: 12,
                            bodyFont: { family: 'Outfit', weight: 'bold' },
                            displayColors: true,
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
