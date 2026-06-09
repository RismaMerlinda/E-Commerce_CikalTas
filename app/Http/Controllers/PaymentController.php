<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\CoreApi;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('pembayaran', compact('cartItems', 'total'));
    }

    public function createTransaction(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'payment_type' => 'required|string|in:bank_transfer,permata,echannel,qris,gopay,shopeepay,cstore,credit_card',
                'bank' => 'nullable|string',
                'store' => 'nullable|string',
                'qris_acquirer' => 'nullable|string',
                'token_id' => 'nullable|string',
            ]);

            \Log::info('Payment request received', [
                'user_id' => Auth::id(),
                'payment_type' => $validated['payment_type']
            ]);

            // Get cart items
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                \Log::warning('Cart empty for user', ['user_id' => Auth::id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang Anda kosong'
                ], 400);
            }

            // Calculate total
            $grossAmount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Generate unique order ID
            $orderId = 'ORDER-' . time() . '-' . Auth::id();

            \Log::info('Creating order', [
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'gross_amount' => $grossAmount,
                'items_count' => $cartItems->count()
            ]);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
                'status' => 'pending',
            ]);

            \Log::info('Order created successfully', [
                'order_id' => $order->order_id,
                'db_id' => $order->id
            ]);

            // Create order items
            $createdItems = 0;
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
                $createdItems++;
            }

            \Log::info('Order items created', [
                'order_id' => $order->order_id,
                'items_created' => $createdItems
            ]);

            // Prepare transaction details for Midtrans
            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ];

            // Prepare item details
            $itemDetails = [];
            foreach ($cartItems as $cartItem) {
                $itemDetails[] = [
                    'id' => $cartItem->product_id,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'name' => $cartItem->product->name,
                ];
            }

            // Customer details
            $customerDetails = [
                'first_name' => Auth::user()->nama_lengkap,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->nomor_telepon ?? '',
            ];

            // Transaction params
            $transactionParams = [
                'transaction_details' => $transactionDetails,
                'item_details' => $itemDetails,
                'customer_details' => $customerDetails,
            ];

            // Get Snap Token
            // Full custom payment uses Core API charge (no Snap UI)
            $chargeParams = $transactionParams;
            $chargeParams['payment_type'] = $validated['payment_type'];

            if ($validated['payment_type'] === 'bank_transfer') {
                $chargeParams['bank_transfer'] = [
                    'bank' => $validated['bank'] ?? 'bca',
                ];
            } elseif ($validated['payment_type'] === 'permata') {
                // No extra params
            } elseif ($validated['payment_type'] === 'echannel') {
                $chargeParams['echannel'] = [
                    'bill_info1' => 'Payment:',
                    'bill_info2' => 'Online purchase',
                ];
            } elseif ($validated['payment_type'] === 'qris') {
                $chargeParams['qris'] = [
                    'acquirer' => $validated['qris_acquirer'] ?? 'gopay',
                ];
            } elseif ($validated['payment_type'] === 'gopay') {
                $chargeParams['gopay'] = [
                    'enable_callback' => true,
                    'callback_url' => url('/pembayaran/pending?order_id=' . $orderId),
                ];
            } elseif ($validated['payment_type'] === 'shopeepay') {
                $chargeParams['shopeepay'] = [
                    'callback_url' => url('/pembayaran/pending?order_id=' . $orderId),
                ];
            } elseif ($validated['payment_type'] === 'cstore') {
                $chargeParams['cstore'] = [
                    'store' => $validated['store'] ?? 'alfamart',
                    'message' => 'Pembayaran CikalTas',
                ];
            } elseif ($validated['payment_type'] === 'credit_card') {
                if (empty($validated['token_id'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Token kartu tidak valid',
                    ], 422);
                }

                $chargeParams['credit_card'] = [
                    'token_id' => $validated['token_id'],
                    'authentication' => true,
                ];
            }

            \Log::info('Sending to Midtrans', [
                'order_id' => $orderId,
                'payment_type' => $validated['payment_type']
            ]);

            $chargeResponse = CoreApi::charge($chargeParams);
            $chargeResponseArr = json_decode(json_encode($chargeResponse), true);

            \Log::info('Midtrans response received', [
                'order_id' => $orderId,
                'transaction_status' => $chargeResponseArr['transaction_status'] ?? null
            ]);

            $transactionStatus = $chargeResponseArr['transaction_status'] ?? null;
            $mappedStatus = 'pending';
            if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
                $mappedStatus = 'paid';
            } elseif ($transactionStatus === 'deny') {
                $mappedStatus = 'failed';
            } elseif ($transactionStatus === 'expire') {
                $mappedStatus = 'expired';
            } elseif ($transactionStatus === 'cancel') {
                $mappedStatus = 'cancelled';
            }

            $order->update([
                'status' => $mappedStatus,
                'payment_type' => $chargeResponseArr['payment_type'] ?? $validated['payment_type'],
                'transaction_id' => $chargeResponseArr['transaction_id'] ?? null,
                'paid_at' => $mappedStatus === 'paid' ? now() : null,
                'midtrans_response' => $chargeResponseArr,
            ]);

            \Log::info('Order status updated', [
                'order_id' => $orderId,
                'status' => $mappedStatus
            ]);

            // Clear cart after creating order
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            \Log::info('Payment transaction completed successfully', [
                'order_id' => $orderId,
                'status' => $mappedStatus
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'status' => $mappedStatus,
                'payment_type' => $validated['payment_type'],
                'redirect_url' => $chargeResponseArr['redirect_url'] ?? null,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Payment transaction failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        // Log untuk debugging
        \Log::info('Midtrans Callback Received', $request->all());

        try {
            $serverKey = config('midtrans.server_key');

            // Hitung signature
            $hashed = hash(
                'sha512',
                $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
            );

            \Log::info('Signature Check', [
                'calculated' => $hashed,
                'received' => $request->signature_key,
                'match' => $hashed == $request->signature_key
            ]);

            // Validasi signature
            if ($hashed !== $request->signature_key) {
                \Log::error('Invalid signature key');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid signature'
                ], 403);
            }

            // Cari order
            $order = Order::where('order_id', $request->order_id)->first();

            if (!$order) {
                \Log::error('Order not found', ['order_id' => $request->order_id]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            \Log::info('Order found', [
                'order_id' => $order->order_id,
                'current_status' => $order->status,
                'transaction_status' => $request->transaction_status
            ]);

            // Update status berdasarkan transaction_status
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status ?? 'accept';

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Kartu kredit langsung sukses
                    $order->update([
                        'status' => 'paid',
                        'payment_type' => $request->payment_type,
                        'transaction_id' => $request->transaction_id,
                        'paid_at' => now(),
                        'midtrans_response' => $request->all(),
                    ]);
                    \Log::info('Order status updated to PAID', ['order_id' => $order->order_id]);
                } else {
                    // Fraud challenge
                    $order->update([
                        'status' => 'pending',
                        'midtrans_response' => $request->all(),
                    ]);
                    \Log::info('Order status kept as PENDING (fraud challenge)', ['order_id' => $order->order_id]);
                }
            } elseif ($transactionStatus == 'settlement') {
                // Untuk non-kartu kredit yang sukses
                $order->update([
                    'status' => 'paid',
                    'payment_type' => $request->payment_type,
                    'transaction_id' => $request->transaction_id,
                    'paid_at' => now(),
                    'midtrans_response' => $request->all(),
                ]);
                \Log::info('Order status updated to PAID (settlement)', ['order_id' => $order->order_id]);
            } elseif ($transactionStatus == 'pending') {
                $order->update([
                    'status' => 'pending',
                    'payment_type' => $request->payment_type,
                    'transaction_id' => $request->transaction_id,
                    'midtrans_response' => $request->all(),
                ]);
                \Log::info('Order status updated to PENDING', ['order_id' => $order->order_id]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $statusMap = [
                    'deny' => 'failed',
                    'expire' => 'expired',
                    'cancel' => 'cancelled'
                ];

                $order->update([
                    'status' => $statusMap[$transactionStatus],
                    'midtrans_response' => $request->all(),
                ]);
                \Log::info('Order status updated to ' . strtoupper($statusMap[$transactionStatus]), ['order_id' => $order->order_id]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed'
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Callback Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ], 500);
        }
    }

    public function qr(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $order = Order::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $actions = $order->midtrans_response['actions'] ?? null;
        if (!is_array($actions)) {
            abort(404);
        }

        $qrUrl = null;
        foreach ($actions as $action) {
            if (!is_array($action)) {
                continue;
            }
            $url = $action['url'] ?? null;
            if (is_string($url) && str_contains($url, 'qr-code')) {
                $qrUrl = $url;
                break;
            }
        }

        if (!$qrUrl) {
            abort(404);
        }

        $resp = Http::withBasicAuth(config('midtrans.server_key'), '')
            ->withHeaders([
                'Accept' => 'image/png,image/*,*/*',
            ])
            ->get($qrUrl);

        if (!$resp->successful()) {
            abort(502);
        }

        return response($resp->body(), 200)
            ->header('Content-Type', $resp->header('Content-Type') ?? 'image/png');
    }

    public function updateOrderStatus(Request $request)
    {
        try {
            $order = Order::where('order_id', $request->order_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            $order->update([
                'status' => $request->status,
                'payment_type' => $request->payment_type ?? null,
                'transaction_id' => $request->transaction_id ?? null,
                'paid_at' => $request->status === 'paid' ? now() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status order berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        // Get order_id from query parameter
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('order_id', $orderId)
                ->where('user_id', Auth::id())
                ->first();

            if ($order) {
                return view('payment-success', compact('order'));
            }
        }

        // If no order_id or order not found, get the latest paid order for this user
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'processing'])
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('beranda')->with('error', 'Order tidak ditemukan');
        }

        return view('payment-success', compact('order'));
    }

    public function pending(Request $request)
    {
        // Get order_id from query parameter
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('order_id', $orderId)
                ->where('user_id', Auth::id())
                ->first();

            if ($order) {
                return view('payment-pending', compact('order'));
            }
        }

        // If no order_id or order not found, get the latest pending order
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('beranda')->with('error', 'Order tidak ditemukan');
        }

        return view('payment-pending', compact('order'));
    }

    public function error(Request $request)
    {
        // Get order_id from query parameter
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('order_id', $orderId)
                ->where('user_id', Auth::id())
                ->first();

            if ($order) {
                return view('payment-error', compact('order'));
            }
        }

        // If no order_id or order not found, get the latest failed order
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', ['failed', 'cancelled', 'expired'])
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('beranda')->with('error', 'Order tidak ditemukan');
        }

        return view('payment-error', compact('order'));
    }

    public function checkPaymentStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|string',
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            // Get transaction status from Midtrans
            try {
                $transactionStatus = \Midtrans\Transaction::status($order->order_id);
                $statusArr = json_decode(json_encode($transactionStatus), true);

                $transactionStatus = $statusArr['transaction_status'] ?? null;
                $mappedStatus = 'pending';
                $statusDisplay = 'Menunggu Pembayaran';

                if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
                    $mappedStatus = 'paid';
                    $statusDisplay = 'Pembayaran Diterima';
                } elseif ($transactionStatus === 'deny') {
                    $mappedStatus = 'failed';
                    $statusDisplay = 'Pembayaran Ditolak';
                } elseif ($transactionStatus === 'expire') {
                    $mappedStatus = 'expired';
                    $statusDisplay = 'Transaksi Kadaluarsa';
                } elseif ($transactionStatus === 'cancel') {
                    $mappedStatus = 'cancelled';
                    $statusDisplay = 'Transaksi Dibatalkan';
                } elseif ($transactionStatus === 'pending') {
                    $mappedStatus = 'pending';
                    $statusDisplay = 'Menunggu Pembayaran';
                }

                // Update order status if status changed from Midtrans
                if ($order->status !== $mappedStatus) {
                    $order->update([
                        'status' => $mappedStatus,
                        'midtrans_response' => $statusArr,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'status' => $mappedStatus,
                    'status_display' => $statusDisplay,
                    'message' => 'Status berhasil diperbarui'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil status dari Midtrans: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint untuk melihat semua orders user
     */
    public function getOrders()
    {
        $orders = Order::with(['orderItems.product', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'status' => $order->status,
                    'gross_amount' => $order->gross_amount,
                    'payment_type' => $order->payment_type,
                    'paid_at' => $order->paid_at,
                    'created_at' => $order->created_at,
                    'items_count' => $order->orderItems->count(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * API endpoint untuk cek total orders di database
     */
    public function getOrdersCount()
    {
        $totalOrders = Order::count();
        $totalAmount = Order::sum('gross_amount');
        $paidOrders = Order::where('status', 'paid')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount,
                'paid_orders' => $paidOrders,
                'pending_orders' => $pendingOrders,
                'by_status' => [
                    'pending' => Order::where('status', 'pending')->count(),
                    'paid' => Order::where('status', 'paid')->count(),
                    'processing' => Order::where('status', 'processing')->count(),
                    'completed' => Order::where('status', 'completed')->count(),
                    'failed' => Order::where('status', 'failed')->count(),
                    'expired' => Order::where('status', 'expired')->count(),
                    'cancelled' => Order::where('status', 'cancelled')->count(),
                ]
            ]
        ]);
    }
}
