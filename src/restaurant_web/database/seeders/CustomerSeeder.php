<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Create sample customers with their user accounts
        $customers = [
            [
                'user' => [
                    'name' => 'Alice Johnson',
                    'email' => 'alice.johnson@email.com',
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Alice',
                    'last_name' => 'Johnson',
                    'phone' => '+1-555-0101',
                    'email' => 'alice.johnson@email.com',
                    'address' => '123 Main St, City, State 12345',
                    'date_of_birth' => '1990-05-15',
                ],
            ],
            [
                'user' => [
                    'name' => 'Bob Wilson',
                    'email' => 'bob.wilson@email.com',
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Bob',
                    'last_name' => 'Wilson',
                    'phone' => '+1-555-0102',
                    'email' => 'bob.wilson@email.com',
                    'address' => '456 Oak Ave, City, State 12345',
                    'date_of_birth' => '1985-08-22',
                ],
            ],
            [
                'user' => [
                    'name' => 'Carol Davis',
                    'email' => 'carol.davis@email.com',
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Carol',
                    'last_name' => 'Davis',
                    'phone' => '+1-555-0103',
                    'email' => 'carol.davis@email.com',
                    'address' => '789 Pine Rd, City, State 12345',
                    'date_of_birth' => '1992-12-10',
                ],
            ],
            [
                'user' => [
                    'name' => 'David Miller',
                    'email' => 'david.miller@email.com',
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'David',
                    'last_name' => 'Miller',
                    'phone' => '+1-555-0104',
                    'email' => 'david.miller@email.com',
                    'address' => '321 Elm St, City, State 12345',
                    'date_of_birth' => '1988-03-18',
                ],
            ],
            [
                'user' => [
                    'name' => 'Eva Garcia',
                    'email' => 'eva.garcia@email.com',
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Eva',
                    'last_name' => 'Garcia',
                    'phone' => '+1-555-0105',
                    'email' => 'eva.garcia@email.com',
                    'address' => '654 Maple Dr, City, State 12345',
                    'date_of_birth' => '1995-07-25',
                ],
            ],
        ];

        foreach ($customers as $customerData) {
            // Create user account (or get existing)
            $user = User::firstOrCreate(
                ['email' => $customerData['user']['email']],
                [
                    'name' => $customerData['user']['name'],
                    'password' => bcrypt('password'),
                    'role' => $customerData['user']['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            // Create customer profile (or get existing)
            Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $customerData['customer']['first_name'],
                    'last_name' => $customerData['customer']['last_name'],
                    'phone' => $customerData['customer']['phone'],
                    'email' => $customerData['customer']['email'],
                    'address' => $customerData['customer']['address'],
                    'date_of_birth' => $customerData['customer']['date_of_birth'],
                ]
            );
        }

        // Create additional random customers using factory (only if we don't have many customers)
        if (Customer::count() < 10) {
            Customer::factory()->count(20)->create();
        }
    }
} 