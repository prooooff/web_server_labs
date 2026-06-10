<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiggingDeeperController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


/*
Route::group(['prefix' => 'blog'], function () {
    Route::apiResource('posts', \App\Http\Controllers\Api\Blog\PostController::class)->names('blog.posts');
});
*/

// Маршрут для тестування колекцій (DiggingDeeper)
Route::group(['prefix' => 'digging_deeper'], function () {
    Route::get('collections', [DiggingDeeperController::class, 'collections'])
        ->name('digging_deeper.collections');
});
