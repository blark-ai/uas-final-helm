<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // [PUBLIC] Halaman Depan: Hanya menampilkan Hero Section
    public function index()
    {
        // Karena halaman depan sekarang hanya Hero, kita tidak perlu memanggil data produk di sini
        return view('welcome');
    }

    // [PUBLIC] Halaman Katalog: Menampilkan SEMUA produk + Fitur Search dari Navbar
    public function allProducts(Request $request)
    {
        $query = Product::query();

        // Logika Search yang dipindahkan ke Navbar
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru, 9 per halaman agar rapi di grid 3 kolom
        $products = $query->latest()->paginate(9);

        // Mengembalikan view 'products.blade.php' yang tadi kita buat
        return view('products', compact('products'));
    }

    // [PUBLIC] Halaman Detail Satu Produk
    public function show(Product $product)
    {
        // Pastikan kamu sudah punya file resources/views/products/show.blade.php
        return view('products.show', compact('product'));
    }

    // [CLIENT] Halaman Dashboard (Produk Saya)
    public function myProducts()
    {
        // Ambil produk milik user yang sedang login saja
        $products = auth()->user()->products()->latest()->get();
        return view('dashboard', compact('products'));
    }

    // [CLIENT] Menampilkan Form Tambah Produk
    public function create()
    {
        return view('products.create');
    }

    // [CLIENT] Proses Simpan Produk Baru
    public function store(Request $request)
    {
        // 1. Bersihkan Format Rupiah
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }

        // 2. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'production_address' => 'required',
            'maps_link' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 3. Upload Gambar
        $imagePath = $request->file('image')->store('products', 'public');

        // 4. Simpan ke Database
        Product::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'production_address' => $request->production_address,
            'maps_link' => $request->maps_link,
            'image' => $imagePath
        ]);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    // [CLIENT] Menampilkan Form Edit
    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin mengedit produk ini.');
        }
        return view('products.edit', compact('product'));
    }

    // [CLIENT] Proses Update Data
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'production_address' => 'required',
            'maps_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'production_address' => $request->production_address,
            'maps_link' => $request->maps_link,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui!');
    }
    
    // [CLIENT] Hapus Produk
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }
}