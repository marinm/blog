<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    const BODY_PREVIEW_CHAR_LIMIT = 130;
    const DATE_FORMAT = 'M. j, Y';

    private PostRepository $postRepository;
    private CommentRepository $commentRepository;

    /**
     * Sanitizer: StorePostRequest author_name
     *
     * @param  string  $input
     * @param  App\Repositories\PostRepository $postRepository
     */
    private function sanitizeAuthorName($input) {
        // Assumes the input has already been validated
        $sanitized = trim($input);
        $sanitized = ucfirst($sanitized);
        return $sanitized;
    }

    /**
     * Constructor
     *
     * @param  App\Repositories\PostRepository $postRepository
     */
    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

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
            ? $this->postRepository->whereAuthorNameMatches($author)
            : $this->postRepository->all();

        // Newest posts first
        $previews = $results
            ->sortByDesc('created_at')
            ->map(function ($post) {
                $id = $post['id'];
                return [
                    'url'            => route('posts.show', ['post' => $id]),
                    'title'          => $post['title'],
                    'image_url_path' => $post['image_url_path'],
                    'posted_at'      => date(self::DATE_FORMAT, $post['created_at']->timestamp),
                    'author_name'    => $post['author_name'],
                    'body_preview'   => Str::limit($post['body'], self::BODY_PREVIEW_CHAR_LIMIT),
                ];
            });

        return view('posts.index', [
            'session'      => $request->session()->all(),
            'posts'        => $previews,
            'search_term'  => $author
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
            'form_action' => route('posts.store')
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

        $post = $this->postRepository->create([
            'title'       => $validated['title'],
            'author_name' => $this->sanitizeAuthorName($validated['author_name']),
            'image'       => $validated['image'] ?? null,
            'body'        => $validated['body']
        ]);

        $request->session()->flash('confirm_created', true);

        $id = $post['id'];

        return redirect()->route('posts.show', ['post' => $id]);
    }

    /**
     * Show an entire post and an 'edit' link.
     * Also show all comments on that post, with an 'Add comment' form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $post = $this->postRepository->find($id);

        $comments = $this->commentRepository
            ->belongingToPost($id)
            ->map(function ($comment) {
                return [
                    'text'      => $comment['text'],
                    'posted_at' => date(self::DATE_FORMAT, $comment->created_at->timestamp),
                ];
            });

        $post_details = $post;
        $post_details['comments'] = $comments;
        $post_details['posted_at'] = date(self::DATE_FORMAT, $post['created_at']->timestamp);

        return view('posts.show', [
            'session'                 => $request->session()->all(),
            'post'                    => $post_details,
            'comments'                => $comments,
            'edit_post_page'          => route('posts.edit', ['post' => $id]),
            'new_comment_form_action' => route('posts.comments.store', ['post' => $id])
        ]);
    }

    /**
     * Show the form for editing the post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->find($id);

        return view('posts.edit', [
            'post'               => $post,
            'edit_form_action'   => route('posts.update', ['post' => $id]),
            'delete_form_action' => route('posts.destroy', ['post' => $id]),
            'cancel_redirect'    => route('posts.show', ['post' => $id])
        ]);
    }

    /**
     * Update/edit a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id)
    {
        $post = $this->postRepository->find($id);

        // Since all fields are editable, use the same request format as 'create'.
        $validated = $request->validated();
        $this->postRepository->update($post['id'], $validated);
        $request->session()->flash('confirm_edited', true);

        return redirect()->route('posts.show', ['post' => $id]);
    }

    /**
     * Delete a post and all of its comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->postRepository->delete($id);

        // TODO:
        // Catch errors

        $request->session()->flash('confirm_deleted', true);

        return redirect()->route('posts.index');
    }
}
