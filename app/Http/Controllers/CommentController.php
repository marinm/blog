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
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        return redirect("/posts/$post_id");
    }

    /**
     * Store a new comment.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, $post_id)
    {
        $validated = $request->validated();

        $post = Post::find($post_id);

        $comment = new Comment();
        $comment->post()->associate($post);
        $comment->text = $validated['text'];
        $comment->save();

        return redirect("/posts/$post_id");
    }
}
