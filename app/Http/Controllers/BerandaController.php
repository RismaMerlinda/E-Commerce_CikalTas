<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Redirect admin ke dashboard admin
        $user = Auth::user();
        if (Auth::check() && $user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $search = $request->get('q');

        $products = Product::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->appends(['q' => $search]);

        return view('beranda', compact('products', 'search'));
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
