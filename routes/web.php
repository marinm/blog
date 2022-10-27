<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::redirect ('/', '/posts');

Route::resource ('posts', PostController::class);

Route::resource ('posts.comments', CommentController::class)
    ->only(['index', 'store']);
