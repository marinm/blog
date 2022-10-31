@extends('layouts.app')

@section('body')

<form method="GET">
    <div class="input-group mb-3">
        <input
            name="author"
            type="text"
            class="form-control"
            placeholder="Search by author"
            aria-label="Search by author"
            aria-describedby="basic-addon2"
            >
    </div>
</form>

@if ($search_term != '')
<div class="mt-2 mb-1">Showing {{ count($posts) }} search result(s) for: <em>{{ $search_term }}</em></div>
<div class="mt-1 mb-1"><a href="?" class="blue">Back to all posts</a></div>
@endif

<div class="container">
@foreach ($posts as $post)
    <div class="row mt-4 px-0">
        <div class="row">
            <div class="col-3 d-none d-sm-block">
                @if ($post['image_url_path'] != null)
                <img src="{{ $post['image_url_path'] }}" class="rounded w-100" alt="Thumbnail">
                @endif
            </div>
            <div class="col">
                <div class="fw-bold">{{ $post['title'] }}</div>
                <div class="text-black-50">{{ $post['posted_at'] }} | {{ $post['author_name'] }}</div>
                <div class="post-text">{{ $post['body_preview'] }}</div>
            </div>
        </div>

        <div class="row justify-content-end text-end">
            <a href="{{ $post['url'] }}">Read more</a>
        </div>
    </div>
@endforeach
</div>

@endsection
