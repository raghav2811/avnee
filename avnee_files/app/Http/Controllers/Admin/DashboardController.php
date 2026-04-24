<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\FlashSale;
use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Core Metrics
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Promotion Metrics
        $activeSalesCount = FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->count();

        $topComboData = DB::table('combos')
            ->leftJoin('order_items', 'combos.id', '=', 'order_items.combo_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('combos.id', DB::raw('COUNT(orders.id) as sales_count'))
            ->where(function($q) {
                $q->where('orders.payment_status', 'paid')->orWhereNull('orders.id');
            })
            ->groupBy('combos.id')
            ->orderBy('sales_count', 'DESC')
            ->first();

        $topCombo = null;
        if ($topComboData) {
            $topCombo = Combo::withCount('products')->find($topComboData->id);
            if ($topCombo) {
                $topCombo->sales_count = $topComboData->sales_count;
            }
        }

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Sales Chart Data (Last 7 Days)
        $salesData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Order Status Distribution
        $orderStatuses = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'activeSalesCount',
            'topCombo',
            'recentOrders',
            'salesData',
            'orderStatuses'
        ));
    }
}
