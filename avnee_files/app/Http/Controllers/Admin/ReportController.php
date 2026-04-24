<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Reports Overview Dashboard
     */
    public function index()
    {
        $now = Carbon::now();
        
        // Revenue this month vs last month
        $thisMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_amount');
            
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->copy()->subMonth()->year)
            ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 100;

        // Top Selling Products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_revenue'))
            ->groupBy('product_id')
            ->orderBy('total_qty', 'DESC')
            ->with('product')
            ->take(5)
            ->get();

        // Coupon Efficacy
        $topCoupons = Order::whereNotNull('coupon_code')
            ->select('coupon_code', DB::raw('count(*) as usage_count'), DB::raw('SUM(total_amount) as generated_revenue'))
            ->groupBy('coupon_code')
            ->orderBy('usage_count', 'DESC')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'thisMonthRevenue', 
            'revenueGrowth', 
            'topProducts', 
            'topCoupons'
        ));
    }

    /**
     * Detailed Sales Report
     */
    public function sales(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);

        $salesTrend = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return view('admin.reports.sales', compact('salesTrend', 'days'));
    }

    /**
     * Coupon Performance Report
     */
    public function coupons()
    {
        $coupons = Order::whereNotNull('coupon_code')
            ->select(
                'coupon_code',
                DB::raw('COUNT(id) as total_uses'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('coupon_code')
            ->get();

        return view('admin.reports.coupons', compact('coupons'));
    }

    /**
     * Export Reports to CSV
     */
    public function export($type)
    {
        $filename = "report_{$type}_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'sales') {
                fputcsv($file, ['Date', 'Total Revenue', 'Order Count']);
                $data = Order::where('payment_status', 'paid')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
                    ->groupBy('date')->orderBy('date', 'DESC')->get();
                foreach($data as $row) fputcsv($file, [$row->date, $row->total, $row->count]);
            } 
            elseif ($type === 'coupons') {
                fputcsv($file, ['Coupon Code', 'Usage Count', 'Revenue Generated']);
                $data = Order::whereNotNull('coupon_code')
                    ->select('coupon_code', DB::raw('count(*) as count'), DB::raw('SUM(total_amount) as revenue'))
                    ->groupBy('coupon_code')->get();
                foreach($data as $row) fputcsv($file, [$row->coupon_code, $row->count, $row->revenue]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
