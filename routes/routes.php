<?php

use Illuminate\Support\Facades\Route;

use OZiTAG\Tager\Backend\Blog\Controllers\GuestController;
use OZiTAG\Tager\Backend\Blog\Controllers\AdminController;
use OZiTAG\Tager\Backend\Blog\Controllers\AdminCategoriesController;
use OZiTAG\Tager\Backend\Blog\Controllers\AdminPostsController;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/categories', [GuestController::class, 'categories']);
    Route::get('/categories/{alias}', [GuestController::class, 'viewCategory']);
    Route::get('/posts', [GuestController::class, 'posts']);
    Route::get('/posts/{alias}', [GuestController::class, 'viewPost']);
    Route::get('/categories/{id}/posts', [GuestController::class, 'postsByCategory']);
});

Route::group(['prefix' => 'admin/blog', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/module-info', [AdminController::class, 'moduleInfo']);

    Route::get('/categories', [AdminCategoriesController::class, 'index']);
    Route::post('/categories', [AdminCategoriesController::class, 'store']);
    Route::put('/categories/{id}', [AdminCategoriesController::class, 'update']);
    Route::get('/categories/{id}', [AdminCategoriesController::class, 'view']);
    Route::delete('/categories/{id}', [AdminCategoriesController::class, 'delete']);
    Route::post('/categories/move/{id}/{direction}', [AdminCategoriesController::class, 'move'])->where('direction', 'up|down');
    Route::get('/categories/{id}/posts', [AdminCategoriesController::class, 'listPostsByCategory']);

    Route::get('/posts', [AdminPostsController::class, 'index']);
    Route::post('/posts', [AdminPostsController::class, 'store']);
    Route::put('/posts/{id}', [AdminPostsController::class, 'update']);
    Route::get('/posts/{id}', [AdminPostsController::class, 'view']);
    Route::delete('/posts/{id}', [AdminPostsController::class, 'delete']);
});
