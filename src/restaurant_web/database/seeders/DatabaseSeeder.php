<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
           // AdminSeeder::class,
           // CategorySeeder::class,
           // FaqSeeder::class,
              MenuSeeder::class, // Add this line

            // ... other seeders
        ]);

        // Seed the menu with 50 fake items
        Menu::factory()->count(50)->create();
    }
}
