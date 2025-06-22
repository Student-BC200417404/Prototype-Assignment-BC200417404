<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition()
    {
        return [
            'table_number' => $this->faker->unique()->numberBetween(1, 50),
            'capacity' => $this->faker->randomElement([2, 4, 6, 8, 10, 12]),
            'status' => $this->faker->randomElement(['available', 'occupied', 'reserved', 'maintenance']),
            'location' => $this->faker->randomElement(['indoor', 'outdoor', 'private room', 'bar area', 'window seat']),
        ];
    }

    /**
     * Indicate that the table is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the table is occupied.
     */
    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'occupied',
        ]);
    }

    /**
     * Indicate that the table is reserved.
     */
    public function reserved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reserved',
        ]);
    }

    /**
     * Indicate that the table is under maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }

    /**
     * Indicate that the table is for 2 people.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'capacity' => 2,
        ]);
    }

    /**
     * Indicate that the table is for 4 people.
     */
    public function medium(): static
    {
        return $this->state(fn (array $attributes) => [
            'capacity' => 4,
        ]);
    }

    /**
     * Indicate that the table is for 6+ people.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'capacity' => $this->faker->randomElement([6, 8, 10, 12]),
        ]);
    }

    /**
     * Indicate that the table is indoor.
     */
    public function indoor(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => 'indoor',
        ]);
    }

    /**
     * Indicate that the table is outdoor.
     */
    public function outdoor(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => 'outdoor',
        ]);
    }

    /**
     * Indicate that the table is in a private room.
     */
    public function privateRoom(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => 'private room',
        ]);
    }
} 