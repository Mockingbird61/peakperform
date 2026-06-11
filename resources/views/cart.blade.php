<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim | PeakPerform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-gray-800">

    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">PeakPerform</a>
            <a href="/" class="text-blue-600 hover:underline font-medium">Anasayfaya Dön</a>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Alışveriş Sepetim</h1>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider border-b">
                            <th class="py-4 px-6">Takviye</th>
                            <th class="py-4 px-6 text-center">Birim Fiyat</th>
                            <th class="py-4 px-6 text-center">Adet</th>
                            <th class="py-4 px-6 text-right">Toplam</th>
                            <th class="py-4 px-6 text-center">İşlem</th> </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-6 flex items-center">
                                    <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden mr-4 flex shrink-0 items-center justify-center">
                                        @if(isset($details['image']) && $details['image'] != 'placeholder.jpg')
                                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Görsel</span>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $details['name'] }}</span>
                                </td>
                                <td class="py-4 px-6 text-center text-gray-600">{{ number_format($details['price'], 0) }} ₺</td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="/sepette-guncelle/{{ $id }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300 font-black transition flex items-center justify-center">
                                                -
                                            </button>
                                        </form>

                                        <span class="font-bold text-lg w-6 text-center">{{ $details['quantity'] }}</span>

                                        <form action="/sepette-guncelle/{{ $id }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300 font-black transition flex items-center justify-center">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-gray-900">{{ number_format($details['price'] * $details['quantity'], 0) }} ₺</td>
                                <td class="py-4 px-6 text-center">
                                    <form action="/sepetten-cikar/{{ $id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold bg-red-50 hover:bg-red-100 px-3 py-2 rounded transition text-sm">
                                            Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                <div class="w-full md:w-1/2 bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Teslimat Bilgileri</h3>
                    <form action="/siparis-tamamla" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <input type="text" name="customer_name" placeholder="Adınız Soyadınız" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                        </div>
                        <div>
                            <input type="email" name="customer_email" placeholder="E-Posta Adresiniz" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                        </div>
                        <div>
                            <textarea name="address" placeholder="Tam Teslimat Adresi" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm" rows="3"></textarea>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded shadow font-bold hover:bg-green-700 transition w-full text-lg">
                            Siparişi Onayla ve Bitir
                        </button>
                    </form>
                </div>

                <div class="w-full md:w-1/2 bg-white p-6 rounded-lg shadow text-right">
                    <div class="text-gray-600 mb-2 text-lg">Genel Toplam</div>
                    <div class="text-4xl font-black text-blue-600">{{ number_format($total, 0) }} ₺</div>
                </div>
            </div>

        @else
            <div class="bg-white rounded-lg shadow p-12 text-center border-t-4 border-blue-500">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Sepetiniz şu an boş</h2>
                <p class="text-gray-500 mb-6">Antrenmanını zirveye taşımak için hemen takviyelerini seçmeye başla.</p>
                <a href="/" class="bg-blue-600 text-white px-6 py-3 rounded font-bold hover:bg-blue-700 transition inline-block">
                    Vitrine Dön
                </a>
            </div>
        @endif
    </main>

</body>
</html>