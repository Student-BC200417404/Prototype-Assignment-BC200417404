<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StaffSeeder extends Seeder
{
    public function run()
    {
        // Create Staff Users
        $staffMembers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@restaurant.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@restaurant.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Mike Davis',
                'email' => 'mike.davis@restaurant.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Emily Wilson',
                'email' => 'emily.wilson@restaurant.com',
                'role' => 'staff',
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@restaurant.com',
                'role' => 'staff',
            ],
        ];

        foreach ($staffMembers as $staff) {
            User::firstOrCreate(
                ['email' => $staff['email']],
                [
                    'name' => $staff['name'],
                    'password' => Hash::make('password'),
                    'role' => $staff['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
} 