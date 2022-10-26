@extends('layouts.app')

@section('body')

<div id="content-container">

    <form method="GET">
        <input
            type="text"
            class="pill"
            name="author"
            placeholder="Search by author">
        <input type="submit" class="hidden">
    </form>

    @if ($search_term != '')
    <div class="mt-2 mb-1">Showing {{ count($posts) }} search result(s) for: <em>{{ $search_term }}</em></div>
    <div class="mt-1 mb-1"><a href="?" class="blue">Back to all posts</a></div>
    @endif

    <ul class="blog-post-previews-list">
    @foreach ($posts as $post)
    <li>
        <div class="title">{{ $post['title'] }}</div>
        <div class="datetime blank-line-top blank-line-bottom">{{ $post['posted_at'] }} | {{ $post['author_name'] }}</div>
        <div class="post-text">{{ $post['body_preview'] }}</div>
        <div class="flex-right"><a href="{{ $post['url'] }}" class="blue">Read more</a></div>
    </li>
    @endforeach
    </ul>

</div>

@endsection
