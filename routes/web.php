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
