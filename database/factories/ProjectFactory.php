<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->uuid(),
            'title' => fake()->words(3, true),
            'body' => fake()->sentences(3, true),
            'translations' => [],
            'is_pro_bono' => fake()->boolean(),
        ];
    }
}
