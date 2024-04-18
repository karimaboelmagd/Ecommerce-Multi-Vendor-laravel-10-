<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'summary' => fake()->text,
            'description' => fake()->text,
            'stock' => fake()->numberBetween(2,10),
            'brand_id'=>fake()->randomElement(Brand::pluck('id')->toArray()),
            'cat_id'=>fake()->randomElement(Category::where('is_parent',1)->pluck('id')->toArray()),
            'child_cat_id'=>fake()->randomElement(Category::where('is_parent',0)->pluck('id')->toArray()),
            'vendor_id'=>fake()->randomElement(User::pluck('id')->toArray()),
            'photo'=>fake()->imageUrl('400','200'),
            'price'=>fake()->numberBetween(100,1000),
            'offer_price'=>fake()->numberBetween(100,1000),
            'discount'=>fake()->numberBetween(0,100),
            'size'=>fake()->randomElement(['S','M','L','XL','2XL']),
            'condition' => fake()->randomElement(['popular','new','winter']),
            'status' => fake()->randomElement(['active','inactive']),
        ];
    }
}
