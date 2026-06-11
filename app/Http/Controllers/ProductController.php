<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;

class ProductController extends Controller
{
    // 1. Anasayfayı (Tüm ürünler ve kategoriler) gösterir
    public function index()
    {
        $products = Product::all(); 
        $categories = Category::all(); // Kategorileri veritabanından çek
        return view('welcome', compact('products', 'categories')); 
    }

    // Kategoriye Göre Ürünleri Filtreler
    public function category($slug)
    {
        $categories = Category::all(); // Menü kaybolmasın diye kategorileri tekrar çek

        $category = Category::query()->where('slug', $slug)->firstOrFail(); // Tıklanan kategoriyi bul
        $products = Product::query()->where('category_id', $category->id)->get(); // Sadece bu kategoriye ait ürünleri getir

        return view('welcome', compact('products', 'categories'));
    }

    // 2. Ürün ekleme formunu ekrana getirir
    public function create()
    {
        return view('create');
    }

    // 3. Formdan gelen verileri alıp veritabanına yazar
    public function store(Request $request)
    {
        $imagePath = 'placeholder.jpg'; // Eğer resim seçilmezse varsayılan resim

        // Formdan bir resim yüklendiyse
        if ($request->hasFile('image')) {
            // Resmi 'public/products' klasörüne kaydet ve yolunu al
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // GÜNCELLENDİ: Yeni alanlar veritabanına kaydediliyor
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'weight' => $request->weight,             // YENİ
            'flavor' => $request->flavor,             // YENİ
            'nutritional_info' => $request->nutritional_info // YENİ
        ]);

        return redirect('/');
    }

    // 4. Gelen ID'ye göre ürünü bulur ve veritabanından siler
    public function destroy($id)
    {
        $product = Product::findOrFail($id); // Ürünü bul (Bulamazsa 404 hatası verir)
        $product->delete(); // Ürünü sil

        return redirect('/'); // Silme işleminden sonra anasayfaya geri dön
    }

    // 5. Ürün düzenleme formunu mevcut bilgilerle ekrana getirir
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Güncellenecek ürünü bul
        return view('edit', compact('product')); // Bilgileri forma gönder
    }

    // 6. Formdan gelen yeni bilgileri veritabanında günceller
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Temel bilgileri güncelle
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        
        // GÜNCELLENDİ: Düzenleme sayfasından gelen yeni alanlar eşitleniyor
        $product->weight = $request->weight;                         // YENİ
        $product->flavor = $request->flavor;                         // YENİ
        $product->nutritional_info = $request->nutritional_info;     // YENİ

        // Eğer güncelleme formunda yeni bir resim seçildiyse
        if ($request->hasFile('image')) {
            // Yeni resmi kaydet ve eski resim yolunu güncelle
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect('/');
    }

    // 7. Sadece silinmiş (Çöp Kutusundaki) ürünleri ekrana getirir
    public function trash()
    {
        // onlyTrashed() komutu sadece silinenleri getirir
        $trashedProducts = Product::onlyTrashed()->get();
        return view('trash', compact('trashedProducts'));
    }

    // 8. Silinen ürünü tekrar vitrine geri döndürür
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore(); // Silinme etiketini kaldırır
        
        return redirect('/cop-kutusu');
    }

    // 9. Ürünü veritabanından kalıcı olarak (geri dönüşsüz) siler
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete(); // Veritabanından kazır
        
        return redirect('/cop-kutusu');
    }

    // 10. Ürün Detay sayfasını ve o ürüne ait yorumları gösterir
    public function show($id)
    {
        // Ürünü bulurken, ona ait yorumları ve o yorumu yapan müşterilerin isimlerini de birlikte çek
        $product = Product::with('reviews.user')->findOrFail($id);
        
        return view('show', compact('product'));
    }

    // 11. Ürüne yeni bir yorum ve puan ekler
    public function addReview(Request $request, $id)
    {
        // Yorum ve puan kurallarını kontrol et
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // Yorumu veritabanına kaydet
        Review::create([
            'product_id' => $id,
            'user_id' => Auth::id(), // Yorumu yapan kişinin (giriş yapmış olan) ID'sini al
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back(); // İşlem bitince kullanıcının olduğu aynı sayfaya (detay sayfasına) geri dön
    }
}