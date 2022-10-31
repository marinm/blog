<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository
{
    /**
     * Get all posts.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Post::all();
    }

    /**
     * Get a post by id.
     *
     * @param  int  $id
     * @return App\Models\Post
     */
    public function find($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Create a new post.
     *
     * @param  array $details
     * @return App\Models\Post
     */
    public function create($details)
    {
        return Post::create($details);
    }

    /**
     * Update a post with the given details.
     *
     * @param  int $id
     * @param  array  $details
     * @return App\Models\Post
     */
    public function update($id, $details)
    {
        $post = Post::findOrFail($id);

        $post->fill([
            'title' => $details['title'],
            'author_name' => $details['author_name'],
            'body' => $details['body']
        ]);
        $post->save();

        return $post;
    }

    /**
     * Delete a post by id.
     *
     * @param  int $id
     * @return void
     */
    public function delete($id)
    {
        Post::destroy($id);
    }

    /**
     * Get all posts where the author name contains the given substring.
     * (Case-sensitive string matching)
     *
     * @param string $str
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function whereAuthorNameMatches($str)
    {
        return Post::where('author_name', 'like', "%$str%")->get();
    }
}
