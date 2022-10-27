<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    const BODY_PREVIEW_CHAR_LIMIT = 130;
    const DATE_FORMAT = 'M. j, Y';

    /**
     * List all posts.
     *
     * If an 'author' query parameter is given, list only posts where the
     * author name contains that exact substring.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $author = $request->query('author');

        // Case-sensitive string matching
        $results = $author
            ? Post::where('author_name', 'like', "%$author%")->get()
            : Post::all();

        // Newest posts first
        $previews = $results
            ->sortByDesc('created_at')
            ->map(function ($post) {
                return [
                    'url' => "/posts/$post->id",
                    'title' => $post->title,
                    'posted_at' => date(self::DATE_FORMAT, $post->created_at->timestamp),
                    'author_name' => $post->author_name,
                    'body_preview' => Str::limit($post->body, self::BODY_PREVIEW_CHAR_LIMIT),
                ];
            });

        return view('posts.index', [
            'posts' => $previews,
            'search_term' => $author
        ]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'form_action' => '/posts'
        ]);
    }

    /**
     * Store a new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'body' => $validated['body']
        ]);

        $new_post_id = $post->id;

        return redirect("/posts/$new_post_id");
    }

    /**
     * Show an entire post and an 'edit' link.
     * Also show all comments on that post, with an 'Add comment' form.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->posted_at = date(self::DATE_FORMAT, $post->created_at->timestamp);

        $comments = $post->comments->map(function ($comment) {
            return [
                'text' => $comment['text'],
                'posted_at' => date(self::DATE_FORMAT, $comment->created_at->timestamp),
            ];
        });

        return view('posts.post', [
            'post' => $post,
            'comments' => $comments,
            'edit_post_page' => "/posts/$post->id/edit",
            'new_comment_form_action' => "/posts/$post->id/comments"
        ]);
    }

    /**
     * Show the form for editing the post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'edit_form_action' => "/posts/$post->id",
            'delete_form_action' => "/posts/$post->id",
            'cancel_redirect' => "/posts/$post->id",
        ]);
    }

    /**
     * Update/edit a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Post $post)
    {
        // Since all fields are editable, use the same request format as 'create'.

        $validated = $request->validated();

        $post->fill([
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'body' => $validated['body']
        ]);
        $post->save();

        return redirect("/posts/$post->id");
    }

    /**
     * Delete a post and all of its comments.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return view('posts.confirm-delete-success', [
            'suggest_text' => 'Back to all posts',
            'suggested_redirect_path' => '/posts'
        ]);
    }
}
