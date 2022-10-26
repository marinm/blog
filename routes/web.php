<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// POST
// GET
// PUT
// DELETE

#                       GET    POST   PUT    DELETE
# /posts                +
# /posts/:id            +             +      +
# /posts/:id/comments   +      +


Route::redirect('/', '/posts');
Route::get    ('/posts', [PostController::class, 'list']);
Route::get    ('/posts/create', [PostController::class, 'create_form']);
Route::post   ('/posts', [PostController::class, 'create']);
Route::get    ('/posts/{id}', [PostController::class, 'one_post_page']);
Route::get    ('/posts/{id}/edit', [PostController::class, 'edit_post_page']);
Route::put    ('/posts/{id}', [PostController::class, 'edit']);
Route::delete ('/posts/{id}', [PostController::class, 'delete']);
Route::get    ('/posts/{id}/comments', [PostController::class, 'comments']);
Route::post   ('/posts/{id}/comments', [PostController::class, 'add_comment']);
