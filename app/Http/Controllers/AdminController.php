<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. ÇÖZÜM: VS Code'un "is_admin" özelliğini bulamama hatasını engellemek için 
        // Laravel'in evrensel getAttribute() fonksiyonunu kullanıyoruz.
        if (!Auth::check() || Auth::user()->getAttribute('is_admin') != 1) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        // 2. ÇÖZÜM: Modelleri tepede "use" ile çağırmak yerine doğrudan 
        // tam yollarıyla (namespace) çağırarak eklentinin kafasının karışmasını önlüyoruz.
        $toplamSiparis = \App\Models\Order::query()->count('*');
        $toplamGelir = \App\Models\Order::query()->sum('total_price');
        $toplamUrun = \App\Models\Product::query()->count('*');

        // Son gelen siparişleri tarihe göre yeniden eskiye doğru sıralayıp al
        $siparisler = \App\Models\Order::query()->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('toplamSiparis', 'toplamGelir', 'toplamUrun', 'siparisler'));
    }
}