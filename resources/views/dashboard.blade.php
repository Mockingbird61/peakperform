<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patron Paneli | PeakPerform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex flex-col min-h-screen">

    <nav class="bg-gray-900 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-xl">PeakPerform <span class="text-blue-400 font-light">Yönetim</span></div>
            <div class="flex space-x-4 items-center">
                <a href="/" class="text-gray-300 hover:text-white transition">Vitrine Dön</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-sm">Çıkış Yap</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 flex-grow">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Genel Bakış</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="text-gray-500 text-sm uppercase font-bold tracking-wider mb-1">Toplam Ciro</div>
                <div class="text-3xl font-black text-gray-800">{{ number_format($toplamGelir, 2, ',', '.') }} ₺</div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="text-gray-500 text-sm uppercase font-bold tracking-wider mb-1">Toplam Sipariş</div>
                <div class="text-3xl font-black text-gray-800">{{ $toplamSiparis }} <span class="text-sm font-normal text-gray-500">adet</span></div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="text-gray-500 text-sm uppercase font-bold tracking-wider mb-1">Aktif Ürün</div>
                <div class="text-3xl font-black text-gray-800">{{ $toplamUrun }} <span class="text-sm font-normal text-gray-500">çeşit</span></div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-800">Son Siparişler</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider border-b">
                            <th class="py-3 px-6">Sipariş ID</th>
                            <th class="py-3 px-6">Müşteri Bilgisi</th>
                            <th class="py-3 px-6">Tarih</th>
                            <th class="py-3 px-6">Durum</th>
                            <th class="py-3 px-6 text-right">Tutar</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($siparisler as $siparis)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-bold text-blue-600">#{{ $siparis->id }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold">{{ $siparis->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $siparis->customer_email }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $siparis->address }}</div>
                                </td>
                                <td class="py-4 px-6 text-sm">{{ $siparis->created_at->format('d.m.Y H:i') }}</td>
                                <td class="py-4 px-6">
                                    <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold">{{ $siparis->status }}</span>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-gray-900">{{ number_format($siparis->total_price, 2, ',', '.') }} ₺</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">Henüz hiç sipariş alınmamış.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>