<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    // Relasi: Pesanan milik satu User (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Pesanan berisi satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}