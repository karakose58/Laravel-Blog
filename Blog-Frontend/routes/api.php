<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Use App\Http\Controllers\AA;

Route::get('/list', [AA::class, 'list']);
Route::post('/add', [AA::class, 'store']);