<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kvkk;

class KvkkController extends Controller
{
    public function kvkk() //kvkk metnini çağırma
    {
        $kvkk = Kvkk::all();
        return response()->json($kvkk);
    }}
