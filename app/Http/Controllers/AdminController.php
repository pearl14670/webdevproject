<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total_orders' => Order::count(),
            'orders_increase' => $this->calculateIncrease(Order::class),
            'total_revenue' => Order::sum('total_amount'),
            'revenue_increase' => $this->calculateRevenueIncrease(),
            'total_customers' => User::count(),
            'customers_increase' => $this->calculateIncrease(User::class),
            'total_products' => Product::count(),
            'products_increase' => $this->calculateIncrease(Product::class),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get pending reviews
        $pendingReviews = Review::with(['user', 'product'])
            ->whereNull('is_approved')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingReviews'));
    }

    private function calculateIncrease($model, $conditions = [])
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        $currentCount = $model::where($conditions)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastCount = $model::where($conditions)
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        if ($lastCount == 0) {
            return $currentCount > 0 ? 100 : 0;
        }

        return round((($currentCount - $lastCount) / $lastCount) * 100, 1);
    }

    private function calculateRevenueIncrease()
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        $currentRevenue = Order::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_amount');

        $lastRevenue = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_amount');

        if ($lastRevenue == 0) {
            return $currentRevenue > 0 ? 100 : 0;
        }

        return round((($currentRevenue - $lastRevenue) / $lastRevenue) * 100, 1);
    }
} 