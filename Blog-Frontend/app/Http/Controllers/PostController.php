<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.backend.url');
    }

    public function home() //postların ve kategorilerin listelendiği anasayfa
    {
        if (!session()->has('auth_token')) {
            $message = "Anasayfaya erişmek için giriş yapmalısınız.'";
            return redirect()->route('login.page')->with('message', $message);
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . 'products');

        $posts = [];

        if ($response->successful()) {
        $posts = $response->json()['data']; 
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];
        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }
    //    dd($categories,$posts);

        return view('anasayfa', compact('posts', 'categories'));
    }

    public function home_sort() //anasayfada postları alfabetik sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . 'products-sort');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json()['data']; 
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }

        return view('anasayfa', compact('posts', 'categories'));
    }

    public function home_new() //postları en yeni olanları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . 'products-new');

        $posts = [];

        if ($response->successful()) {
           $posts = $response->json()['data']; 
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }

        return view('anasayfa', compact('posts', 'categories'));
    }

    public function home_old() // en eski postları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . 'products-old');

        $posts = [];

        if ($response->successful()) {
          $posts = $response->json()['data']; 
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }

        return view('anasayfa', compact('posts', 'categories'));
    }

    public function home_popular() //yorum sayısı en fazla olan postları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . 'products-popular');

        $posts = [];

        if ($response->successful()) {
          $posts = $response->json()['data']; 
        }

        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }

        return view('anasayfa', compact('posts', 'categories'));
    }

    public function show($id) //ürün detay sayfası 
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Ürünü görüntülemek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . "products/{$id}");

        if ($response->successful()) {
        $post = $response->json()['data']; 

            if (isset($post['image'])) {
                $post['image_url'] = asset('http://localhost:6162/storage/' . $post['image']);
            }

            return view('show', compact('post'));
        }
    }

    public function addcomment(Request $request, $id) //yorum ekleme
    {
        Http::withToken(session('auth_token'))->post($this->apiUrl . "posts/{$id}", [
            'content' => $request->content,
        ]);

        return redirect()->route('show.product', compact('id'));
    }

    public function homeTag(Request $request) //girilen etikete göre postları getirir
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $tag = $request->input('search', '');

        $response = Http::withToken(session('auth_token'))->get($this->apiUrl . "products/tag/{$tag}");

        $posts = [];

        if ($response->successful()) {
        $posts = $response->json()['data']; 
        }


        $categoriesResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'categories');
        $categories = [];

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }


        return view('anasayfa', compact('posts', 'categories'));
    }
}
