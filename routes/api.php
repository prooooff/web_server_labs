<?php

use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\Blog\PostController;
use App\Http\Controllers\DiggingDeeperController;
use App\Http\Controllers\RestTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('rest', RestTestController::class)->names('restTest');

Route::group(['prefix' => 'blog'], function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});

$groupData = [
    'prefix' => 'admin/blog',
];

Route::group($groupData, function () {

    // Повний API-ресурс для категорій (тепер дозволені GET-запити на show та DELETE на destroy)
    Route::apiResource('categories', CategoryController::class)
        ->names('blog.admin.categories');

    Route::apiResource('posts', AdminPostController::class)
        ->names('blog.admin.posts');
});

Route::group(['prefix' => 'digging_deeper'], function () {
    Route::get('process-video', [DiggingDeeperController::class, 'processVideo'])
        ->name('digging_deeper.processVideo');

    Route::get('prepare-catalog', [DiggingDeeperController::class, 'prepareCatalog'])
        ->name('digging_deeper.prepareCatalog');
});
