<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\Comment;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::factory()
            ->count(10)
            ->has(Comment::factory()->count(5))
            ->create();
    }
}
