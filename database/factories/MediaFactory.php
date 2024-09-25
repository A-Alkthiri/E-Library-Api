<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content_id' => Content::inRandomOrder()->first()->id, // Random content
            'format' => fake()->randomElement(['physical', 'digital']),
            'file_path' => fake()->boolean(50) ? fake()->url : null, // If digital, create a file path
            'isbn' => fake()->isbn13, // Generate random ISBN
        ];
    }
}
