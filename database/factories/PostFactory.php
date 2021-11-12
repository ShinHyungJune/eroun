<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $blog = Blog::factory()->create();

        return [
            // "blog_id" => $blog->id,
            "title" => $this->faker->title,
            "description" => $this->faker->paragraph
        ];
    }
}
