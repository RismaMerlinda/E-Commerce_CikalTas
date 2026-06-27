<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $paidStatuses = ['paid', 'processing', 'completed'];

        $totalRevenue      = Order::whereIn('status', $paidStatuses)->sum('gross_amount');
        $totalOrders       = Order::count();
        $totalProducts     = Product::count();
        $totalCustomers    = User::where('role', '!=', 'admin')->count();
        $pendingOrders     = Order::where('status', 'pending')->count();
        $completedOrders   = Order::where('status', 'completed')->count();

        // Top 5 best-selling products
        $topProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->limit(5)
            ->get();

        // Recent 5 orders
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts',
            'totalCustomers', 'pendingOrders', 'completedOrders',
            'topProducts', 'recentOrders'
        ));
    }
}
