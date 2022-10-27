<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * List all comments for a post.
     * (Redirect to the post's page where all comments are shown.)
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function index($post)
    {
        return redirect("/posts/$post->id");
    }

    /**
     * Store a new comment.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();

        $comment = new Comment();
        $comment->post()->associate($post);
        $comment->text = $validated['text'];
        $comment->save();

        return redirect("/posts/$post->id");
    }
}
