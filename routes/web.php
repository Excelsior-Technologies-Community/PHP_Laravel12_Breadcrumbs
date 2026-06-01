<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/search/suggestions', [PostController::class, 'getSuggestions'])->name('posts.suggestions');

Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.delete');

Route::get('/posts-trash', [PostController::class, 'trash'])->name('posts.trash');
Route::get('/posts-restore/{id}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('/posts-delete/{id}', [PostController::class, 'forceDelete'])->name('posts.forceDelete');