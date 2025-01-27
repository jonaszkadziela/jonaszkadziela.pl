<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'link' => fake()->url(),
            'translations' => [],
            'is_pro_bono' => fake()->boolean(),
            'started_at' => Carbon::now()->subYear(),
            'finished_at' => Carbon::now()->subMonth(),
        ];
    }
}
