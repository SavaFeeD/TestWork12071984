<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::prefix('users')->group(function () {
  Route::get('index', [UserController::class, 'index'])->middleware('auth:api');
  Route::post('login', [UserController::class, 'login']);
  Route::post('create', [UserController::class, 'store']);
  Route::get('logout', [UserController::class, 'logout'])->middleware('auth:api');
  Route::post('update/{id}', [UserController::class, 'update_user'])->middleware('auth:api');
  Route::get('delete/{id}', [UserController::class, 'delete'])->middleware('auth:api');
  Route::get('{id}', [UserController::class, 'show']);
});

Route::prefix('posts')->group(function () {
  Route::get('index', [PostController::class, 'index'])->middleware('auth:api');
  Route::post('create', [PostController::class, 'store'])->middleware('auth:api');
  Route::post('update/{id}', [PostController::class, 'update_post'])->middleware('auth:api');
  Route::get('delete/{id}', [PostController::class, 'delete'])->middleware('auth:api');
  Route::get('{id}', [PostController::class, 'show']);
});

Route::prefix('comments')->group(function () {
  Route::get('index', [CommentController::class, 'index'])->middleware('auth:api');
  Route::post('create', [CommentController::class, 'store'])->middleware('auth:api');
  Route::post('update/{id}', [CommentController::class, 'update_comment'])->middleware('auth:api');
  Route::get('delete/{id}', [CommentController::class, 'delete'])->middleware('auth:api');
  Route::get('{id}', [CommentController::class, 'show']);
});
