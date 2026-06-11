<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çöp Kutusu | PeakPerform Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Patron Paneli <span class="text-sm text-gray-500 font-normal">| Çöp Kutusu</span></h1>
            <a href="/" class="text-blue-600 hover:underline font-medium">Vitrine Dön</a>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 py-12 max-w-5xl">
        
        @if($trashedProducts->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white uppercase text-sm tracking-wider">
                            <th class="py-4 px-6">Ürün Görseli / Adı</th>
                            <th class="py-4 px-6 text-center">Silinme Tarihi</th>
                            <th class="py-4 px-6 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashedProducts as $product)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-4 px-6 flex items-center min-w-max">
                                    <div class="w-12 h-12 bg-gray-200 rounded overflow-hidden mr-4 flex-shrink-0">
                                        @if($product->image && $product->image != 'placeholder.jpg')
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover grayscale opacity-70">
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-500 line-through">{{ $product->name }}</span>
                                </td>
                                <td class="py-4 px-6 text-center text-gray-500 text-sm">
                                    {{ $product->deleted_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="py-4 px-6 text-right flex justify-end space-x-2">
                                    <form action="/urun-kurtar/{{ $product->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 bg-green-500 text-white font-semibold rounded shadow hover:bg-green-600 transition text-sm">
                                            Vitrine Geri Getir
                                        </button>
                                    </form>

                                    <form action="/urun-kalici-sil/{{ $product->id }}" method="POST" onsubmit="return confirm('Bu ürünü tamamen yok etmek istediğinize emin misiniz? Bu işlem geri alınamaz!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-700 text-white font-semibold rounded shadow hover:bg-red-800 transition text-sm">
                                            Kalıcı Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4 text-gray-300">🗑️</div>
                <h2 class="text-2xl font-bold text-gray-600 mb-2">Çöp Kutusu Tertemiz</h2>
                <p class="text-gray-500">Silinmiş hiçbir takviye bulunmuyor.</p>
            </div>
        @endif

    </main>

</body>
</html>