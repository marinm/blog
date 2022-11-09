# Laravel Blog

## Development setup

You will need:

|          | Version I am using |
|----------|--------------------|
| docker   | `20.10.17`         |


Download the code:

```
$ git clone https://github.com/marinm/blog
$ cd blog
```

Set the environment variables. The example values are OK for development.

```
$ cp .env.example .env
```

Install Sail and dependencies using a one-use container:

```
sh composer-install.sh
```

Start up

```
./vendor/bin/sail up
```

_Note: If you have other docker containers running at this time you may get localhost:port conflicts._

In a separate terminal, connect to the web host container to run commands:

```
docker exec -it blog-laravel.test-1 /bin/bash
```

In the web host container:

Seed the database with some random demo values:

```
php artisan key:generate
php artisan migrate:fresh --seed
```

Install node dependencies and start the asset loader (Vite):

```
npm install
npm run dev
```

(Wait a few seconds for Vite to start up)

The site should now be live at `http://localhost`.

## Code

Where to look for the code I wrote.

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
|   |-- Interfaces
|   |   |-- CommentRepositoryInterface.php
|   |   +-- PostRepositoryInterface.php
|   |-- Models
|   |   |-- Comment.php
|   |   +-- Post.php
|   |-- Providers
|   |   +-- RepositoryServiceProvider.php
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


### Index

![Show Newest Posts](/docs/screenshots/mobile/posts-index.png)


### Show

![Show A Post](/docs/screenshots/mobile/posts-show.png)


### Edit post

![Edit Post](/docs/screenshots/mobile/posts-edit.png)


### Create

![Create Post](/docs/screenshots/mobile/posts-create.png)