<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Yorum hangi ürüne yapıldı? (Ürün silinirse yorum da silinsin)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Yorumu hangi müşteri yaptı? (Müşteri silinirse yorum da silinsin)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Verilen puan (1 ile 5 arası bir rakam olacak)
            $table->integer('rating');
            
            // Yorum metni (Uzun olabileceği için text yapıyoruz)
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
