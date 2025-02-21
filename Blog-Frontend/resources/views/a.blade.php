<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailwind Responsive Düzeltilmiş</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<header class="bg-gray-800 text-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-center justify-between h-auto py-2">

      <!-- Arama Çubuğu -->
      <div class="w-full sm:w-auto flex-grow mb-2 sm:mb-0">
        <form method="GET" action="{{ route('homeTag') }}">
          <input type="text" placeholder="Ürün Ara..." name="search"
            class="w-full sm:w-72 px-4 py-2 rounded-md bg-gray-700 text-white focus:ring focus:ring-gray-500">
        </form>
      </div>

      <!-- Profil ve Menü -->
      <div class="flex items-center justify-center gap-2 w-full sm:w-auto">
        <a href="{{ route('user-info') }}"
          class="px-4 py-2 bg-gray-700 rounded-md text-sm hover:bg-gray-600 transition">
          Profil
        </a>
        <a href="{{ route('logout') }}"
          class="px-4 py-2 bg-gray-700 rounded-md text-sm hover:bg-gray-600 transition">
          Çıkış Yap
        </a>
        <a href="{{ route('privacy-policy') }}"
          class="px-4 py-2 bg-gray-700 rounded-md text-sm hover:bg-gray-600 transition">
          KVKK
        </a>
      </div>

    </div>
  </div>
</header>




<!-- Kategori Slider -->
<section class="bg-gray-900 text-white py-4">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-xl font-semibold mb-3">Kategoriler</h2>
    <div class="overflow-x-auto">
      <div class="flex space-x-2">
        @foreach($categories as $category)
          <a href="{{ route('category', ['name' => $category['name']]) }}"
            class="min-w-max bg-gray-700 px-3 py-2 rounded-md text-sm hover:bg-gray-600 transition">
            {{ $category['name'] }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Sıralama Butonları -->
<div class="flex flex-wrap justify-center gap-3 my-5 px-4">
  @foreach(['home-sort' => 'Alfabetik', 'home-new' => 'Yeni', 'home-old' => 'Eski', 'home-popular' => 'Popüler'] as $route => $label)
    <a href="{{ route($route) }}"
      class="px-3 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-600 transition">
      {{ $label }} Sırala
    </a>
  @endforeach
</div>

<!-- Ürünler -->
<section class="max-w-7xl mx-auto px-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach($posts as $post)
      <a href="{{ route('show.product', $post['id']) }}">
        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-lg transition">
          <div class="space-y-2">
            <h3 class="font-semibold text-gray-800 text-base truncate">{{ $post['title'] }}</h3>
            <p class="text-sm text-gray-600">{{ Str::limit($post['text'], 80) }}</p>
          </div>
        </div>
      </a>
    @endforeach
  </div>
</section>

</body>
</html>
