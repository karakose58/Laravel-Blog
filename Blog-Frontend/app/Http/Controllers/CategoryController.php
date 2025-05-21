<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.backend.url');
    }

    public function category($name) //anasayfada seçilen kategoriye ait postları getirir
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . "categories/{$name}");

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }

        return view('anasayfa', compact('posts', 'categories'));
    }
}
