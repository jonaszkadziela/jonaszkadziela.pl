<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
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
            'link' => fake()->url(),
            'translations' => [],
            'issued_at' => Carbon::now(),
        ];
    }
}
