<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update paths from .jpg to .png and add 'gambar/' prefix
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            if ($product->image) {
                $newImage = str_replace(['produk/', '.jpg'], ['gambar/produk/', '.png'], $product->image);
                $product->update(['image' => $newImage]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            if ($product->image) {
                $oldImage = str_replace(['gambar/produk/', '.png'], ['produk/', '.jpg'], $product->image);
                $product->update(['image' => $oldImage]);
            }
        }
    }
};
