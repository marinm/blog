<?php

namespace App\Interfaces;

interface CommentRepositoryInterface {

    public function getAllCommentsByPostId(int $postId) : ?array;

    public function createComment(int $postId, array $commentDetails) : ?array;

}
