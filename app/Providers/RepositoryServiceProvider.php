<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\CommentRepositoryInterface;

use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
