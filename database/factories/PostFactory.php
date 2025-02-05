<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->uuid(),
            'title' => fake()->words(3, true),
            'body' => fake()->paragraphs(5, true),
            'translations' => [],
        ];
    }
}
