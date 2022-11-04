<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @param App\Models\Comment  $comment
     * @return array
     */
    public function as_dict(Comment $comment) : array
    {
        return [
            'text'       => $comment->text,
            'created_at' => (int) $comment->created_at->timestamp,
        ];
    }

    /**
     * Get all comments belonging to a post.
     *
     * @param  int  $post_id
     * @return array
     */
    public function getAllCommentsByPostId(int $postId): ?array
    {
        return Comment::where('post_id', $postId)
            ->get()
            ->map([$this, 'as_dict'])
            ->toArray();
    }

    /**
     * Get a list of all comments belonging to a post.
     *
     * @param  int  $post_id
     * @return array
     */
    public function createComment(int $postId, array $commentDetails): ?array
    {
        $comment = new Comment();
        $comment->post()->associate($postId);
        $comment->text = $commentDetails['text'];
        $comment->save();

        return $this->as_dict($comment);
    }
}
