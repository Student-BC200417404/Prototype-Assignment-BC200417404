<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Main Categories
        $mainCategories = [
            [
                'name' => 'Appetizers',
                'subcategories' => [
                    'Soups',
                    'Salads',
                    'Small Plates',
                    'Bruschetta',
                    'Spring Rolls',
                ]
            ],
            [
                'name' => 'Main Courses',
                'subcategories' => [
                    'Steaks',
                    'Seafood',
                    'Pasta',
                    'Chicken Dishes',
                    'Vegetarian Mains',
                ]
            ],
            [
                'name' => 'Burgers & Sandwiches',
                'subcategories' => [
                    'Classic Burgers',
                    'Specialty Burgers',
                    'Chicken Sandwiches',
                    'Vegetarian Burgers',
                    'Club Sandwiches',
                ]
            ],
            [
                'name' => 'Pizza',
                'subcategories' => [
                    'Classic Pizzas',
                    'Specialty Pizzas',
                    'Vegetarian Pizzas',
                    'Calzones',
                ]
            ],
            [
                'name' => 'Asian Cuisine',
                'subcategories' => [
                    'Sushi Rolls',
                    'Noodle Dishes',
                    'Stir-Fry',
                    'Curry Dishes',
                    'Rice Bowls',
                ]
            ],
            [
                'name' => 'Sides',
                'subcategories' => [
                    'French Fries',
                    'Onion Rings',
                    'Coleslaw',
                    'Mashed Potatoes',
                    'Grilled Vegetables',
                ]
            ],
            [
                'name' => 'Desserts',
                'subcategories' => [
                    'Cakes',
                    'Ice Cream',
                    'Pies',
                    'Puddings',
                    'Cookies & Brownies',
                ]
            ],
            [
                'name' => 'Beverages',
                'subcategories' => [
                    'Soft Drinks',
                    'Hot Drinks',
                    'Smoothies',
                    'Fresh Juices',
                    'Mocktails',
                ]
            ],
            [
                'name' => 'Special Menus',
                'subcategories' => [
                    'Kids Menu',
                    'Lunch Specials',
                    'Chef\'s Specials',
                    'Weekend Brunch',
                    'Holiday Specials',
                ]
            ],
        ];

        foreach ($mainCategories as $index => $category) {
            // Insert main category
            $mainCategoryId = DB::table('categories')->insertGetId([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'parent_id' => null,
                'display_order' => $index,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert subcategories
            foreach ($category['subcategories'] as $subIndex => $subcategory) {
                DB::table('categories')->insert([
                    'name' => $subcategory,
                    'slug' => Str::slug($subcategory),
                    'parent_id' => $mainCategoryId,
                    'display_order' => $subIndex,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 