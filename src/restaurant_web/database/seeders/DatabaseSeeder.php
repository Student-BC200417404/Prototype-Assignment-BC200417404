<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core data seeders
            AdminSeeder::class,
            StaffSeeder::class,
            CustomerSeeder::class,
            
            // Restaurant structure seeders
            CategorySeeder::class,
            SubCategorySeeder::class,
            TableSeeder::class,
            
            // Content seeders
            MenuSeeder::class,
            FaqSeeder::class,
            
            // Sample data seeders (optional - for testing)
            SampleOrderSeeder::class,
            SampleReservationSeeder::class,
        ]);
    }
}
