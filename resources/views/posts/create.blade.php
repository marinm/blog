@extends('layouts.app')

@section('body')

<h1>Create a new post</h1>

<form
    method="POST"
    action="{{ $form_action }}"
    id="create-post-form"
    enctype="multipart/form-data"
    class="mt-4 d-grid gap-3"
    >

    @method('POST')
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
        value="{{ $errors->any() ? old('title') : '' }}"
        >

    <input
        type="text"
        id="author_name"
        name="author_name"
        placeholder="Author name"
        class="form-control @error('author_name') is-invalid @enderror"
        value="{{ $errors->any() ? old('author_name') : '' }}"
        >

    <input type="file" accept="image/*" name="image">

    <textarea
        id="body"
        name="body"
        class="form-control"
        placeholder="Start typing"
        style="height: 20em"
        >{{ old('body') }}</textarea>

    <div class="row">
        <div class="col">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <div class="col text-end">
            <input type="submit" value="Create" class="btn btn-primary">
        </div>
    </div>

</form>


@endsection
