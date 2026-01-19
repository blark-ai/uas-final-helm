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

// --- 1. HALAMAN PUBLIK ---
// Halaman Depan (Hero Section saja)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Halaman Katalog (Katalog Lengkap & Search) - UNTUK FIX ERROR image_fb129f.png
Route::get('/katalog', [ProductController::class, 'allProducts'])->name('products.list');

// Halaman Detail Produk
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');


// --- 2. HALAMAN KHUSUS USER LOGIN ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Melihat produk sendiri)
    Route::get('/dashboard', [ProductController::class, 'myProducts'])->name('dashboard');

    // CRUD Produk
    Route::resource('products', ProductController::class)->except(['index', 'show']);

    // Fitur Beli (Langsung Store) - UNTUK FIX ERROR image_faa561.png (karena kita tidak pakai checkout)
    Route::post('/buy/{product}', [OrderController::class, 'store'])->name('order.store');

    // Fitur Generate Promosi - UNTUK FIX ERROR image_fb1a3e.png
    Route::get('/generate-post', [PostGeneratorController::class, 'create'])->name('post.create');
    Route::post('/generate-post', [PostGeneratorController::class, 'store'])->name('post.store');

    // Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';