<?php

use Illuminate\Support\Facades\Route;

use OZiTAG\Tager\Backend\Blog\Controllers\GuestController;
use OZiTAG\Tager\Backend\Blog\Controllers\AdminController;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/categories', [GuestController::class, 'categories']);
    Route::get('/categories/{alias}', [GuestController::class, 'viewCategory']);
    Route::get('/posts', [GuestController::class, 'posts']);
    Route::get('/posts/{alias}', [GuestController::class, 'viewPost']);
    Route::get('/categories/{id}/posts', [GuestController::class, 'postsByCategory']);
});

Route::group(['prefix' => 'admin/blog', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/module-info', [AdminController::class, 'moduleInfo']);

    Route::get('/categories', [AdminController::class, 'listCategories']);
    Route::post('/categories', [AdminController::class, 'createCategory']);
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory']);
    Route::get('/categories/{id}', [AdminController::class, 'viewCategory']);
    Route::delete('/categories/{id}', [AdminController::class, 'removeCategory']);
    Route::post('/categories/move/{id}/{direction}', [AdminController::class, 'moveCategory'])
        ->where('direction', 'up|down');

    Route::get('/categories/{id}/posts', [AdminController::class, 'listPostsByCategory']);

    Route::get('/posts', [AdminController::class, 'listPosts']);
    Route::post('/posts', [AdminController::class, 'createPost']);
    Route::put('/posts/{id}', [AdminController::class, 'updatePost']);
    Route::get('/posts/{id}', [AdminController::class, 'viewPost']);
    Route::delete('/posts/{id}', [AdminController::class, 'removePost']);
});
