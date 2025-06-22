<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Main Categories
        $mainCategories = [
            [
                'name' => 'Appetizers',
                'snonym' => 'Start your meal with our delicious appetizers',
                'display_order' => 1,
            ],
            [
                'name' => 'Main Courses',
                'snonym' => 'Our signature main dishes prepared with fresh ingredients',
                'display_order' => 2,
            ],
            [
                'name' => 'Burgers & Sandwiches',
                'snonym' => 'Juicy burgers and fresh sandwiches for a satisfying meal',
                'display_order' => 3,
            ],
            [
                'name' => 'Pizza',
                'snonym' => 'Authentic pizzas with premium toppings and fresh dough',
                'display_order' => 4,
            ],
            [
                'name' => 'Asian Cuisine',
                'snonym' => 'Traditional Asian flavors with a modern twist',
                'display_order' => 5,
            ],
            [
                'name' => 'Sides',
                'snonym' => 'Perfect accompaniments to complement your main dish',
                'display_order' => 6,
            ],
            [
                'name' => 'Desserts',
                'snonym' => 'Sweet endings to your dining experience',
                'display_order' => 7,
            ],
            [
                'name' => 'Beverages',
                'snonym' => 'Refreshing drinks to quench your thirst',
                'display_order' => 8,
            ],
            [
                'name' => 'Special Menus',
                'snonym' => 'Exclusive menus for special occasions and dietary needs',
                'display_order' => 9,
            ],
        ];

        foreach ($mainCategories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'snonym' => $category['snonym'],
                    'slug' => Str::slug($category['name']),
                    'display_order' => $category['display_order'],
                    'is_active' => true,
                ]
            );
        }
    }
} 