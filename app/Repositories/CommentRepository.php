<?php

namespace App\Repositories;
use App\Models\Comment;

class CommentRepository
{
    /**
     * Get a list of all comments belonging to a post.
     *
     * @param  int  $post_id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function belongingToPost($post_id)
    {
        return Comment::where('post_id', $post_id)->get();
    }

    /**
     * Get a list of all comments belonging to a post.
     *
     * @param  int  $post_id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function create($post_id, $details)
    {
        $comment = new Comment();
        $comment->post()->associate($post_id);
        $comment->text = $details['text'];
        $comment->save();

        return $comment;
    }
}
