<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->customer(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->optional()->address(),
            'date_of_birth' => $this->faker->optional()->dateTimeBetween('-80 years', '-18 years'),
        ];
    }

    /**
     * Indicate that the customer is a minor.
     */
    public function minor(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_of_birth' => $this->faker->dateTimeBetween('-17 years', '-13 years'),
        ]);
    }

    /**
     * Indicate that the customer is a senior.
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-65 years'),
        ]);
    }
} 