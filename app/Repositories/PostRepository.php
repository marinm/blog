<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Don't expose the ORM Model instance. Return only a dict of data.
     * Also add some fields.
     *
     * @param  App\Models\Post  $post
     * @return array
     */
    public function as_dict(Post $post) : array
    {
        $image_path = $post->image_path
            ? Storage::url($post->image_path)
            : null;

        return [
            'id'             => $post->id,
            'title'          => $post->title,
            'author_name'    => $post->author_name,
            'body'           => $post->body,
            'image_path'     => $post->image_path,
            'image_url_path' => $image_path,
            'created_at'     => (int) $post->created_at->timestamp,
            'updated_at'     => (int) $post->updated_at->timestamp,
        ];
    }

    /**
     * Get all posts. Newest first.
     *
     * @return array
     */
    public function getAllPosts(): array
    {
        return Post::all()
            ->sortByDesc('created_at')
            ->map([$this, 'as_dict'])
            ->toArray();
    }

    /**
     * Get a post by id.
     *
     * @param  int  $id
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return array
     */
    public function getPostById(int $postId): ?array
    {
        return $this->as_dict( Post::findOrFail($postId) );
    }

    /**
     * Create a new post.
     *
     * @param  array $details
     * @return array
     */
    public function createPost(array $postDetails): ?array
    {
        $image_file = $postDetails['image'];
        $image_path = null;
        if ($image_file) {
            $image_path = $image_file->store('posts/images', 'public');
        }

        $post = Post::create([
            'title'       => $postDetails['title'],
            'author_name' => $postDetails['author_name'],
            'image_path'  => $image_path,
            'body'        => $postDetails['body']
        ]);

        return $this->as_dict($post);
    }

    /**
     * Update a post with the given details.
     *
     * @param  int $id
     * @param  array  $details
     * @return array
     */
    public function updatePost(int $postId, array $newDetails): ?array
    {
        $post = Post::findOrFail($postId);

        $image_file = $details['image'] ?? null;
        $image_path = null;
        if ($image_file) {
            $image_path = $image_file->store('posts/images', 'public');
        }

        $post->fill([
            'title'       => $newDetails['title'],
            'author_name' => $newDetails['author_name'],
            'image_path'  => $image_path,
            'body'        => $newDetails['body']
        ]);
        $post->save();

        return $this->as_dict($post);
    }

    /**
     * Delete a post by id.
     *
     * @param  int $id
     * @return bool
     */
    public function deletePost(int $postId): bool
    {
        Post::destroy($postId);
        return true;
    }

    /**
     * Get all posts where the author name contains the given substring.
     * (Case-sensitive string matching)
     *
     * @param string $str
     * @return array
     */
    public function whereAuthorNameMatches(string $str) : array
    {
        return Post::where('author_name', 'like', "%$str%")
            ->get()
            ->map([$this, 'as_dict'])
            ->toArray();
    }
}
