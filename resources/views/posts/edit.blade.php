@extends('layouts.app')

@section('body')

<div id="content-container">

<h1>Edit post</h1>

<form id="update-form" method="POST" action="{{ $edit_form_action }}">
    @method('PUT')
    @csrf

    <input
        type="text"
        id="title"
        name="title"
        placeholder="Title"
        value="{{ $errors->any() ? old('title') : $post->title }}"
        class="rounded-corners"
        >
    @error('title')
        <div class="form-input-error">{{ $message }}</div>
    @enderror

    <input
        type="text"
        id="author-name"
        name="author_name"
        placeholder="Author name"
        value="{{ $errors->any() ? old('author_name') : $post->author_name }}"
        class="rounded-corners mt-1"
        >
    @error('author_name')
        <div class="form-input-error">{{ $message }}</div>
    @enderror

    <textarea
        id="body"
        name="body"
        placeholder="Start typing..."
        class="mt-1"
        >{{ $errors->any() ? old('title') : $post->body }}</textarea>
    @error('body')
        <div class="form-input-error">{{ $message }}</div>
    @enderror

</form>

<form id="delete-form" method="POST" action="{{ $delete_form_action }}">
    @method('DELETE')
    @csrf
</form>

<div class="btn-row flex-between">
    <a class="btn btn-gray" href="{{ $cancel_redirect }}">Cancel</a>
    <input form="delete-form" type="submit" value="Delete" class="btn btn-red">
    <input form="update-form" type="submit" value="Update" class="btn btn-blue">
</div>



</div>

@endsection
