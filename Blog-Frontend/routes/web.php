<?php

use App\Http\Controllers\FrontController;

Route::get('/register', [FrontController::class, 'registerPage'])->name('register.page');
Route::post('/register', [FrontController::class, 'register'])->name('register');

Route::get('/login', [FrontController::class, 'loginPage'])->name('login.page');
Route::post('/login', [FrontController::class, 'login'])->name('login');

Route::get('/home', [FrontController::class, 'home'])->name('home');

Route::get('/logout', [FrontController::class, 'logout'])->name('logout');

Route::get('/add', [FrontController::class, 'add'])->name('add.product');
Route::post('/add', [FrontController::class, 'store'])->name('store.product');

Route::get('/edit/{id}', [FrontController::class, 'edit'])->name('edit.product');
Route::put('/update/{id}', [FrontController::class, 'update'])->name('update.product');

Route::delete('/delete/{id}', [FrontController::class, 'delete'])->name('delete.product');
Route::get('/show/{id}', [FrontController::class, 'show'])->name('show.product');

Route::get('/comment/{id}', [FrontController::class, 'comment'])->name('comment');
Route::post('/comment/add/{id}', [FrontController::class, 'addcomment'])->name('comment.add');

Route::get('/home-alphabetic', [FrontController::class, 'home_sort'])->name('home-sort');
Route::get('/home-new', [FrontController::class, 'home_new'])->name('home-new');
Route::get('/home-old', [FrontController::class, 'home_old'])->name('home-old');
Route::get('/home-popular', [FrontController::class, 'home_popular'])->name('home-popular');

Route::get('/user-info', [FrontController::class, 'user_info'])->name('user-info');
Route::put('/update-user', [FrontController::class, 'update_user'])->name('update.user');

Route::get('/home-category/{name}', [FrontController::class, 'category'])->name('category');

Route::get('/home-tag', [FrontController::class, 'homeTag'])->name('homeTag');



Route::get('/privacy-policy', [FrontController::class, 'showKvkk'])->name('privacy-policy');
