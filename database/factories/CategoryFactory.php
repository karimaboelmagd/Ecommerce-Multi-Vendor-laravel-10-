<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'slug' => fake()->unique()->slug,
            'summary' => fake()->sentences(3,true),
            'photo' => fake()->imageUrl('350','350'),
            'is_parent' => fake()->randomElement([true,false]),
            'status' => fake()->randomElement(['active','inactive']),
            'parent_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            ];
    }
}
