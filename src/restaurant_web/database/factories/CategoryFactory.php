<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'snonym' => $this->faker->optional()->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'food'),
            'display_order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
} 