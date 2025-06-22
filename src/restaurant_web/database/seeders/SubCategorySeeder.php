<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
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

        // Sub-categories for each main category
        $subCategories = [
            $appetizersId => [
                ['name' => 'Soups', 'description' => 'Warm and comforting soups'],
                ['name' => 'Salads', 'description' => 'Fresh and healthy salads'],
                ['name' => 'Small Plates', 'description' => 'Perfect for sharing'],
                ['name' => 'Bruschetta', 'description' => 'Italian-style appetizers'],
                ['name' => 'Spring Rolls', 'description' => 'Asian-inspired starters'],
            ],
            $mainCoursesId => [
                ['name' => 'Steaks', 'description' => 'Premium cuts of beef'],
                ['name' => 'Seafood', 'description' => 'Fresh ocean delights'],
                ['name' => 'Pasta', 'description' => 'Italian pasta dishes'],
                ['name' => 'Chicken Dishes', 'description' => 'Delicious chicken preparations'],
                ['name' => 'Vegetarian Mains', 'description' => 'Plant-based main courses'],
            ],
            $burgersId => [
                ['name' => 'Classic Burgers', 'description' => 'Traditional burger favorites'],
                ['name' => 'Specialty Burgers', 'description' => 'Unique burger creations'],
                ['name' => 'Chicken Sandwiches', 'description' => 'Fresh chicken sandwiches'],
                ['name' => 'Vegetarian Burgers', 'description' => 'Plant-based burger options'],
                ['name' => 'Club Sandwiches', 'description' => 'Multi-layered sandwich delights'],
            ],
            $pizzaId => [
                ['name' => 'Classic Pizzas', 'description' => 'Traditional pizza favorites'],
                ['name' => 'Specialty Pizzas', 'description' => 'Unique pizza combinations'],
                ['name' => 'Vegetarian Pizzas', 'description' => 'Plant-based pizza options'],
                ['name' => 'Calzones', 'description' => 'Folded pizza creations'],
            ],
            $asianId => [
                ['name' => 'Sushi Rolls', 'description' => 'Fresh sushi creations'],
                ['name' => 'Noodle Dishes', 'description' => 'Asian noodle specialties'],
                ['name' => 'Stir-Fry', 'description' => 'Wok-cooked dishes'],
                ['name' => 'Curry Dishes', 'description' => 'Spiced curry preparations'],
                ['name' => 'Rice Bowls', 'description' => 'Rice-based Asian dishes'],
            ],
            $sidesId => [
                ['name' => 'French Fries', 'description' => 'Crispy potato fries'],
                ['name' => 'Onion Rings', 'description' => 'Breaded onion rings'],
                ['name' => 'Coleslaw', 'description' => 'Fresh cabbage salad'],
                ['name' => 'Mashed Potatoes', 'description' => 'Creamy mashed potatoes'],
                ['name' => 'Grilled Vegetables', 'description' => 'Fresh grilled vegetables'],
            ],
            $dessertsId => [
                ['name' => 'Cakes', 'description' => 'Delicious cake varieties'],
                ['name' => 'Ice Cream', 'description' => 'Creamy ice cream desserts'],
                ['name' => 'Pies', 'description' => 'Traditional pie desserts'],
                ['name' => 'Puddings', 'description' => 'Smooth pudding desserts'],
                ['name' => 'Cookies & Brownies', 'description' => 'Sweet baked treats'],
            ],
            $beveragesId => [
                ['name' => 'Soft Drinks', 'description' => 'Refreshing soft drinks'],
                ['name' => 'Hot Drinks', 'description' => 'Warm beverage options'],
                ['name' => 'Smoothies', 'description' => 'Fresh fruit smoothies'],
                ['name' => 'Fresh Juices', 'description' => 'Natural fruit juices'],
                ['name' => 'Mocktails', 'description' => 'Non-alcoholic cocktails'],
            ],
            $specialId => [
                ['name' => 'Kids Menu', 'description' => 'Special menu for children'],
                ['name' => 'Lunch Specials', 'description' => 'Daily lunch specials'],
                ['name' => 'Chef\'s Specials', 'description' => 'Chef\'s daily recommendations'],
                ['name' => 'Weekend Brunch', 'description' => 'Weekend brunch menu'],
                ['name' => 'Holiday Specials', 'description' => 'Special holiday menus'],
            ],
        ];

        foreach ($subCategories as $categoryId => $subs) {
            foreach ($subs as $index => $sub) {
                SubCategory::create([
                    'category_id' => $categoryId,
                    'name' => $sub['name'],
                    'snonym' => $sub['description'],
                    'slug' => \Illuminate\Support\Str::slug($sub['name']),
                    'description' => $sub['description'],
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
} 