<?php

namespace Database\Factories;

use App\Models\Social;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Social>
 */
class SocialFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'link' => fake()->url(),
            'icon' => 'fa-solid fa-globe',
        ];
    }
}
