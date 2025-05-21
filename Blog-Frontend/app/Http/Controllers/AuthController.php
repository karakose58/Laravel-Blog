<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.backend.url');
    }

    public function registerPage() //register sayfasına yönlendirme
    {
        return view('register');
    }

public function register(Request $request)
{
    $response = Http::withHeaders(['Accept' => 'application/json' ])
    ->post($this->apiUrl . 'register', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
    ]);
    $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('login.page');
        }

        $data = $response->json(); 
        
        
        return redirect()->back()->withErrors($data['errors'])->withInput();
}


    public function loginPage() //login sayfasına yönlendirir
    {
        return view('login');
    }

    public function login(Request $request) //giriş işlemlerini gerçekleştirir
    {
        $response = Http::withHeaders(['Accept' => 'application/json' ])
        ->post($this->apiUrl . 'login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $responseData = $response->json();

        if ($response->successful()) {
            session(['auth_token' => $responseData['access_token']]);
            return redirect()->route('home');
        }

        $message = $responseData;
        //dd($message);
        return redirect()->back()->withErrors($message['errors'])->withInput();

    }

    public function user_info() { //kullanıcı bilgilerinin görüntülenip düzenlendiği sayfa
        $userResponse = Http::withToken(session('auth_token'))->get($this->apiUrl . 'user');
        if ($userResponse->successful()) {
        $user = $userResponse->json()['data']; 
        }

        return view('user-info',compact('user'));
    }

    public function update_user(Request $request)
    {
        $response = Http::withToken(session('auth_token'))->put($this->apiUrl . "update-user", [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            $user = $response->json()['user']; 
            return view('user-info', compact('user'));
        }

        return back()->withErrors(['update_user' => 'Kullanıcı güncelleme işlemi başarısız oldu.']);
    }

    public function logout() //kullanıcı çıkış yapar ve tokeni silinir
    {
        $response = Http::withToken(session('auth_token'))->post($this->apiUrl . 'logout');

        if ($response->successful()) {
            session()->forget('auth_token');
            return redirect()->route('login.page')->with('message', 'Başarıyla çıkış yaptınız.');
        }

        return back()->withErrors(['logout' => 'Çıkış işlemi başarısız oldu.']);
    }
}
