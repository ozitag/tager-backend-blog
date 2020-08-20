<?php

use Illuminate\Support\Facades\Route;

use OZiTAG\Tager\Backend\Blog\Controllers\GuestController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminCategoriesController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminSettingsController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminPostsController;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/categories', [GuestController::class, 'categories']);
    Route::get('/categories/{alias}', [GuestController::class, 'viewCategory']);
    Route::get('/posts', [GuestController::class, 'posts']);
    Route::get('/posts/by-tag', [GuestController::class, 'postsByTag']);
    Route::get('/posts/view/{alias}', [GuestController::class, 'viewPost']);
    Route::get('/categories/{id}/posts', [GuestController::class, 'postsByCategory']);
});

Route::group(['prefix' => 'admin/blog', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/module-info', [BlogAdminController::class, 'moduleInfo']);

    Route::get('/categories', [BlogAdminCategoriesController::class, 'index']);
    Route::post('/categories', [BlogAdminCategoriesController::class, 'store']);
    Route::put('/categories/{id}', [BlogAdminCategoriesController::class, 'update']);
    Route::get('/categories/{id}', [BlogAdminCategoriesController::class, 'view']);
    Route::delete('/categories/{id}', [BlogAdminCategoriesController::class, 'delete']);
    Route::post('/categories/move/{id}/{direction}', [BlogAdminCategoriesController::class, 'move'])->where('direction', 'up|down');
    Route::get('/categories/{id}/posts', [BlogAdminCategoriesController::class, 'listPostsByCategory']);

    Route::get('/posts', [BlogAdminPostsController::class, 'index']);
    Route::post('/posts', [BlogAdminPostsController::class, 'store']);
    Route::put('/posts/{id}', [BlogAdminPostsController::class, 'update']);
    Route::get('/posts/{id}', [BlogAdminPostsController::class, 'view']);
    Route::delete('/posts/{id}', [BlogAdminPostsController::class, 'delete']);
    Route::get('/posts/count', [BlogAdminPostsController::class, 'count']);

    Route::get('/settings', [BlogAdminSettingsController::class, 'index']);
    Route::post('/settings', [BlogAdminSettingsController::class, 'save']);
});
