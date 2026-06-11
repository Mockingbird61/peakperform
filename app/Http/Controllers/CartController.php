<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    // Ürünü sepete ekleme işlemi
    public function add($id)
    {
        $product = Product::findOrFail($id);
        
        // Mevcut sepeti hafızadan al (yoksa boş bir dizi oluştur)
        $cart = session()->get('cart', []);

        // Eğer ürün zaten sepette varsa, sadece miktarını artır
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Eğer ürün sepette yoksa, yeni ürün olarak ekle
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // Güncel sepeti tekrar hafızaya kaydet
        session()->put('cart', $cart);

        // Kullanıcıyı geldiği sayfaya geri gönder
        return redirect()->back();
    }

    // Sepet sayfasını görüntüleme işlemi (Bunu bir sonraki adımda tasarlayacağız)
    public function index()
    {
        return view('cart');
    }
    // Siparişi tamamlayıp veritabanına kaydeder
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        
        if(!$cart) {
            return redirect('/'); // Sepet boşsa anasayfaya at
        }

        // Sepet toplamını hesapla
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 1. Siparişi 'orders' tablosuna kaydet
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'address' => $request->address,
            'total_price' => $total,
        ]);

        // 2. Sepetteki her ürünü 'order_items' tablosuna sipariş detayı olarak kaydet
        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        // 3. Sipariş alındıktan sonra sepeti hafızadan sil (boşalt)
        session()->forget('cart');

        // Şimdilik işlemi bitirip anasayfaya yönlendiriyoruz (İleride buraya bir teşekkür sayfası ekleyeceğiz)
        return redirect('/');
    }
    // Sepetten seçilen ürünü siler
    public function remove($id)
    {
        $cart = session()->get('cart');

        // Eğer ürün sepette gerçekten varsa, onu diziden (sepetten) tamamen çıkar
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Sepetin yeni halini kaydet
        }

        // İşlem bitince sepet sayfasına geri dön
        return redirect('/sepet');
    }
    // Sepetteki ürünün miktarını artırır veya azaltır
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            // Butondan gelen komut 'increase' (artır) ise
            if($request->action == 'increase') {
                $cart[$id]['quantity']++;
            } 
            // Butondan gelen komut 'decrease' (azalt) ise
            elseif($request->action == 'decrease') {
                $cart[$id]['quantity']--;
                
                // Eğer miktar 0'a düşerse ürünü tamamen sepetten sil
                if($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }
            
            session()->put('cart', $cart); // Sepetin yeni halini kaydet
        }

        return redirect('/sepet');
    }
}