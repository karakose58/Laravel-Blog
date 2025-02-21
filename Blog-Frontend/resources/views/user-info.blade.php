<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kullanıcı Bilgileri</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-gray-800 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo / Başlık -->
        <div class="flex-shrink-0">
          <h1 class="text-xl font-bold">Blog</h1>
        </div>
        <!-- Navigasyon Menüsü (Opsiyonel) -->
        <nav class="hidden md:flex space-x-4">
          <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Anasayfa</a>
        </nav>
      </div>
    </div>
  </header>

  <!-- Ana İçerik -->
  <main class="max-w-3xl mx-auto py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-semibold mb-4">Kullanıcı Bilgileri</h2>
      <form class="space-y-6" action="{{ route('update.user') }}" method="POST">
        @csrf
        @method('PUT')

        <div>
          <label for="name" class="block text-gray-700 font-medium">Adınız Soyadınız</label>
          <input id="name" type="text" name="name" value="{{ $user['name'] ?? '' }}" placeholder="Adınız Soyadınız" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div>
          <label for="email" class="block text-gray-700 font-medium">E-posta Adresiniz</label>
          <input id="email" type="email" name="email" value="{{ $user['email'] ?? '' }}" placeholder="E-posta adresiniz" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div>
          <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-md transition duration-300">
            Güncelle
          </button>
        </div>
      </form>
    </div>
  </main>


</body>
</html>
