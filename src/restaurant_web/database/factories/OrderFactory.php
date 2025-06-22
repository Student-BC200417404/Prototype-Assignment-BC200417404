<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $subtotal = $this->faker->randomFloat(2, 10, 200);
        $tax = $subtotal * 0.08; // 8% tax
        $discount = $this->faker->optional(0.2)->randomFloat(2, 0, $subtotal * 0.2); // 20% chance of discount
        $deliveryFee = $this->faker->optional(0.3)->randomFloat(2, 0, 15); // 30% chance of delivery fee
        $total = $subtotal + $tax - ($discount ?? 0) + ($deliveryFee ?? 0);

        return [
            'customer_id' => Customer::factory(),
            'reservation_id' => $this->faker->optional(0.3)->randomElement([Reservation::factory()]),
            'order_number' => 'ORD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'type' => $this->faker->randomElement(['dine-in', 'takeaway', 'delivery']),
            'status' => $this->faker->randomElement(['pending', 'preparing', 'ready', 'delivered', 'completed', 'cancelled']),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount ?? 0,
            'delivery_fee' => $deliveryFee ?? 0,
            'total' => $total,
            'delivery_address' => $this->faker->optional()->address(),
            'notes' => $this->faker->optional()->sentence(),
            'prepared_at' => $this->faker->optional()->dateTimeBetween('-1 hour', 'now'),
            'delivered_at' => $this->faker->optional()->dateTimeBetween('-30 minutes', 'now'),
        ];
    }

    /**
     * Indicate that the order is dine-in.
     */
    public function dineIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'dine-in',
            'delivery_fee' => 0,
            'delivery_address' => null,
        ]);
    }

    /**
     * Indicate that the order is takeaway.
     */
    public function takeaway(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'takeaway',
            'delivery_fee' => 0,
            'delivery_address' => null,
        ]);
    }

    /**
     * Indicate that the order is delivery.
     */
    public function delivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'delivery',
            'delivery_fee' => $this->faker->randomFloat(2, 5, 15),
            'delivery_address' => $this->faker->address(),
        ]);
    }

    /**
     * Indicate that the order is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the order is preparing.
     */
    public function preparing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'preparing',
        ]);
    }

    /**
     * Indicate that the order is ready.
     */
    public function ready(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ready',
            'prepared_at' => now(),
        ]);
    }

    /**
     * Indicate that the order is delivered.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
            'prepared_at' => now()->subMinutes(30),
            'delivered_at' => now(),
        ]);
    }

    /**
     * Indicate that the order is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'prepared_at' => now()->subHours(1),
            'delivered_at' => now()->subMinutes(30),
        ]);
    }

    /**
     * Indicate that the order is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
} 