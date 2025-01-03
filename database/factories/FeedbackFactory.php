<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(Feedback::SUPPORTED_TYPES),
            'body' => fake()->sentences(3, true),
            'data' => [
                '_telescope' => 1735929648306,
                'url' => 'http://jonaszkadziela.test/contact',
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'telescopeEntry' => null,
            ],
        ];
    }
}
