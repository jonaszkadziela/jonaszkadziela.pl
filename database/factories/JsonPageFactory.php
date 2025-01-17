<?php

namespace Database\Factories;

use App\Models\JsonPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JsonPage>
 */
class JsonPageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => Str::slug(fake()->unique()->text(20)),
            'sections' => [],
            'translations' => [],
        ];
    }
}
