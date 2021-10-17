<?php

use Illuminate\Support\Facades\Route;

use OZiTAG\Tager\Backend\Blog\Enums\BlogScope;
use OZiTAG\Tager\Backend\Rbac\Facades\AccessControlMiddleware;
use OZiTAG\Tager\Backend\Blog\Controllers\GuestController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminCategoriesController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminSettingsController;
use OZiTAG\Tager\Backend\Blog\Controllers\BlogAdminPostsController;

Route::group(['prefix' => 'tager/blog', 'middleware' => 'api.cache'], function () {
    Route::get('/categories', [GuestController::class, 'categories']);
    Route::get('/categories/{alias}', [GuestController::class, 'viewCategory']);
    Route::get('/posts', [GuestController::class, 'posts']);
    Route::get('/posts/by-tag', [GuestController::class, 'postsByTag']);
    Route::get('/posts/view/{alias}', [GuestController::class, 'viewPost']);
    Route::get('/categories/{id}/posts', [GuestController::class, 'postsByCategory']);
    Route::get('/posts/search', [GuestController::class, 'searchPosts']);
});

Route::group(['prefix' => 'admin/blog', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/module-info', [BlogAdminController::class, 'moduleInfo']);

    Route::group(['middleware' => [AccessControlMiddleware::scopes(BlogScope::CategoriesEdit)]], function () {
        Route::get('/categories', [BlogAdminCategoriesController::class, 'index']);
        Route::get('/categories/{id}', [BlogAdminCategoriesController::class, 'view']);
        Route::post('/categories/move/{id}/{direction}', [BlogAdminCategoriesController::class, 'move'])->where('direction', 'up|down');

        Route::post('/categories', [BlogAdminCategoriesController::class, 'store'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::CategoriesCreate)
        ]);
        Route::put('/categories/{id}', [BlogAdminCategoriesController::class, 'update'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::CategoriesEdit)
        ]);
        Route::delete('/categories/{id}', [BlogAdminCategoriesController::class, 'delete'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::CategoriesDelete)
        ]);
    });

    Route::group(['middleware' => [AccessControlMiddleware::scopes(BlogScope::PostsEdit)]], function () {
        Route::get('/posts/count', [BlogAdminPostsController::class, 'count']);
        Route::get('/posts', [BlogAdminPostsController::class, 'index']);
        Route::get('/posts/{id}', [BlogAdminPostsController::class, 'view']);

        Route::post('/posts', [BlogAdminPostsController::class, 'store'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::PostsCreate)
        ]);
        Route::post('/posts/{id}/clone', [BlogAdminPostsController::class, 'clone'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::PostsCreate)
        ]);
        Route::put('/posts/{id}', [BlogAdminPostsController::class, 'update'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::PostsEdit)
        ]);
        Route::delete('/posts/{id}', [BlogAdminPostsController::class, 'delete'])->middleware([
            AccessControlMiddleware::scopes(BlogScope::PostsDelete)
        ]);
    });
});
