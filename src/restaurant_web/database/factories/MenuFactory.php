<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(3, true),
            'snonym' => $this->faker->optional()->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'discount_price' => $this->faker->optional(0.3)->randomFloat(2, 1, 50),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'food'),
            'is_vegetarian' => $this->faker->boolean(30), // 30% chance of being vegetarian
            'is_spicy' => $this->faker->boolean(40), // 40% chance of being spicy
            'is_available' => $this->faker->boolean(90), // 90% chance of being available
            'ingredients' => $this->faker->words(5),
            'nutritional_info' => [
                'calories' => $this->faker->numberBetween(100, 800),
                'protein' => $this->faker->numberBetween(5, 50),
                'carbs' => $this->faker->numberBetween(10, 100),
                'fat' => $this->faker->numberBetween(1, 30),
                'fiber' => $this->faker->numberBetween(1, 15),
            ],
            'preparation_time' => $this->faker->numberBetween(10, 60),
        ];
    }

    /**
     * Indicate that the menu item is vegetarian.
     */
    public function vegetarian(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_vegetarian' => true,
        ]);
    }

    /**
     * Indicate that the menu item is spicy.
     */
    public function spicy(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_spicy' => true,
        ]);
    }

    /**
     * Indicate that the menu item is unavailable.
     */
    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }
}
