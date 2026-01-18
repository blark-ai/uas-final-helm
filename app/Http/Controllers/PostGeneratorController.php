<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Request;

class PostGeneratorController extends Controller
{
    // Tampilkan halaman pilih produk & target market
    public function create()
    {
        // User hanya bisa generate untuk produk miliknya sendiri
        $products = auth()->user()->products;
        return view('posts.create', compact('products'));
    }

    // Proses Generate Teks
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'target_market' => 'required|string'
        ]);

        $product = Product::find($request->product_id);
        $target = $request->target_market;

        // --- TEMPLATE ENGINE SEDERHANA ---
        // Kita siapkan beberapa pola kalimat
        $templates = [
            "Halo {$target}! 👋 Bingung cari {$product->name} yang berkualitas? Produk kami solusinya. Diproduksi langsung di {$product->production_address}. Cek sekarang!",
            
            "Spesial untuk {$target}! ✨ Dukung produk lokal dengan membeli {$product->name}. Harga cuma Rp " . number_format($product->price) . ". Lokasi: {$product->maps_link}",
            
            "Promo Spesial! 🔥 {$product->name} hadir untuk {$target}. Kualitas terbaik, harga bersahabat. Yuk dukung UMKM lokal!",
            
            "Warga {$product->production_address} dan sekitarnya! Cari {$product->name}? Kami punya stok fresh buat {$target}. Pesan sekarang sebelum kehabisan."
        ];

        // Pilih 1 template secara acak
        $generatedText = $templates[array_rand($templates)];

        // Simpan hasil ke database
        $post = Post::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'target_market' => $target,
            'content' => $generatedText
        ]);

        // Kembalikan ke halaman sebelumnya dengan membawa data hasil generate
        return back()->with('generated_post', $post);
    }
}