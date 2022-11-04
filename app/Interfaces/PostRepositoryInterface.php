<?php

namespace App\Interfaces;

interface PostRepositoryInterface {

    public function getAllPosts() : array;

    public function getPostById(int $postId) : ?array;

    public function createPost(array $postDetails) : ?array;

    public function updatePost(int $postId, array $newDetails) : ?array;

    public function deletePost(int $postId) : bool;

    public function whereAuthorNameMatches(string $str) : array;

}
