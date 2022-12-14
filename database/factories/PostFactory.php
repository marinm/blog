<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'author_name' => $this->faker->name(),
            'image_path' => null,
            'body' => implode("\n\n", $this->faker->paragraphs(3)),
        ];
    }
}
