<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Get category IDs
        $appetizersId = Category::where('name', 'Appetizers')->first()->id;
        $mainCoursesId = Category::where('name', 'Main Courses')->first()->id;
        $burgersId = Category::where('name', 'Burgers & Sandwiches')->first()->id;
        $pizzaId = Category::where('name', 'Pizza')->first()->id;
        $asianId = Category::where('name', 'Asian Cuisine')->first()->id;
        $sidesId = Category::where('name', 'Sides')->first()->id;
        $dessertsId = Category::where('name', 'Desserts')->first()->id;
        $beveragesId = Category::where('name', 'Beverages')->first()->id;
        $specialId = Category::where('name', 'Special Menus')->first()->id;

        // Appetizers
        $this->createMenuItems($appetizersId, [
            ['name' => 'Bruschetta', 'price' => 8.99, 'is_vegetarian' => true],
            ['name' => 'Spring Rolls', 'price' => 7.99, 'is_vegetarian' => true],
            ['name' => 'Chicken Wings', 'price' => 12.99, 'is_spicy' => true],
            ['name' => 'Mozzarella Sticks', 'price' => 9.99, 'is_vegetarian' => true],
            ['name' => 'Spinach Artichoke Dip', 'price' => 10.99, 'is_vegetarian' => true],
        ]);

        // Main Courses
        $this->createMenuItems($mainCoursesId, [
            ['name' => 'Grilled Salmon', 'price' => 24.99],
            ['name' => 'Beef Tenderloin', 'price' => 29.99],
            ['name' => 'Chicken Marsala', 'price' => 19.99],
            ['name' => 'Vegetable Stir Fry', 'price' => 16.99, 'is_vegetarian' => true],
            ['name' => 'Pasta Carbonara', 'price' => 18.99],
        ]);

        // Burgers & Sandwiches
        $this->createMenuItems($burgersId, [
            ['name' => 'Classic Cheeseburger', 'price' => 14.99],
            ['name' => 'Veggie Burger', 'price' => 13.99, 'is_vegetarian' => true],
            ['name' => 'Chicken Club Sandwich', 'price' => 15.99],
            ['name' => 'BBQ Pulled Pork Sandwich', 'price' => 16.99],
            ['name' => 'Portobello Mushroom Burger', 'price' => 14.99, 'is_vegetarian' => true],
        ]);

        // Pizza
        $this->createMenuItems($pizzaId, [
            ['name' => 'Margherita Pizza', 'price' => 16.99, 'is_vegetarian' => true],
            ['name' => 'Pepperoni Pizza', 'price' => 18.99],
            ['name' => 'Vegetarian Supreme', 'price' => 17.99, 'is_vegetarian' => true],
            ['name' => 'BBQ Chicken Pizza', 'price' => 19.99],
            ['name' => 'Four Cheese Pizza', 'price' => 17.99, 'is_vegetarian' => true],
        ]);

        // Asian Cuisine
        $this->createMenuItems($asianId, [
            ['name' => 'Kung Pao Chicken', 'price' => 16.99, 'is_spicy' => true],
            ['name' => 'Vegetable Fried Rice', 'price' => 12.99, 'is_vegetarian' => true],
            ['name' => 'Sweet and Sour Pork', 'price' => 15.99],
            ['name' => 'Tofu Pad Thai', 'price' => 14.99, 'is_vegetarian' => true],
            ['name' => 'Beef and Broccoli', 'price' => 17.99],
        ]);

        // Sides
        $this->createMenuItems($sidesId, [
            ['name' => 'French Fries', 'price' => 4.99, 'is_vegetarian' => true],
            ['name' => 'Onion Rings', 'price' => 5.99, 'is_vegetarian' => true],
            ['name' => 'Mashed Potatoes', 'price' => 4.99, 'is_vegetarian' => true],
            ['name' => 'Grilled Vegetables', 'price' => 6.99, 'is_vegetarian' => true],
            ['name' => 'Coleslaw', 'price' => 3.99, 'is_vegetarian' => true],
        ]);

        // Desserts
        $this->createMenuItems($dessertsId, [
            ['name' => 'Chocolate Lava Cake', 'price' => 8.99, 'is_vegetarian' => true],
            ['name' => 'New York Cheesecake', 'price' => 7.99, 'is_vegetarian' => true],
            ['name' => 'Apple Pie', 'price' => 6.99, 'is_vegetarian' => true],
            ['name' => 'Tiramisu', 'price' => 8.99, 'is_vegetarian' => true],
            ['name' => 'Ice Cream Sundae', 'price' => 5.99, 'is_vegetarian' => true],
        ]);

        // Beverages
        $this->createMenuItems($beveragesId, [
            ['name' => 'Fresh Lemonade', 'price' => 3.99, 'is_vegetarian' => true],
            ['name' => 'Iced Tea', 'price' => 2.99, 'is_vegetarian' => true],
            ['name' => 'Smoothie', 'price' => 5.99, 'is_vegetarian' => true],
            ['name' => 'Coffee', 'price' => 2.99, 'is_vegetarian' => true],
            ['name' => 'Hot Chocolate', 'price' => 3.99, 'is_vegetarian' => true],
        ]);

        // Special Menus
        $this->createMenuItems($specialId, [
            ['name' => 'Kids Chicken Tenders', 'price' => 8.99],
            ['name' => 'Lunch Special - Soup & Sandwich', 'price' => 12.99],
            ['name' => 'Chef\'s Special - Daily Fish', 'price' => 22.99],
            ['name' => 'Weekend Brunch - Eggs Benedict', 'price' => 14.99],
            ['name' => 'Holiday Special - Turkey Dinner', 'price' => 18.99],
        ]);
    }

    private function createMenuItems($categoryId, $items)
    {
        foreach ($items as $item) {
            Menu::create([
                'category_id' => $categoryId,
                'name' => $item['name'],
                'snonym' => 'Delicious ' . strtolower($item['name']),
                'slug' => \Illuminate\Support\Str::slug($item['name']),
                'description' => 'Fresh and delicious ' . strtolower($item['name']) . ' prepared with premium ingredients.',
                'price' => $item['price'],
                'discount_price' => null,
                'image' => null,
                'is_vegetarian' => $item['is_vegetarian'] ?? false,
                'is_spicy' => $item['is_spicy'] ?? false,
                'is_available' => true,
                'ingredients' => ['Fresh ingredients', 'Premium quality'],
                'nutritional_info' => [
                    'calories' => rand(200, 800),
                    'protein' => rand(5, 40),
                    'carbs' => rand(10, 80),
                    'fat' => rand(2, 30),
                ],
                'preparation_time' => rand(10, 30),
            ]);
        }
    }
} 