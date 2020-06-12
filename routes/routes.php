<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/blog/categories', \OZiTAG\Tager\Backend\Blog\Controllers\GuestController::class . '@categories');
    Route::get('/blog/categories/{alias}', \OZiTAG\Tager\Backend\Blog\Controllers\GuestController::class . '@viewCategory');
    Route::get('/blog/posts', \OZiTAG\Tager\Backend\Blog\Controllers\GuestController::class . '@posts');
    Route::get('/blog/posts/{alias}', \OZiTAG\Tager\Backend\Blog\Controllers\GuestController::class . '@viewPost');
    Route::get('/blog/categories/{id}/posts', \OZiTAG\Tager\Backend\Blog\Controllers\GuestController::class . '@postsByCategory');
});

Route::group(['prefix' => 'admin/blog', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/categories', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@listCategories');
    Route::post('/categories', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@createCategory');
    Route::put('/categories/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@updateCategory');
    Route::get('/categories/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@viewCategory');
    Route::delete('/categories/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@removeCategory');

    Route::get('/posts', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@listPosts');
    Route::post('/posts', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@createPost');
    Route::put('/posts/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@updatePost');
    Route::get('/posts/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@viewPost');
    Route::delete('/posts/{id}', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@removePost');

    Route::get('/categories/{id}/posts', \OZiTAG\Tager\Backend\Blog\Controllers\AdminController::class . '@listPostsByCategory');
});
