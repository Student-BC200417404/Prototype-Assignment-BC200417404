<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategory;

class FaqCategorySeeder extends Seeder
{
    public function run()
    {
        // Create FAQ categories
        $categories = [
            [
                'name' => 'General Information',
                'display_order' => 1,
            ],
            [
                'name' => 'Menu & Dining',
                'display_order' => 2,
            ],
            [
                'name' => 'Reservations & Orders',
                'display_order' => 3,
            ],
            [
                'name' => 'Special Events',
                'display_order' => 4,
            ],
            [
                'name' => 'Payment & Pricing',
                'display_order' => 5,
            ],
            [
                'name' => 'Accessibility',
                'display_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            FaqCategory::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'display_order' => $category['display_order'],
                'is_active' => true,
            ]);
        }
    }
} 