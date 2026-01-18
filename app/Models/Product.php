<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Agar kita bisa isi semua kolom sekaligus
    protected $guarded = [];

    // Relasi: Produk dimiliki oleh satu User (penjual)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi: Satu produk bisa punya banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}