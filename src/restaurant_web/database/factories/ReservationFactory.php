<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        $reservationDate = $this->faker->dateTimeBetween('now', '+2 weeks');
        $reservationTime = $this->faker->dateTimeBetween('11:00', '22:00');

        return [
            'customer_id' => Customer::factory(),
            'reservation_date' => $reservationDate->format('Y-m-d'),
            'reservation_time' => $reservationTime->format('H:i:s'),
            'number_of_guests' => $this->faker->numberBetween(1, 8),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'special_requests' => $this->faker->optional()->sentence(),
            'table_number' => $this->faker->optional()->numberBetween(1, 20),
            'cancellation_reason' => $this->faker->optional()->sentence(),
            'confirmed_at' => $this->faker->optional()->dateTimeBetween('-1 day', 'now'),
            'cancelled_at' => $this->faker->optional()->dateTimeBetween('-1 day', 'now'),
        ];
    }

    /**
     * Indicate that the reservation is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'confirmed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the reservation is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the reservation is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $this->faker->sentence(),
        ]);
    }

    /**
     * Indicate that the reservation is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'confirmed_at' => now()->subHours(2),
        ]);
    }

    /**
     * Indicate that the reservation is for a large group.
     */
    public function largeGroup(): static
    {
        return $this->state(fn (array $attributes) => [
            'number_of_guests' => $this->faker->numberBetween(6, 12),
        ]);
    }

    /**
     * Indicate that the reservation is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'reservation_date' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the reservation is for tomorrow.
     */
    public function tomorrow(): static
    {
        return $this->state(fn (array $attributes) => [
            'reservation_date' => now()->addDay()->format('Y-m-d'),
        ]);
    }
} 