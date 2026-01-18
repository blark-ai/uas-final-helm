<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostGeneratorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Website)
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK (Bisa diakses siapa saja) ---

// Halaman Depan (Landing Page & List Produk)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Halaman Detail Produk
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');


// --- HALAMAN KHUSUS USER LOGIN (Client) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Client (Lihat produk sendiri)
    Route::get('/dashboard', [ProductController::class, 'myProducts'])->name('dashboard');

    // CRUD Produk (Tambah, Edit, Hapus Produk)
    // Kita kecualikan index/show karena itu sudah ada di publik
    Route::resource('products', ProductController::class)->except(['index', 'show']);

    // Fitur Beli (Simulasi Order)
    Route::post('/buy/{product}', [OrderController::class, 'store'])->name('order.store');

    // Fitur Generate Post (Promosi Otomatis)
    Route::get('/generate-post', [PostGeneratorController::class, 'create'])->name('post.create'); // Form
    Route::post('/generate-post', [PostGeneratorController::class, 'store'])->name('post.store'); // Proses Generate

    // Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load rute autentikasi bawaan Breeze (Login/Register)
require __DIR__.'/auth.php';