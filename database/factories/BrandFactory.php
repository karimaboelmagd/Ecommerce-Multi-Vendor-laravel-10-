<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>fake()->word,
            'slug' => fake()->unique()->slug,
            'photo' => fake()->imageUrl('60','60'),
            'status' => fake()->randomElement(['active','inactive']),
            ];
    }
}
