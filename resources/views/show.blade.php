<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | PeakPerform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">PeakPerform</a>
            <a href="/" class="text-gray-600 hover:text-blue-600 font-medium">← Vitrine Dön</a>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row mb-12">
            <div class="md:w-1/2 bg-gray-100 flex items-center justify-center p-8">
                @if($product->image && $product->image != 'placeholder.jpg')
                    <img src="{{ asset('storage/' . $product->image) }}" class="max-h-96 object-contain">
                @else
                    <span class="text-gray-400 font-medium">Görsel Yok</span>
                @endif
            </div>
            
            <div class="md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <span class="text-sm text-blue-600 font-bold tracking-widest uppercase mb-2">Sporcu Takviyesi</span>
                <h1 class="text-3xl lg:text-4xl font-black text-gray-900 mb-4">{{ $product->name }}</h1>
                <p class="text-gray-600 text-lg mb-6 leading-relaxed">{{ $product->description }}</p>
                <div class="bg-gray-50 border border-gray-100 rounded-lg p-5 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 border-b pb-2">Ürün Özellikleri</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex justify-between">
                            <span class="text-gray-500 font-medium">Gramaj / Boyut:</span>
                            <span class="text-gray-900 font-bold">{{ $product->weight ?? 'Belirtilmemiş' }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500 font-medium">Aroma:</span>
                            <span class="text-gray-900 font-bold">{{ $product->flavor ?? 'Belirtilmemiş' }}</span>
                        </li>
                    </ul>
                    
                    @if($product->nutritional_info)
                        <h3 class="font-bold text-gray-800 mt-4 mb-2 border-b pb-2">Besin Değerleri (1 Servis)</h3>
                        <p class="text-gray-600 text-sm whitespace-pre-line">{{ $product->nutritional_info }}</p>
                    @endif
                </div>
                
                <div class="text-4xl font-black text-gray-900 mb-8">{{ $product->price }} ₺</div>
                
                <form action="/sepete-ekle/{{ $product->id }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-lg shadow-lg hover:bg-gray-800 transition text-lg">
                        🛒 Sepete Ekle
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 lg:p-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Değerlendirmeler ({{ $product->reviews->count() }})</h2>

            @auth
                <form action="/urun/{{ $product->id }}/yorum" method="POST" class="mb-10 bg-gray-50 p-6 rounded-lg border border-gray-100">
                    @csrf
                    <h3 class="font-bold text-gray-700 mb-4">Senin Değerlendirmen</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Puanın</label>
                        <select name="rating" required class="w-full md:w-48 border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="5">⭐⭐⭐⭐⭐ (5 Yıldız)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Yıldız)</option>
                            <option value="3">⭐⭐⭐ (3 Yıldız)</option>
                            <option value="2">⭐⭐ (2 Yıldız)</option>
                            <option value="1">⭐ (1 Yıldız)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Yorumun</label>
                        <textarea name="comment" rows="3" required class="w-full border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Ürün hakkında ne düşünüyorsun?"></textarea>
                    </div>
                    
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-semibold hover:bg-blue-700 transition">
                        Gönder
                    </button>
                </form>
            @else
                <div class="bg-blue-50 text-blue-800 p-4 rounded-lg mb-10 border border-blue-100 flex items-center justify-between">
                    <span>Yorum yapabilmek için giriş yapmalısın.</span>
                    <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 text-sm transition">Giriş Yap</a>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($product->reviews->sortByDesc('created_at') as $review)
                    <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-gray-800">{{ $review->user->name }}</span>
                            <span class="text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="text-yellow-400 text-sm mb-2">
                            {{ str_repeat('⭐', $review->rating) }}
                        </div>
                        <p class="text-gray-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Bu ürüne henüz yorum yapılmamış. İlk yorumu sen yap!</p>
                @endforelse
            </div>
            
        </div>
    </main>

</body>
</html>