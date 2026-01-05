<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index()
    {
        // Status yang menandakan order sudah dibayar
        $paidStatuses = ['paid', 'processing', 'completed'];

        // Hitung total pemasukan dari order yang sudah dibayar
        $totalRevenue = Order::whereIn('status', $paidStatuses)->sum('gross_amount');

        // Hitung total transaksi yang sudah dibayar
        $totalTransactions = Order::whereIn('status', $paidStatuses)->count();

        // Ambil semua order yang sudah dibayar beserta detail items
        $orders = Order::whereIn('status', $paidStatuses)
            ->with(['user', 'orderItems.product'])
            ->latest()
            ->get();

        return view('admin.sales-report', compact('totalRevenue', 'totalTransactions', 'orders'));
    }
}
