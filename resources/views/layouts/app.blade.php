<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        @vite(['resources/css/app.css'])
    </head>
    <body>

        <div id="site-header">
            <a href="/" class="nav">Home</a>
            <a href="/posts/create" class="btn btn-blue">New Post</a>
        </div>

        @section('body')
        The page did not load
        @show

    </body>
</html>
