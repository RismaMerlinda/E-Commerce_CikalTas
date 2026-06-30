<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SalesReportController as AdminSalesReportController;
use App\Http\Controllers\Auth\RegisterStepController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('beranda');
    }
    $featuredProducts = \App\Models\Product::latest()->take(4)->get();
    
    // Fetch a hero product dynamically (preferring Tas Wanita or Tas Tote category from DB)
    $heroProduct = \App\Models\Product::where('category', 'Tas Wanita')->first() 
        ?? \App\Models\Product::where('category', 'Tas Tote')->first();

    $categories = \App\Models\Product::select('category')
        ->selectRaw('count(*) as count')
        ->groupBy('category')
        ->get()
        ->map(function ($item) {
            $firstProduct = \App\Models\Product::where('category', $item->category)->first();
            $item->image = $firstProduct ? $firstProduct->image : null;
            return $item;
        });
    return view('welcome', compact('featuredProducts', 'categories', 'heroProduct'));
});

Route::get('/fix-images', function() {
    $products = \App\Models\Product::all();
    $count = 0;
    foreach ($products as $product) {
        if ($product->image) {
            $newImage = str_replace(['produk/', '.jpg'], ['gambar/produk/', '.png'], $product->image);
            if ($newImage !== $product->image) {
                $product->update(['image' => $newImage]);
                $count++;
            }
        }
    }
    return "Berhasil update $count path gambar! Silakan kembali ke beranda.";
});

// Auth routes (login, logout, forgot password, etc.) - Laravel Breeze or default auth
require __DIR__ . '/auth.php';



// Register 2 step (Guest only) - Override default register from auth.php
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/register', [RegisterStepController::class, 'showStep1'])->name('register');
    Route::post('/register/step1', [RegisterStepController::class, 'step1'])
        ->name('register.step1');

    Route::get('/register/step2', [RegisterStepController::class, 'showStep2'])->name('register.step2');
    Route::post('/register/step2', [RegisterStepController::class, 'step2'])->name('register.step2.post');
});

// Forgot Password Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request.custom');

    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email.custom');

    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])
        ->name('password.update.custom');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Product Detail
    Route::get('/produk/{id}', [BerandaController::class, 'show'])->name('produk.show');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/add', [CartController::class, 'add'])->name('keranjang.add');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('keranjang.remove');
    Route::delete('/keranjang', [CartController::class, 'clear'])->name('keranjang.clear');
    Route::get('/keranjang/count', [CartController::class, 'count'])->name('keranjang.count');

    // Pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan');

    // Pembayaran
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran/create', [PaymentController::class, 'createTransaction'])->name('pembayaran.create');
    Route::get('/pembayaran/qr', [PaymentController::class, 'qr'])->name('pembayaran.qr');
    Route::post('/api/update-order-status', [PaymentController::class, 'updateOrderStatus'])->name('api.update-order-status');
    Route::post('/api/check-payment-status', [PaymentController::class, 'checkPaymentStatus'])->name('api.check-payment-status');
    Route::get('/api/orders', [PaymentController::class, 'getOrders'])->name('api.orders');
    Route::get('/api/orders-count', [PaymentController::class, 'getOrdersCount'])->name('api.orders-count');
    Route::get('/pembayaran/success', [PaymentController::class, 'success'])->name('pembayaran.success');
    Route::get('/pembayaran/pending', [PaymentController::class, 'pending'])->name('pembayaran.pending');
    Route::get('/pembayaran/error', [PaymentController::class, 'error'])->name('pembayaran.error');

    // Profil routes
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');

    // Chatbot AI
    Route::post('/chatbot', [ChatbotController::class, 'ask'])->name('chatbot');
    Route::get('/chatbot/history', [ChatbotController::class, 'history'])->name('chatbot.history');

    // Customer Support (User Side)
    Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::post('/support/reply', [App\Http\Controllers\SupportController::class, 'reply'])->name('support.reply');
    Route::get('/support/fetch', [App\Http\Controllers\SupportController::class, 'fetchMessages'])->name('support.fetch');
    Route::post('/support/contact-admin', [App\Http\Controllers\SupportController::class, 'contactAdmin'])->name('support.contact-admin');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/sales-report', [AdminSalesReportController::class, 'index'])->name('sales-report');

    // Pesan Pelanggan (Customer Support)
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
});

// Dashboard (protected) - redirect to beranda or admin
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (Auth::check() && $user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('beranda');
})->middleware(['auth'])->name('dashboard');
