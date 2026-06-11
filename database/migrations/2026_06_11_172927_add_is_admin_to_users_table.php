<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
 {
     Schema::table('users', function (Blueprint $table) {
         // Yeni üye olan herkes varsayılan olarak müşteri (false) olacak
         $table->boolean('is_admin')->default(false); 
     });
 }

 public function down(): void
 {
     Schema::table('users', function (Blueprint $table) {
         $table->dropColumn('is_admin');
     });
 }
};
