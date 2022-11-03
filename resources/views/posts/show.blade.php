@extends('layouts.app')

@section('body')

@isset ($session['confirm_edited'])
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
  Post edited
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endisset

@isset ($session['confirm_created'])
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
  New post created
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endisset


<div class="row mb-3">
    <a href="/posts" class="blue">Back</a>
</div>

<h1>{{ $post['title'] }}</h1>

<div class="text-black-50">
    {{ $post['posted_at'] }} | {{ $post['author_name'] }}
</div>

<div class="row mt-4 mb-4">
    <img src="{{ $post['image_url_path'] }}" class="img-fluid">
</div>

<div class="text" style="white-space: pre-wrap">{{ $post['body'] }}</div>

<div class="row text-center py-4 mb-4 border-bottom">
    <a href="{{ $edit_post_page }}" class="blue">Edit</a>
</div>


@foreach ($comments as $comment)
    <div class="row mb-3">
        <div class="text">{{ $comment['text'] }}</div>
        <div class="text-black-50"">{{ $comment['posted_at'] }}</div>
    </div>
@endforeach


<form
    method="POST"
    id="new-comment"
    action="{{ $new_comment_form_action }}"
    class="mt-4"
    >

    @method('POST')
    @csrf

    <div class="row">
        <textarea
            id="text"
            name="text"
            class="form-control"
            placeholder="Write a comment"
            style="height: 5em"
            >{{ $errors->any() ? old('text') : '' }}</textarea>
    </div>

    <div class="row justify-content-end">
        <div class="col col-auto p-0">
            <input type="submit" value="Add comment" class="btn btn-primary mt-2">
        </div>
    </div>

</form>

@endsection
