<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Midtrans Callback (No Auth Required)
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');