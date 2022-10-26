@extends('layouts.app')

@section('body')

<div id="content-container">
    <h1>Post Deleted</h1>
    <a class="blue" href="{{ $suggested_redirect_path }}">{{ $suggest_text }}</a>
</div>

@endsection
