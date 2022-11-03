<?php

namespace App\Repositories;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostRepository
{
    /**
     * Don't expose the ORM Model instance. Return only a dict of data.
     * Also add some fields.
     *
     * @param  App\Models\Post  $post
     * @return array
     */
    public function as_dict($post)
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
            'created_at'     => $post->created_at,
            'updated_at'     => $post->updated_at,
        ];
    }

    /**
     * Get all posts.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Post::all()->map([$this, 'as_dict']);
    }

    /**
     * Get a post by id.
     *
     * @param  int  $id
     * @return App\Models\Post
     */
    public function find($id)
    {
        return $this->as_dict( Post::findOrFail($id) );
    }

    /**
     * Create a new post.
     *
     * @param  array $details
     * @return App\Models\Post
     */
    public function create($details)
    {
        $image_file = $details['image'];
        $image_path = null;
        if ($image_file) {
            $image_path = $image_file->store('posts/images', 'public');
        }

        $post = Post::create([
            'title'       => $details['title'],
            'author_name' => $details['author_name'],
            'image_path'  => $image_path,
            'body'        => $details['body']
        ]);

        return $this->as_dict($post);
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

        $image_file = $details['image'] ?? null;
        $image_path = null;
        if ($image_file) {
            $image_path = $image_file->store('posts/images', 'public');
        }

        $post->fill([
            'title'       => $details['title'],
            'author_name' => $details['author_name'],
            'image_path'  => $image_path,
            'body'        => $details['body']
        ]);
        $post->save();

        return $this->as_dict($post);
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
