<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    protected $model = FaqCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'slug' => $this->faker->unique()->slug(),
            'display_order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the FAQ category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
} 