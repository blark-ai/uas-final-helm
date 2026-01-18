<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Cek apakah user mencoba membeli produknya sendiri (opsional)
        if ($product->user_id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa membeli produk sendiri.');
        }

        // Simpan data order
        Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'status' => 'pending' // Simulasi status pending
        ]);

        return back()->with('success', "Pesanan untuk {$product->name} berhasil dibuat! Penjual akan menghubungi Anda.");
    }
}