<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Repositories\CommentRepository;
use App\Models\Comment;

class CommentController extends Controller
{
    protected $commentRepository;

    /**
     * Constructor
     *
     * @param  App\Repositories\CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
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
        return redirect("/posts/$post_id");
    }

    /**
     * Store a new comment.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, $post_id)
    {
        $validated = $request->validated();

        $this->commentRepository->create($post_id, $validated);

        return redirect("/posts/$post_id");
    }
}
