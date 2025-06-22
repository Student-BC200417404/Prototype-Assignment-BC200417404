<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 5, 50);
        $subtotal = $quantity * $unitPrice;

        return [
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
            'special_instructions' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the order detail has special instructions.
     */
    public function withInstructions(): static
    {
        return $this->state(fn (array $attributes) => [
            'special_instructions' => $this->faker->sentence(),
        ]);
    }

    /**
     * Indicate that the order detail is for a large quantity.
     */
    public function largeQuantity(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(5, 10),
        ]);
    }
} 