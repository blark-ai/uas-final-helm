<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Perhatikan ini: create('posts'), BUKAN 'orders'
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // --- INI KOLOM YANG TADI HILANG (Penyebab Error) ---
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // ---------------------------------------------------

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('target_market');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};