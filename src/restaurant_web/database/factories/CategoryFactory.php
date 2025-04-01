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
            'parent_id' => null, // or you can use $this->faker->randomElement([null, 1, 2]) for random parent IDs
            'name' => $this->faker->unique()->word,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'display_order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean,
        ];
    }
} 