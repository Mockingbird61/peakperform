<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol | PeakPerform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">PeakPerform'a Katıl</h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/kayit-ol" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-1">Adınız Soyadınız</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">E-Posta Adresi</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Şifre (En az 6 karakter)</label>
                <input type="password" name="password" required minlength="6" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700 transition">
                Hesap Oluştur
            </button>
        </form>
        
        <div class="mt-4 text-center text-sm text-gray-600">
            Zaten hesabın var mı? <a href="/login" class="text-blue-600 hover:underline font-bold">Giriş Yap</a>
        </div>
        <div class="mt-2 text-center">
            <a href="/" class="text-gray-400 hover:text-gray-600 hover:underline text-sm">Vitrine Dön</a>
        </div>
    </div>
</body>
</html>