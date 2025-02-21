<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body  >

@if (!empty($message))
        <div class="bg-red-600 text-white px-4 py-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    @if (session('message'))
        <div class="bg-red-600 text-white px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

<div class="bg-cover bg-center min-h-screen flex justify-center items-center">

    <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Giriş Yap</h1>
        <form action="{{ route('login') }}" method="post" class="space-y-4">
            @csrf
            <div class="text-center">
                <input type="email" name="email" placeholder="E-posta adresiniz"
                    class="w-full px-4 py-2 rounded-full border-2 border-black bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>

            <div class="text-center">
                <input type="password" name="password" placeholder="Şifreniz"
                    class="w-full px-4 py-2 rounded-full border-2 border-black bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>

            <div class="w-full text-right">
                <input type="submit" value="Gönder"
                    class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 cursor-pointer transition" />
            </div>
        </form>
    </div>
</div>
</body>
</html>
