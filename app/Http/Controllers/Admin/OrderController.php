<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function markAsPaid(Order $order)
    {
        $order->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil ditandai sebagai Lunas');
    }

    public function markAsCompleted(Order $order)
    {
        $order->update([
            'status' => 'completed'
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil ditandai sebagai Selesai');
    }
}
