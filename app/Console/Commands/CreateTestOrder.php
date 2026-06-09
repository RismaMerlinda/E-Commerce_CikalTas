<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;

class CreateTestOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:create-test {--user-id=1} {--products=} {--status=pending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat test order untuk testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        $productsInput = $this->option('products');
        $status = $this->option('status');

        // Check user exists
        $user = User::find($userId);
        if (!$user) {
            $this->error("User dengan ID {$userId} tidak ditemukan!");
            return 1;
        }

        // Get products (default: ambil 2 produk pertama)
        if ($productsInput) {
            $productIds = explode(',', $productsInput);
            $products = Product::whereIn('id', $productIds)->get();
        } else {
            $products = Product::take(2)->get();
        }

        if ($products->isEmpty()) {
            $this->error("Tidak ada produk ditemukan!");
            return 1;
        }

        try {
            // Calculate gross amount
            $grossAmount = $products->sum(function ($product) {
                return $product->price * 1; // qty = 1
            });

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_id' => 'TEST-ORDER-' . time() . '-' . $userId,
                'gross_amount' => $grossAmount,
                'status' => $status,
                'payment_type' => 'test',
            ]);

            // Create order items
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
            }

            $this->info("✅ Test Order berhasil dibuat!");
            $this->line("Order ID: {$order->order_id}");
            $this->line("User: {$user->nama_lengkap}");
            $this->line("Total: Rp " . number_format($grossAmount, 0, ',', '.'));
            $this->line("Status: {$status}");
            $this->line("Produk: " . $products->pluck('name')->join(', '));

            return 0;
        } catch (\Exception $e) {
            $this->error("Gagal membuat order: " . $e->getMessage());
            return 1;
        }
    }
}
