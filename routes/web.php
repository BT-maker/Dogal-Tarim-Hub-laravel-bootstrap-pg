<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//Anasayfa
Route::get('/', [PostController::class, 'index'])->name('home');


// Post detay sayfası
Route::get('/post/{post:slug}',[PostController::class, 'show'])->name('post.show');

// Admin panel
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/posts', [PostController::class, 'admin'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');
});

// Auth routes
Route::get('/login',function () {
    return view('auth.login');
})->name('auth.login');

Route::get('/register',function(){
    return view('auth.register');
})->name('auth.register');