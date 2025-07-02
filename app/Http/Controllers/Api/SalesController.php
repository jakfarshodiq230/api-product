<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

    public function salesData(Request $request) {
        $period = $request->input('period', 'monthly'); // daily, weekly, monthly, yearly

        $now = Carbon::now();
        $data = [];
        $labels = [];

        switch ($period) {
            case 'daily':
                $days = 30;
                for ($i = $days; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $total = Order::whereDate('created_at', $date->toDateString())->sum('total_amount');
                    $labels[] = $date->format('M j');
                    $data[] = $total;
                }
                break;

            case 'weekly':
                $weeks = 12;
                for ($i = $weeks; $i >= 0; $i--) {
                    $startDate = $now->copy()->subWeeks($i)->startOfWeek();
                    $endDate = $now->copy()->subWeeks($i)->endOfWeek();
                    $total = Order::whereBetween('created_at', [$startDate->toDateString(), $endDate->toDateString()])
                                 ->sum('total_amount');
                    $labels[] = $startDate->format('M j') . ' - ' . $endDate->format('M j');
                    $data[] = $total;
                }
                break;

            case 'monthly':
                $months = 12;
                for ($i = $months; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $total = Order::whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->sum('total_amount');
                    $labels[] = $date->format('M Y');
                    $data[] = $total;
                }
                break;

            case 'yearly':
                $years = 5;
                for ($i = $years; $i >= 0; $i--) {
                    $date = $now->copy()->subYears($i);
                    $total = Order::whereYear('created_at', $date->year)
                                 ->sum('total_amount');
                    $labels[] = $date->format('Y');
                    $data[] = $total;
                }
                break;
        }

        return response()->json([
            'period' => $period,
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function productSales(Request $request) {
        $limit = $request->input('limit', 5);

        $products = Product::withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw('COALESCE(SUM(quantity),0)'));
        }])
        ->orderByDesc('total_sold')
        ->limit($limit)
        ->get();

        return response()->json($products);
    }
}
