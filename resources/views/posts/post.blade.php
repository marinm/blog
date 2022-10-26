@extends('layouts.app')

@section('body')

<div id="content-container">

    <div id="back">
        <a href="/posts" class="blue">Back</a>
    </div>

    <h1 class="post-title">{{ $post->title }}</h1>

    <div class="datetime blank-line-top blank-line-bottom">{{ $post->posted_at }} | {{ $post->author_name }}</div>

    <div class="post-body">{{ $post->body }}</div>

    <div class="flex-center">
        <a href="{{ $edit_post_page }}" class="blue">Edit</a>
    </div>

    <div class="hr"></div>

    <ul class="comments-list">
    @foreach ($comments as $comment)
        <li>
            <div class="comment-text">{{ $comment['text'] }}</div>
            <div class="datetime blank-line-top">{{ $comment['posted_at'] }}</div>
        </li>
    @endforeach
    </ul>

    <form id="new-comment" method="POST" action="{{ $new_comment_form_action }}">
        @csrf
        <textarea
            name="text"
            placeholder="Write a comment"
            class="blank-line-bottom"
            >{{ $errors->any() ? old('text') : '' }}</textarea>
        @error('text')
        <div>{{ $message }}</div>
        @enderror
        <div class="flex-right blank-line-top">
            <input type="submit" value="Add comment" class="btn btn-blue">
        </div>
    </form>

</div>



@endsection
