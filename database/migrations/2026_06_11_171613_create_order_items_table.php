<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Sipariş silinirse, bu detaylar da silinsin (cascade)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Ürün vitrinden silinse bile sipariş geçmişinde kalsın diye nullable yapıyoruz
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            
            $table->integer('quantity'); // Kaç adet alındı
            $table->decimal('price', 10, 2); // Alındığı andaki birim fiyatı
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
