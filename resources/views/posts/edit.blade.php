@extends('layouts.app')

@section('body')

<h1>Edit post</h1>

<form
    method="POST"
    action="{{ $edit_form_action }}"
    id="update-form"
    enctype="multipart/form-data"
    class="mt-4 d-grid gap-3"
    >

    @method('PUT')
    @csrf

    @if ($errors->any())
    <div class="alert alert-danger pb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <input
        type="text"
        id="title"
        name="title"
        placeholder="Title"
        class="form-control @error('title') is-invalid @enderror"
        value="{{ $errors->any() ? old('title') : $post['title'] }}"
        >

    <input
        type="text"
        id="author_name"
        name="author_name"
        placeholder="Author name"
        class="form-control @error('author_name') is-invalid @enderror"
        value="{{ $errors->any() ? old('author_name') : $post['author_name'] }}"
        >

    <div class="row">
        @if ($post['image_url_path'])
        <img src="{{ $post['image_url_path'] }}" class="w-100">
        @endif
    </div>

    <input type="file" accept="image/*" name="image">

    <textarea
        id="body"
        name="body"
        class="form-control"
        placeholder="Start typing"
        style="height: 20em"
        >{{ $errors->any() ? old('body') : $post['body'] }}</textarea>

</form>

<form id="delete-form" method="POST" action="{{ $delete_form_action }}">
    @method('DELETE')
    @csrf
</form>

<div class="row mt-5">

    <div class="col justify-content-start">
        <input form="delete-form" type="submit" value="Delete" class="btn btn-outline-danger">
    </div>

    <div class="col text-end">
        <a class="btn btn-outline-secondary" href="{{ $cancel_redirect }}">Cancel</a>
        <input form="update-form" type="submit" value="Update" class="btn btn-primary">
    </div>

</div>

@endsection
