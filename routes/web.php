<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::redirect ('/',                    '/posts');
Route::get      ('/posts',               [PostController::class, 'index']);
Route::get      ('/posts/create',        [PostController::class, 'create']);
Route::post     ('/posts',               [PostController::class, 'store']);
Route::get      ('/posts/{id}',          [PostController::class, 'show']);
Route::get      ('/posts/{id}/edit',     [PostController::class, 'edit']);
Route::put      ('/posts/{id}',          [PostController::class, 'update']);
Route::delete   ('/posts/{id}',          [PostController::class, 'delete']);
Route::get      ('/posts/{id}/comments', [PostController::class, 'comments_index']);
Route::post     ('/posts/{id}/comments', [PostController::class, 'comments_store']);
