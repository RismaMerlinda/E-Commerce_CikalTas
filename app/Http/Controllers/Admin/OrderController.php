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

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
        ]);

        $data = ['status' => $request->status];

        // If marked as paid, set paid_at if it's null
        if ($request->status == 'paid' && is_null($order->paid_at)) {
            $data['paid_at'] = now();
        }

        $order->update($data);

        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'processing' => 'Dikemas',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status pesanan berhasil diubah menjadi ' . $statusLabels[$request->status]);
    }
}
