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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name'); // Müşteri Adı
            $table->string('customer_email'); // Müşteri E-postası
            $table->text('address'); // Teslimat Adresi
            $table->decimal('total_price', 10, 2); // Sepetin Genel Toplamı
            $table->string('status')->default('Bekliyor'); // Siparişin Durumu
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
