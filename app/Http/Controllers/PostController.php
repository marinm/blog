<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\Comment;


class PostController extends Controller
{
    public function list(Request $request) {

        $author = $request->query('author');

        // Case-insensitive string matching
        $results = $author
            ? Post::where('author_name', 'like', "%$author%")->get()
            : Post::all();

        $previews = $results
            ->sortByDesc('created_at')
            ->map(function ($post) {
                return [
                    'url' => "/posts/$post->id",
                    'title' => $post->title,
                    'posted_at' => date('M. j, Y', $post->created_at->timestamp),
                    'author_name' => $post->author_name,
                    'body_preview' => Str::limit($post->body, 130),
                ];
            });

        return view('posts.index', [
            'posts' => $previews,
            'search_term' => $author
        ]);
    }

    public function one_post_page($id) {

        $post = Post::findOrFail($id);

        $post->posted_at = date('M. j, Y', $post->created_at->timestamp);

        $comments = $post->comments->map(function ($comment) {
            return [
                'text' => $comment['text'],
                'posted_at' => date('M. j, Y', $comment->created_at->timestamp),
            ];
        });

        return view('posts.post', [
            'post' => $post,
            'comments' => $comments,
            'edit_post_page' => "/posts/$id/edit",
            'new_comment_form_action' => "/posts/$id/comments"
        ]);
    }

    public function create_form() {
        return view('posts.create', [
            'form_action' => '/posts'
        ]);
    }

    public function create(StorePostRequest $request) {

        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'body' => $validated['body']
        ]);

        $new_post_id = $post->id;

        return redirect("/posts/$new_post_id");
    }

    public function edit(StorePostRequest $request, $id) {

        $validated = $request->validated();

        $post = Post::findOrFail($id);

        $post->fill([
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'body' => $validated['body']
        ]);
        $post->save();

        return redirect("/posts/$id");
    }

    public function delete($id) {
        $post = Post::find($id);
        $post->delete();

        return view('posts.confirm-delete-success', [
            'suggest_text' => 'Back to all posts',
            'suggested_redirect_path' => '/posts'
        ]);
    }

    public function edit_post_page($id) {
        $post = Post::find($id);

        return view('posts.edit', [
            'post' => $post,
            'edit_form_action' => "/posts/$id",
            'delete_form_action' => "/posts/$id",
            'cancel_redirect' => "/posts/$id",
        ]);
    }

    public function comments($post_id) {
        return redirect("/posts/$post_id");
    }

    public function add_comment(StoreCommentRequest $request, $post_id) {

        $validated = $request->validated();

        $post = Post::find($post_id);

        $comment = new Comment();
        $comment->post()->associate($post);
        $comment->text = $validated['text'];
        $comment->save();

        // Did it work?

        return redirect("/posts/$post_id");
    }
}
