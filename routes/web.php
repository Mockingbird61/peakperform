<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;


// 1. HERKESE AÇIK ROTALAR (Ziyaretçiler görebilir)
Route::get('/', [ProductController::class, 'index']);
// Kategori filtreleme rotası
Route::get('/kategori/{slug}', [ProductController::class, 'category']);
// Sepet İşlemleri
Route::post('/sepete-ekle/{id}', [CartController::class, 'add']);
Route::get('/sepet', [CartController::class, 'index']);
Route::post('/siparis-tamamla', [CartController::class, 'checkout']);
Route::post('/sepetten-cikar/{id}', [CartController::class, 'remove']);
Route::post('/sepette-guncelle/{id}', [CartController::class, 'update']);

// Ürün Detay ve Yorum Rotaları
Route::get('/urun/{id}', [ProductController::class, 'show']);
Route::post('/urun/{id}/yorum', [ProductController::class, 'addReview'])->middleware('auth');


// Giriş ve Çıkış işlemleri
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Kayıt Ol İşlemleri
Route::get('/kayit-ol', [AuthController::class, 'showRegister'])->name('register');
Route::post('/kayit-ol', [AuthController::class, 'register']);


// 2. SADECE YÖNETİCİLERE ÖZEL ROTALAR (Güvenlik Kilidi)
Route::middleware('auth')->group(function () {
    // Patron Paneli Rotası
    Route::get('/admin', [AdminController::class, 'dashboard']);
    Route::get('/urun-ekle', [ProductController::class, 'create']);
    Route::post('/urun-kaydet', [ProductController::class, 'store']);
    Route::get('/urun-duzenle/{id}', [ProductController::class, 'edit']);
    Route::put('/urun-guncelle/{id}', [ProductController::class, 'update']);
    Route::delete('/urun-sil/{id}', [ProductController::class, 'destroy']);
    // Çöp Kutusu İşlemleri
    Route::get('/cop-kutusu', [ProductController::class, 'trash']);
    Route::post('/urun-kurtar/{id}', [ProductController::class, 'restore']);
    Route::delete('/urun-kalici-sil/{id}', [ProductController::class, 'forceDelete']);

    
});