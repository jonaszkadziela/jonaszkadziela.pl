<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->uuid(),
            'storage_disk' => fake()->randomElement(['local', 'public']),
            'storage_path' => fake()->filePath(),
            'mime_type' => fake()->mimeType(),
        ];
    }
}
