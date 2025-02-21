<!-- resources/views/kvkk.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVKK Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <header class="bg-gray-800 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl">KVKK Politikası</h1>
            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Anasayfa</a>

        </div>
        
    </header>

    <main class="container mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6">Kişisel Verilerin Korunması Kanunu (KVKK)</h2>

        <!-- KVKK İçeriği Burada Görüntülenecek -->
        <div id="kvkkContent" class="bg-white p-6 rounded-lg shadow-md">
        <div class="text-lg">{{ $kvkk[0]['kvkk'] }}</div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white p-4 mt-6">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Tüm Hakları Saklıdır.</p>
        </div>
    </footer>



</body>
</html>
