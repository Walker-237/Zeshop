<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PostController::class, 'index'])->middleware('auth');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/signup', function () {
    return view('register');
});

Route::post('/signup', [AuthController::class, 'store'])->name('register');

Route::get('/auth/forgot-password', function () {
    return view('forgot-password');
});

Route::get('/users', [UserController::class, 'index']);

Route::post('/upload', [PostController::class, 'store'])->name('upload')->middleware('auth');

Route::post('/comment', [CommentController::class, 'store'])->name('comment')->middleware('auth');

Route::post('/like', [LikeController::class, 'store'])->name('like')->middleware('auth');