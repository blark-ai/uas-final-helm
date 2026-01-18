<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // Siapa yang beli? (User)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Beli produk apa? (Product)
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        $table->string('status')->default('pending'); // Status pesanan (pending/sukses)
        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
