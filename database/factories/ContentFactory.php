<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ContentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'category_id' => Category::inRandomOrder()->first()->id, // Random category
            'type_id' => ContentType::inRandomOrder()->first()->id, // Random content type
        ];
    }
}
