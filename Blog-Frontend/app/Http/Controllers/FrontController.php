<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontController extends Controller
{
        public function registerPage()//register sayfasına yönlendirme
    {
        return view('register');
    }

    public function register(Request $request)//kullanıcı kayıt işlemi yapar
    {


        $apiUrl = 'http://apisite/api/register';
        $response = Http::post($apiUrl, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);


        if ($response->successful()) {
            return redirect()->route('login.page');
        }

        $data = $response->json(); 
        
        
        return redirect()->back()->withErrors($data['errors'])->withInput();
    }
    public function loginPage()//login sayfasına yönlendirir
    {
        return view('login');
    }

    public function login(Request $request)//giriş işlemlerini gerçekleştirir
    {


        $response = Http::post('http://apisite/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['auth_token' => $data['access_token']]);
            return redirect()->route('home');
        }

        $data = $response->json(); 
        $message = $data['message'] ?? 'Bilinmeyen hata oluştu.';
        return view('login', compact('message'));
    

    }

    public function home()//postların ve kategorilerin listelendiği anasayfa
    {
        if (!session()->has('auth_token')) {

            $message = "Anasayfaya erişmek için giriş yapmalısınız.'";
            return redirect()->route('login.page')->with('message', $message);
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        

    $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
    $categories = [];
        
    if ($categoriesResponse->successful()) {
        $categories = $categoriesResponse->json();
    }
    
    
    return view('anasayfa', compact('posts', 'categories'));
    }


    public function user_info(){ //kullanıcı bilgilerinin görüntülenip düzenlendiği sayfa
        $userResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/user');
        if ($userResponse->successful()) {
            $user = $userResponse->json();
        }

        return view('user-info',compact('user'));
    }

    public function update_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);
    
        $response = Http::withToken(session('auth_token'))->put("http://apisite/api/update-user", [
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        if ($response->successful()) {
            $user = $response->json()['user']; 
            return view('user-info', compact('user'));
        }
    
        return back()->withErrors(['update_user' => 'Kullanıcı güncelleme işlemi başarısız oldu.']);
    }
    
    

    public function home_sort()//anasayfada postları alfabetik sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products-sort');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        
        $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
        $categories = [];
            
        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }
        
        return view('anasayfa', compact('posts', 'categories'));
        }


    public function home_new()//postları en yeni olanları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products-new');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        
        $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
        $categories = [];
            
        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }
        
        return view('anasayfa', compact('posts', 'categories'));
        }

    public function home_old()// en eski postları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products-old');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        
    $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
    $categories = [];
        
    if ($categoriesResponse->successful()) {
        $categories = $categoriesResponse->json();
    }
    
    return view('anasayfa', compact('posts', 'categories'));
    }


    public function home_popular()//yorum sayısı en fazla olan postları sıralar
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get('http://apisite/api/products-popular');

        $posts = [];

        if ($response->successful()) {
            $posts = $response->json();
        }

        
        $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
        $categories = [];
            
        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }
        
        return view('anasayfa', compact('posts', 'categories'));
        
    }

    public function logout()//kullanıcı çıkış yapar ve tokeni silinir
    {
        $response = Http::withToken(session('auth_token'))->post('http://apisite/api/logout');

        if ($response->successful()) {
            session()->forget('auth_token');
            return redirect()->route('login.page')->with('message', 'Başarıyla çıkış yaptınız.');
        }

        return back()->withErrors(['logout' => 'Çıkış işlemi başarısız oldu.']);
    }






    public function show($id)//ürün detay sayfası 
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Ürünü görüntülemek için giriş yapmalısınız.');
        }
    
        $response = Http::withToken(session('auth_token'))->get("http://apisite/api/products/{$id}");
    
        if ($response->successful()) {
            $post = $response->json();
            
            if (isset($post['image'])) {
                $post['image_url'] = asset('http://localhost:6162/storage/' . $post['image']);
            }
            
            
            return view('show', compact('post'));
        }
    }
    

public function addcomment(Request $request, $id)//yorum ekleme
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $response = Http::withToken(session('auth_token'))->post("http://apisite/api/posts/{$id}", [
        'content' => $request->content,
    ]);

    return redirect()->route('show.product',compact('id'));
}





    public function category($name)//anasayfada seçilen kategoriye ait postları getirir
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }

        $response = Http::withToken(session('auth_token'))->get("http://apisite/api/categories/{$name}");

        $posts = [];
        
        if ($response->successful()) {
            $posts = $response->json();
        }



       $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
       $categories = [];
       if ($categoriesResponse->successful()) {
           $categories = $categoriesResponse->json();
       }

       return view('anasayfa', compact('posts', 'categories'));
    }



    public function homeTag(Request $request)//girilen etikete göre postları getirir
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('login.page')->with('error', 'Anasayfaya erişmek için giriş yapmalısınız.');
        }
        
        $tag = $request->input('search', ''); 
    
        $response = Http::withToken(session('auth_token'))->get("http://apisite/api/products/tag/{$tag}");
    
        $posts = [];
        if ($response->successful()) {
            $posts = $response->json();
        }
        
        $categoriesResponse = Http::withToken(session('auth_token'))->get('http://apisite/api/categories');
        $categories = [];
        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json();
        }
        return view('anasayfa', compact('posts', 'categories'));
    }



    public function showKvkk()//kvkk sayfasına yönlendirir
    {
        $response = Http::get('http://apisite/api/kvkk');  
        $kvkk = $response->json();
        
        return view('privacy-policy',compact('kvkk'));  
    }
    


}
