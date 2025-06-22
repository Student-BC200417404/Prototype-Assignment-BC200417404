<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        // FAQ Categories with their FAQs
        $categories = [
            [
                'name' => 'General Information',
                'display_order' => 1,
                'faqs' => [
                    [
                        'question' => 'What are your restaurant\'s hours of operation?',
                        'answer' => 'We are open daily from 11:00 AM to 11:00 PM. Join us for lunch, dinner, or anything in between!',
                        'display_order' => 1,
                    ],
                    [
                        'question' => 'Do you accept reservations?',
                        'answer' => 'Yes, we accept reservations through our website or by phone. We recommend booking in advance, especially for weekends and special occasions.',
                        'display_order' => 2,
                    ],
                    [
                        'question' => 'Is parking available?',
                        'answer' => 'Yes, we offer free parking for our customers in our dedicated parking lot.',
                        'display_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Menu & Dining',
                'display_order' => 2,
                'faqs' => [
                    [
                        'question' => 'Do you accommodate dietary restrictions?',
                        'answer' => 'Yes, we offer vegetarian, vegan, and gluten-free options. Please inform your server about any allergies or dietary requirements.',
                        'display_order' => 1,
                    ],
                    [
                        'question' => 'Do you have a kids menu?',
                        'answer' => 'Yes, we offer a special kids menu with child-friendly portions and options.',
                        'display_order' => 2,
                    ],
                    [
                        'question' => 'Can I customize my order?',
                        'answer' => 'Absolutely! We\'re happy to accommodate special requests and modifications to suit your preferences.',
                        'display_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Reservations & Orders',
                'display_order' => 3,
                'faqs' => [
                    [
                        'question' => 'How can I make a reservation?',
                        'answer' => 'Reservations can be made online through our website, by phone, or through our mobile app.',
                        'display_order' => 1,
                    ],
                    [
                        'question' => 'Do you offer takeout and delivery?',
                        'answer' => 'Yes, we offer both takeout and delivery services. Orders can be placed online or by phone.',
                        'display_order' => 2,
                    ],
                    [
                        'question' => 'What is your cancellation policy?',
                        'answer' => 'We kindly ask for at least 2 hours notice for reservation cancellations. For large groups, please provide 24 hours notice.',
                        'display_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Special Events',
                'display_order' => 4,
                'faqs' => [
                    [
                        'question' => 'Can you accommodate private events?',
                        'answer' => 'Yes, we have private dining rooms available for special events and celebrations. Please contact our events team for details.',
                        'display_order' => 1,
                    ],
                    [
                        'question' => 'Do you offer catering services?',
                        'answer' => 'Yes, we provide catering services for both corporate and private events. Contact us for menu options and pricing.',
                        'display_order' => 2,
                    ],
                    [
                        'question' => 'Do you host birthday parties?',
                        'answer' => 'Yes! We love celebrating birthdays. We can accommodate groups of various sizes and offer special birthday packages.',
                        'display_order' => 3,
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            // Check if category already exists to prevent duplicates
            $category = FaqCategory::firstOrCreate(
                ['name' => $categoryData['name']],
                [
                    'slug' => \Illuminate\Support\Str::slug($categoryData['name']),
                    'display_order' => $categoryData['display_order'],
                    'is_active' => true,
                ]
            );

            // Create FAQs for this category (only if they don't exist)
            foreach ($categoryData['faqs'] as $faqData) {
                Faq::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'question' => $faqData['question'],
                    ],
                    [
                        'answer' => $faqData['answer'],
                        'display_order' => $faqData['display_order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
} 