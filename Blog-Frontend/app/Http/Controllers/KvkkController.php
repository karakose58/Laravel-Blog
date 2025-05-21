<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class KvkkController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.backend.url');
    }

    public function showKvkk() //kvkk sayfasına yönlendirir
    {
        $response = Http::get($this->apiUrl . 'kvkk');
        $kvkk = $response->json();

        return view('privacy-policy',compact('kvkk'));
    }
}
