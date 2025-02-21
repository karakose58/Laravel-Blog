<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog - {{ $post['title'] }} | Yorumlar, detaylar">
    <title>{{ $post['title'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-gray-800 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <h1 class="text-xl font-bold">Blog</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('user-info') }}" class="text-gray-300 hover:text-white">Profil</a>
                <a href="{{ route('logout') }}" class="text-gray-300 hover:text-white">Çıkış Yap</a>
            </div>
        </div>
    </div>
</header>

<!-- Ürün Detay -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-semibold">{{ $post['title'] }}</h2>
    <p class="text-gray-600 mt-2">{{ $post['text'] }}</p>

    @if(isset($post['image_url']))
    <div class="mt-4">
        <img src="{{ $post['image_url'] }}" alt="{{ $post['title'] }}" class="w-full max-w-full h-auto rounded-lg shadow-lg">
    </div>
@endif


    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600 transition duration-300">Anasayfaya Dön</a>
    </div>
</div>

<!-- Yorumlar -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h3 class="text-xl font-semibold mb-4">Yorumlar</h3>

    @if(count($post['comments']) > 0)
        @foreach($post['comments'] as $comment)
            <div class="border-b border-gray-200 py-4">
                <p><strong class="text-lg">{{ $comment['author'] }}</strong>: {{ $comment['content'] }}</p>
            </div>
        @endforeach
    @else
        <p class="text-gray-500">Henüz yorum yok.</p>
    @endif
</div>

<!-- Yorum Ekleme Formu -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h3 class="text-xl font-semibold mb-4">Yorum Yap</h3>
    <form method="POST" action="{{ route('comment.add', $post['id']) }}">
        @csrf

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium">Yorumunuz</label>
            <textarea id="content" name="content" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300" required></textarea>
        </div>
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-400 transition duration-300">Yorumu Gönder</button>
    </form>
</div>

</body>
</html>
