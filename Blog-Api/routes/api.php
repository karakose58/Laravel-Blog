<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\KvkkController;
use App\Http\Controllers\CategoryController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;




Route::post('/login', [AuthController::class, 'login']); 
Route::post('/register', [AuthController::class, 'register']); 




Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); 
    Route::post('/posts/{id}', [Postcontroller::class, 'addcomment']); 
    Route::get('/user', [AuthController::class, 'userinfo']);
    Route::put('/update-user', [AuthController::class, 'update_user']);
    
    Route::get('/products/tag/{tag}', [PostController::class, 'getTags']);
    Route::get('/products', [PostController::class, 'listProducts']);
    Route::get('/products/{id}', [PostController::class, 'getProduct']);
    Route::get('/categories/{id}', [CategoryController::class, 'Category']);
    Route::get('/categories', [CategoryController::class, 'ListCategory']);

    Route::get('/products-sort', [PostController::class, 'alphabetic']);
    Route::get('/products-new', [PostController::class, 'new']);
    Route::get('/products-old', [PostController::class, 'old']);
    Route::get('/products-popular', [PostController::class, 'popular']);    


});

Route::get('/kvkk', [KvkkController::class, 'kvkk']);







