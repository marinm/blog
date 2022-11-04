<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Interfaces\CommentRepositoryInterface;

class CommentController extends Controller
{
    protected $comments;

    /**
     * Constructor
     *
     * @param  App\Repositories\CommentRepository $commentRepository
     */
    public function __construct(CommentRepositoryInterface $comments)
    {
        $this->comments = $comments;
    }

    /**
     * List all comments for a post.
     * (Redirect to the post's page where all comments are shown.)
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        return redirect()->route('posts.show', ['post' => $post_id]);
    }

    /**
     * Store a new comment.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, $postId)
    {
        $newDetails = $request->validated();

        $this->comments->createComment($postId, $newDetails);

        return redirect()->route('posts.show', ['post' => $postId]);
    }
}
