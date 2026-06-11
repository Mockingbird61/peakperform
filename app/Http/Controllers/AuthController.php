<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Giriş sayfasını gösterir
    public function showLogin()
    {
        return view('login');
    }

    // Bilgileri kontrol edip sisteme sokar
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/'); // Şifre doğruysa anasayfaya at
        }

        return back()->withErrors(['email' => 'E-posta adresi veya şifre hatalı!']);
    }

    // Sistemden güvenle çıkış yapar
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    // Kayıt olma sayfasını gösterir
    public function showRegister()
    {
        return view('register');
    }

    // Ziyaretçiyi sisteme müşteri olarak kaydeder
    public function register(Request $request)
    {
        // 1. Gelen bilgilerin doğruluğunu kontrol et (E-posta daha önce alınmış mı vs.)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        // 2. Yeni kullanıcıyı veritabanına ekle (is_admin otomatik false olur)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Şifreyi şifrele
        ]);

        // 3. Kullanıcıyı otomatik olarak sisteme giriş yaptır
        Auth::login($user);

        // 4. Anasayfaya yönlendir
        return redirect('/');
    }
}