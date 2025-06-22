<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition()
    {
        return [
            'category_id' => FaqCategory::factory(),
            'question' => $this->faker->sentence() . '?',
            'answer' => $this->faker->paragraph(),
            'display_order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the FAQ is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
} 