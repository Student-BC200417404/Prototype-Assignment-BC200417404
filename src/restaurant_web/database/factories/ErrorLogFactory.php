<?php

namespace Database\Factories;

use App\Models\ErrorLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ErrorLogFactory extends Factory
{
    protected $model = ErrorLog::class;

    public function definition()
    {
        return [
            'method' => $this->faker->randomElement(['customer', 'admin', 'staff']),
            'user_id' => $this->faker->optional()->randomElement([User::factory()]),
            'error_code' => $this->faker->optional()->bothify('ERR-####'),
            'error_message' => $this->faker->sentence(),
            'stack_trace' => $this->faker->optional()->paragraphs(3, true),
            'additional_data' => $this->faker->optional()->randomElements([
                'request_data' => $this->faker->words(3),
                'session_data' => $this->faker->words(2),
                'user_agent' => $this->faker->userAgent(),
            ]),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'url' => $this->faker->url(),
            'request_method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE', 'PATCH']),
            'is_resolved' => $this->faker->boolean(20), // 20% chance of being resolved
        ];
    }

    /**
     * Indicate that the error log is for a customer.
     */
    public function customer(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => 'customer',
        ]);
    }

    /**
     * Indicate that the error log is for an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => 'admin',
        ]);
    }

    /**
     * Indicate that the error log is for staff.
     */
    public function staff(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => 'staff',
        ]);
    }

    /**
     * Indicate that the error log is resolved.
     */
    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_resolved' => true,
        ]);
    }

    /**
     * Indicate that the error log is unresolved.
     */
    public function unresolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_resolved' => false,
        ]);
    }
} 