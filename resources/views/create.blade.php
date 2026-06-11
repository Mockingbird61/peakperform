<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Ürün Ekle | PeakPerform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md my-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Yeni Takviye Ekle</h2>

        <form action="/urun-kaydet" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf 
            
            <div>
                <label class="block text-gray-700 font-medium mb-1">Ürün Adı</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Ürün Açıklaması</label>
                <textarea name="description" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Fiyat (₺)</label>
                <input type="number" step="0.01" name="price" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            
            <div>
                <label class="block text-gray-700 font-medium mb-1">Ürün Fotoğrafı</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 font-medium mb-1">Gramaj / Boyut</label>
                    <input type="text" name="weight" placeholder="Örn: 300g" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 font-medium mb-1">Aroma</label>
                    <input type="text" name="flavor" placeholder="Örn: Karpuz" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Besin Değerleri</label>
                <textarea name="nutritional_info" rows="3" placeholder="Örn:&#10;Kreatin Monohidrat: 5000mg&#10;B6 Vitamini: 1.4mg" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition mt-6">
                Ürünü Kaydet
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="/" class="text-blue-600 hover:underline text-sm">Geri Dön</a>
        </div>
    </div>

</body>
</html>