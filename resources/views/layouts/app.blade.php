<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous"
            >

        @vite(['resources/css/app.css'])

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"
            ></script>
    </head>
    <body>

        <div class="navbar container-lg shadow p-3 mb-5 bg-white rounded">
            <div class="container-lg">
                <a class="navbar-brand" href="/">Home</a>
                <a href="/posts/create" class="btn btn-primary">New Post</a>
            </div>
        </div>

        <div id="content-container" class="container-sm">
            @section('body')
            The content did not load
            @show
        </div>

    </body>
</html>
