# Laravel Blog

**Note:** I am making incremental improvements to the code.

For the original Wednesday submission, please see:

```
git checkout ec3b7a31
```

_...where "~~Tuesday~~ commmit" should say Wednesday instead._


## Development setup

You will need:

|          | Version I am using |
|----------|--------------------|
| php      | `8.1.10 (CLI)`     |
| composer | `2.1.6`            |
| docker   | `20.10.17`         |

Download the code and dependencies:

```
$ git clone https://github.com/marinm/blog
$ cd blog
```

Set the environment variables. The example values are OK for development.

```
$ cp .env.example .env
```

Install dependencies, including Laravel Sail.

```
$ composer install --dev
```

_Note: If you have other docker containers running at this time you may get localhost:port conflicts._

Start up

```
$ ./vendor/bin/sail up
```

In a separate terminal, connect to the web host container to run commands:

```
$ docker exec -it blog-laravel.test-1 /bin/bash
```

In the web host container:

Seed the database with some random demo values:

```
# php artisan key:generate
# php artisan migrate:fresh --seed
```

Install node dependencies and start the asset loader (Vite):

```
# npm install
# npm run dev
```

(Wait a few seconds for Vite to start up)

The site should now be live at `http://localhost`.

## Code

```
blog
|-- app
|   |-- Http
|   |   |-- Controllers
|   |   |   |-- PostController.php
|   |   |   +-- CommentController.php
|   |   +-- Requests
|   |       |-- StoreCommentRequest.php
|   |       +-- StorePostRequest.php
|   |-- Models
|   |   |-- Comment.php
|   |   +-- Post.php
|   +-- Repositories
|       |-- CommentRepository.php
|       +-- PostRepository.php
|-- database
|   |-- factories
|   |   |-- CommentFactory.php
|   |   +-- PostFactory.php
|   |-- migrations
|   |   |-- [timestamp]_create_posts_table.php
|   |   +-- [timestamp]_create_comments_table.php
|   +-- seeders
|       |-- CommentSeeder.php
|       |-- DatabaseSeeder.php
|       +-- PostSeeder.php
|-- resources
|   |-- css
|   |   +-- app.css
|   +-- views
|       |-- layouts
|       |   +-- app.blade.php
|       +-- posts
|           |-- confirm-delete-success.blade.php
|           |-- create.blade.php
|           |-- edit.blade.php
|           |-- index.blade.php
|           +-- post.blade.php
+-- routes
    +-- web.php
```


## CRUD

|         | CREATE | READ | UPDATE | DELETE |
|---------|--------|------|--------|--------|
| Post    |  ✔︎     |  ✔︎   |  ✔︎     |  ✔︎     |
| Comment |  ✔︎     |  ✔︎   |        |        |


## Routes

|                       | `GET`    | `POST`   | `PUT`  | `DELETE` |
|-----------------------|:--------:|:--------:|:------:|:------:|
| `/`                   |  ✔︎       |          |        |        |
| `/posts`              |  ✔︎       |  ✔︎       |        |        |
| `/posts/create`       |  ✔︎       |          |        |        |
| `/posts/:id`          |  ✔︎       |          |  ✔︎     |  ✔︎     |
| `/posts/:id/edit`     |  ✔︎       |          |        |        |
| `/posts/:id/comments` |  ✔︎       |  ✔︎       |        |        |

Print all routes and their controllers with:

```
# php artisan route:list
```

## Screenshots

![](/docs/screenshots/)


### List all posts

| Widescreen| Mobile |
|-|-|
| ![List all posts](/docs/screenshots/widescreen-all-posts.png) | ![List all posts](/docs/screenshots/mobile-all-posts.png) |

### Search results

| Widescreen| Mobile |
|-|-|
| ![Search results](/docs/screenshots/widescreen-search-results.png) | ![Search results](/docs/screenshots/mobile-search-results.png) |


### Post

| Widescreen| Mobile |
|-|-|
| ![Post](/docs/screenshots/widescreen-one-post-page.png) | ![Post](/docs/screenshots/mobile-one-post-page.png) |


### Edit post

| Widescreen| Mobile |
|-|-|
| ![Edit post](/docs/screenshots/widescreen-edit-post.png) | ![Edit post](/docs/screenshots/mobile-edit-post.png) |


### Confirm post deleted

| Widescreen| Mobile |
|-|-|
| ![Confirm post deleted](/docs/screenshots/widescreen-confirm-post-deleted.png) | ![Confirm post deleted](/docs/screenshots/mobile-confirm-post-deleted.png) |


### New post

| Widescreen| Mobile |
|-|-|
| ![New post](/docs/screenshots/widescreen-new-post.png) | ![New post](/docs/screenshots/mobile-new-post.png) |


### New post - Input error

| Widescreen| Mobile |
|-|-|
| ![New post - Input error](/docs/screenshots/widescreen-new-post-input-error.png) | ![New post - Input error](/docs/screenshots/mobile-new-post-input-error.png) |
