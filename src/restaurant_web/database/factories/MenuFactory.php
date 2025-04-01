<?php

namespace Database\Factories;

use App\Models\Menu;
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
            'category_id' => \App\Models\Category::factory(), // Assuming you have a Category model
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'discount_price' => $this->faker->optional()->randomFloat(2, 1, 50),
            'image' => $this->faker->imageUrl(640, 480, 'food'),
            'is_vegetarian' => $this->faker->boolean(),
            'is_spicy' => $this->faker->boolean(),
            'is_available' => $this->faker->boolean(),
            'ingredients' => json_encode($this->faker->words(3)),
            'nutritional_info' => json_encode(['calories' => $this->faker->numberBetween(100, 500), 'fat' => $this->faker->numberBetween(1, 20)]),
            'preparation_time' => $this->faker->numberBetween(10, 60),
        ];
    }
}
