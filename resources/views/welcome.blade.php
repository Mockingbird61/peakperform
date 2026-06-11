<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeakPerform | Sporcu Takviyeleri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 text-gray-200">

    <header class="bg-gray-900 shadow-lg border-b border-gray-800">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-blue-500 tracking-wider">PeakPerform</a>
            
            <nav class="hidden md:flex space-x-6">
                <a href="/" class="text-gray-300 hover:text-blue-400 font-medium transition">Tüm Takviyeler</a>

                @foreach($categories as $category)
                    <a href="/kategori/{{ $category->slug }}" class="text-gray-300 hover:text-blue-400 font-medium uppercase text-sm tracking-wide transition">
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center">
                @if(auth()->check() && auth()->user()->is_admin)
                    <span class="text-gray-300 font-medium mr-4">Hoş Geldin, Patron ({{ auth()->user()->name }})</span>
                    
                    <a href="/urun-ekle" class="bg-green-600 text-white px-3 py-2 rounded shadow hover:bg-green-500 transition mr-2 text-sm font-semibold">
                        + Yeni Ürün
                    </a>
                    
                    <a href="/admin" class="bg-blue-600 text-white px-3 py-2 rounded shadow hover:bg-blue-500 transition mr-2 text-sm font-semibold">
                        📊 Yönetim Paneli
                    </a>
                    
                    <a href="/cop-kutusu" class="bg-gray-700 text-gray-200 px-3 py-2 rounded shadow hover:bg-gray-600 transition mr-4 text-sm font-semibold border border-gray-600">
                        🗑️ Çöp Kutusu
                    </a>

                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-400 hover:underline font-medium mr-4 transition">Çıkış Yap</button>
                    </form>
                @elseif(auth()->check())
                    <span class="text-gray-300 font-medium mr-4">Hoş Geldin, {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-400 hover:underline font-medium mr-4 transition">Çıkış Yap</button>
                    </form>
                @else
                    <a href="/login" class="text-gray-300 hover:text-blue-400 font-medium mr-4 transition">Giriş Yap</a>
                    <a href="/kayit-ol" class="bg-gray-700 text-white px-4 py-2 rounded shadow hover:bg-gray-600 border border-gray-600 transition mr-4 text-sm font-semibold">Kayıt Ol</a>
                @endif

                <a href="/sepet" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition font-bold tracking-wide">
                    Sepet ({{ session('cart') ? count(session('cart')) : 0 }})
                </a>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-gray-900 text-white py-24 text-center border-b border-gray-800 shadow-inner">
            <h1 class="text-4xl md:text-5xl font-black mb-4 tracking-tight">Antrenmanını Zirveye Taşı</h1>
            <p class="text-lg text-gray-400 mb-8 font-light">En iyi performans için ihtiyacın olan tüm takviyeler tek bir yerde.</p>
        </section>

        <section class="container mx-auto px-6 py-16">
            <h2 class="text-3xl font-bold text-gray-100 text-center mb-10 tracking-wide">Öne Çıkan Ürünler</h2>
            
            <div class="mb-12 flex justify-center">
                <input type="text" id="searchInput" placeholder="Ürün ara... (örn: kreatin)" class="w-full md:w-1/2 px-5 py-3 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-lg shadow-inner focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach($products as $product)
                <div class="bg-gray-700 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:shadow-black/50 transition-all duration-300 flex flex-col justify-between border border-gray-600">
                    
                    <div>
                        <div class="h-64 bg-gray-600 flex items-center justify-center overflow-hidden">
                            @if($product->image && $product->image != 'placeholder.jpg')
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 font-medium text-sm">Görsel Yok</span>
                            @endif
                        </div>

                        <div class="p-6 pb-0">
                            <span class="text-xs text-blue-400 font-bold tracking-widest uppercase">Takviye</span>
                            <a href="/urun/{{ $product->id }}" class="block">
                                <h3 class="text-xl font-bold text-gray-100 mt-2 hover:text-blue-400 transition">{{ $product->name }}</h3>
                            </a>
                            <p class="text-gray-400 mt-2 text-sm line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="p-6 pt-0">
                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-2xl font-black text-gray-100">{{ $product->price }} ₺</span>
                            
                            <div class="flex space-x-2 items-center">
                                
                                @if(auth()->check() && auth()->user()->is_admin)
                                    <a href="/urun-duzenle/{{ $product->id }}" class="px-2 py-2 bg-yellow-600 text-white font-semibold rounded shadow hover:bg-yellow-500 transition text-xs text-center flex items-center justify-center">
                                        Düzenle
                                    </a>
                                    <form action="/urun-sil/{{ $product->id }}" method="POST" onsubmit="return confirm('Bu takviyeyi vitrinden kaldırmak istediğine emin misin?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-2 bg-red-600 text-white font-semibold rounded shadow hover:bg-red-500 transition text-xs">
                                            Sil
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="/urun/{{ $product->id }}" class="px-3 py-2 bg-gray-600 text-gray-200 font-bold rounded shadow hover:bg-gray-500 transition text-xs text-center border border-gray-500">
                                    İncele
                                </a>

                                <form action="/sepete-ekle/{{ $product->id }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white font-bold rounded shadow hover:bg-blue-500 transition text-xs whitespace-nowrap tracking-wide">
                                        Sepete Ekle
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </section>
    </main>

    <script>
        const searchInput = document.getElementById('searchInput');
        const productCards = document.querySelectorAll('.grid > div'); 

        searchInput.addEventListener('input', (event) => {
            const searchTerm = event.target.value.toLowerCase();
            productCards.forEach((card) => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>