<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    public function run()
    {
        // FAQ Categories
        $categories = [
            [
                'name' => 'General Information',
                'faqs' => [
                    [
                        'question' => 'What are your restaurant\'s hours of operation?',
                        'answer' => 'We are open daily from 11:00 AM to 11:00 PM. Join us for lunch, dinner, or anything in between!',
                    ],
                    [
                        'question' => 'Do you accept reservations?',
                        'answer' => 'Yes, we accept reservations through our website or by phone. We recommend booking in advance, especially for weekends and special occasions.',
                    ],
                    [
                        'question' => 'Is parking available?',
                        'answer' => 'Yes, we offer free parking for our customers in our dedicated parking lot.',
                    ],
                ],
            ],
            [
                'name' => 'Menu & Dining',
                'faqs' => [
                    [
                        'question' => 'Do you accommodate dietary restrictions?',
                        'answer' => 'Yes, we offer vegetarian, vegan, and gluten-free options. Please inform your server about any allergies or dietary requirements.',
                    ],
                    [
                        'question' => 'Do you have a kids menu?',
                        'answer' => 'Yes, we offer a special kids menu with child-friendly portions and options.',
                    ],
                ],
            ],
            [
                'name' => 'Reservations & Orders',
                'faqs' => [
                    [
                        'question' => 'How can I make a reservation?',
                        'answer' => 'Reservations can be made online through our website, by phone, or through our mobile app.',
                    ],
                    [
                        'question' => 'Do you offer takeout and delivery?',
                        'answer' => 'Yes, we offer both takeout and delivery services. Orders can be placed online or by phone.',
                    ],
                ],
            ],
            [
                'name' => 'Special Events',
                'faqs' => [
                    [
                        'question' => 'Can you accommodate private events?',
                        'answer' => 'Yes, we have private dining rooms available for special events and celebrations. Please contact our events team for details.',
                    ],
                    [
                        'question' => 'Do you offer catering services?',
                        'answer' => 'Yes, we provide catering services for both corporate and private events. Contact us for menu options and pricing.',
                    ],
                ],
            ],
        ];

        foreach ($categories as $index => $category) {
            // Insert category
            $categoryId = DB::table('faq_categories')->insertGetId([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'display_order' => $index,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert FAQs for this category
            foreach ($category['faqs'] as $faqIndex => $faq) {
                DB::table('faqs')->insert([
                    'category_id' => $categoryId,
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'display_order' => $faqIndex,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 