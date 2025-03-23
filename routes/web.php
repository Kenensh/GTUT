<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

// 文章相關路由
Route::resource('posts', PostController::class);

// 留言相關路由
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

// 刪除留言路由
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// 認證路由，Laravel 已自動添加
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
