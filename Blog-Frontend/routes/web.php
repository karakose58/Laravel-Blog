<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KvkkController;
use App\Http\Controllers\PostController;

Route::get('/register', [AuthController::class, 'registerPage'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/home', [PostController::class, 'home'])->name('home');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/add', [PostController::class, 'add'])->name('add.product');
Route::post('/add', [PostController::class, 'store'])->name('store.product');

Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit.product');
Route::put('/update/{id}', [PostController::class, 'update'])->name('update.product');

Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('delete.product');
Route::get('/show/{id}', [PostController::class, 'show'])->name('show.product');

Route::get('/comment/{id}', [PostController::class, 'comment'])->name('comment');
Route::post('/comment/add/{id}', [PostController::class, 'addcomment'])->name('comment.add');

Route::get('/home-alphabetic', [PostController::class, 'home_sort'])->name('home-sort');
Route::get('/home-new', [PostController::class, 'home_new'])->name('home-new');
Route::get('/home-old', [PostController::class, 'home_old'])->name('home-old');
Route::get('/home-popular', [PostController::class, 'home_popular'])->name('home-popular');

Route::get('/user-info', [AuthController::class, 'user_info'])->name('user-info');
Route::put('/update-user', [AuthController::class, 'update_user'])->name('update.user');

Route::get('/home-category/{name}', [CategoryController::class, 'category'])->name('category');

Route::get('/home-tag', [PostController::class, 'homeTag'])->name('homeTag');



Route::get('/privacy-policy', [KvkkController::class, 'showKvkk'])->name('privacy-policy');
