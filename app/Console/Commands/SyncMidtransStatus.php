<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Midtrans\Config;
use Midtrans\Transaction;

class SyncMidtransStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midtrans:sync {order_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync payment status from Midtrans for pending orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = $this->argument('order_id');

        if ($orderId) {
            // Sync specific order
            $order = Order::where('order_id', $orderId)->first();
            if (!$order) {
                $this->error("Order {$orderId} not found!");
                return 1;
            }
            $this->syncOrder($order);
        } else {
            // Sync all pending orders
            $orders = Order::where('status', 'pending')->get();

            if ($orders->isEmpty()) {
                $this->info('No pending orders to sync.');
                return 0;
            }

            $this->info("Found {$orders->count()} pending orders. Syncing...");

            foreach ($orders as $order) {
                $this->syncOrder($order);
            }
        }

        $this->info('Sync completed!');
        return 0;
    }

    private function syncOrder($order)
    {
        try {
            // Get transaction status from Midtrans
            $status = Transaction::status($order->order_id);

            $this->info("Order: {$order->order_id}");
            $this->info("Midtrans Status: {$status->transaction_status}");

            // Update order based on Midtrans status
            if ($status->transaction_status == 'capture' || $status->transaction_status == 'settlement') {
                $order->update([
                    'status' => 'paid',
                    'payment_type' => $status->payment_type ?? null,
                    'transaction_id' => $status->transaction_id ?? null,
                    'paid_at' => now(),
                    'midtrans_response' => (array) $status,
                ]);
                $this->info("✓ Updated to PAID");
            } elseif ($status->transaction_status == 'pending') {
                $this->warn("⏱ Still PENDING");
            } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'status' => 'failed',
                    'midtrans_response' => (array) $status,
                ]);
                $this->error("✗ Updated to FAILED");
            }

            $this->line('---');
        } catch (\Exception $e) {
            $this->error("Error syncing order {$order->order_id}: " . $e->getMessage());
        }
    }
}
