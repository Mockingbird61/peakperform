<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('weight')->nullable()->after('description'); // Gramaj (örn: 300g, 30 Servis)
            $table->string('flavor')->nullable()->after('weight'); // Aroma (örn: Aromasız, Karpuz)
            $table->text('nutritional_info')->nullable()->after('flavor'); // Besin Değerleri (Uzun metin)
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'flavor', 'nutritional_info']);
        });
    }
};
