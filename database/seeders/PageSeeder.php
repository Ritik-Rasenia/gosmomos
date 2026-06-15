<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h3>Our Journey</h3><p>GOS MOMO started with a simple vision: to craft the crunchiest, most delicious, and hygienic street-style momos in India. Using hand-picked fresh ingredients and secret traditional seasonings, we bring authentic street food flavours in a clean and premium environment.</p><h3>Why We Are Different</h3><p>We combine traditional taste with state-of-the-art hygienic prep processes. Every momo is crafted under strict quality protocols, from dough rolling to steaming and frying, ensuring standard excellence at every cart, kiosk, and outlet.</p>',
                'meta_title' => 'About Us — GOS MOMO',
                'meta_description' => 'Learn about the story of GOS MOMO, our hygiene protocols, and our commitment to premium street-style momos.',
                'meta_keywords' => 'about us, story, gos momo history, food tech startup',
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h3>Information Collection</h3><p>We collect your personal details (name, email, phone, address) to fulfill orders placed on our online system and manage deliveries. Payment details are processed securely through payment partners and are not stored on our servers.</p><h3>Data Usage</h3><p>We use your contact number to send order tracking notifications and optional updates. You can opt out at any time.</p>',
                'meta_title' => 'Privacy Policy — GOS MOMO',
                'meta_description' => 'Read how GOS MOMO collects, uses, and secures customer order and address information.',
                'meta_keywords' => 'privacy policy, gdpr, data protection, terms',
                'is_active' => true,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h3>Service Usage</h3><p>By using the Gosmomos website or app, you agree to provide accurate registration details and utilize our ordering portals solely for legitimate purchases.</p><h3>Pricing & Order Delivery</h3><p>All item prices are subject to change. Order deliveries are executed through local store managers and delivery partners, and times may vary based on weather and distance.</p>',
                'meta_title' => 'Terms of Service — GOS MOMO',
                'meta_description' => 'Review the user agreement, order guidelines, and terms of service for GOS MOMO purchases.',
                'meta_keywords' => 'terms of service, conditions, user agreement, legal',
                'is_active' => true,
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'content' => '<h3>Cancellation Window</h3><p>Orders can only be cancelled before they are accepted and prepared by the kitchen outlet. Once preparation begins, no refunds will be initiated.</p><h3>Payment Refunds</h3><p>In case of failed delivery or incorrect items, refund requests will be investigated by our support managers. Approved refunds are credited back to your original payment gateway within 5-7 business days.</p>',
                'meta_title' => 'Refund & Cancellation Policy — GOS MOMO',
                'meta_description' => 'Review cancellations, missing items, and refund processing details for your online orders.',
                'meta_keywords' => 'refund policy, cancellation, return, payments',
                'is_active' => true,
            ]
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }
    }
}
