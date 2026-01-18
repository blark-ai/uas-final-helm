<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // [PUBLIC] Halaman Depan: Menampilkan semua produk + Search
    public function index(Request $request)
    {
        $query = Product::query();

        // Logika Search (Nama atau Deskripsi)
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru, 9 per halaman
        $products = $query->latest()->paginate(9);

        return view('welcome', compact('products'));
    }

    // [PUBLIC] Halaman Detail Satu Produk
    public function show(Product $product)
    {
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
        // 1. Bersihkan Format Rupiah (Hapus titik "." dari input "15.000")
        // Penting dilakukan sebelum validasi 'numeric'
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }

        // 2. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric', // Sekarang aman dicek numeric karena titik sudah hilang
            'description' => 'required',
            'production_address' => 'required',
            'maps_link' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
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

    // [CLIENT] Menampilkan Form Edit (BARU)
    public function edit(Product $product)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin mengedit produk ini.');
        }
        return view('products.edit', compact('product'));
    }

    // [CLIENT] Proses Update Data (BARU)
    public function update(Request $request, Product $product)
    {
        // 1. Cek Pemilik
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Bersihkan Format Rupiah
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }

        // 3. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'production_address' => 'required',
            'maps_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Nullable artinya boleh kosong (kalau gak ganti foto)
        ]);

        // 4. Siapkan Data Update
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'production_address' => $request->production_address,
            'maps_link' => $request->maps_link,
        ];

        // 5. Cek jika ada upload foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama dari storage biar bersih
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan foto baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Update Database
        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui!');
    }
    
    // [CLIENT] Hapus Produk
    public function destroy(Product $product)
    {
        // Pastikan yang menghapus adalah pemiliknya
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Hapus foto dari storage sebelum hapus data di DB
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }
}