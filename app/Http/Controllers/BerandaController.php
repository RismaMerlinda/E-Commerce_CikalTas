<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        // Redirect admin ke dashboard admin
        $user = Auth::user();
        if (Auth::check() && $user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $products = Product::latest()->paginate(9);

        return view('beranda', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
}
