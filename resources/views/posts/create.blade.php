@extends('layouts.app')

@section('body')
<div id="content-container">

    <h1>Create a new post</h1>

    <form method="POST" action="{{ $form_action }}" id="create-post-form">
        @method('POST')
        @csrf

        <input
            type="text"
            id="title"
            name="title"
            placeholder="Title"
            value="{{ $errors->any() ? old('title') : null }}"
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
            value="{{ $errors->any() ? old('author_name') : null }}"
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
            >{{ $errors->any() ? old('title') : '' }}</textarea>
        @error('body')
            <div class="form-input-error">{{ $message }}</div>
        @enderror

        <div class="flex-right mt-1">
            <input type="submit" value="Create" class="btn btn-blue">
        </div>
    </form>

</div>
@endsection
