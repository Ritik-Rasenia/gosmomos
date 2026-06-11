<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoPage;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'page_slug' => 'home',
                'meta_title' => 'GOS MOMO — Premium Momo Brand | Lucknow & Noida',
                'meta_description' => 'Experience the finest, most hygienic, and crunchiest street style momos in India. Order online or explore low investment high ROI franchise options.',
                'meta_keywords' => 'gos momo, premium momos, lucknow momos, noida food, kurkure momo, tandoori momo, food franchise, mahoksh core',
                'og_image' => '/images/seo/home_share.jpg',
            ],
            [
                'page_slug' => 'our-story',
                'meta_title' => 'Our Story — The GOS MOMO Journey | Mahoksh Core',
                'meta_description' => 'Discover how GOS MOMO started as a premium food startup in Noida. Learn about our strict hygiene standards, fresh ingredients, and vision.',
                'meta_keywords' => 'gos momo journey, mahoksh core, food philosophy, hygiene promise',
                'og_image' => '/images/seo/our_story_share.jpg',
            ],
            [
                'page_slug' => 'franchise',
                'meta_title' => 'Franchise Opportunities — Cart, Kiosk & Outlet Model | GOS MOMO',
                'meta_description' => 'Partner with GOS MOMO. Low investment, high ROI franchise models including Cart, Kiosk, and Outlet. Apply online today to start your startup.',
                'meta_keywords' => 'gos momo franchise, food cart franchise, kiosk model, investment ROI, franchise india',
                'og_image' => '/images/seo/franchise_share.jpg',
            ],
            [
                'page_slug' => 'locations',
                'meta_title' => 'Outlets & Carts Near You | GOS MOMO Locations',
                'meta_description' => 'Find the nearest GOS MOMO Lucknow Cart or Noida Outlet. View working hours, map directions, and contact details.',
                'meta_keywords' => 'gos momo lucknow, hazratganj momo, gosmomo noida, find momos near me',
                'og_image' => '/images/seo/locations_share.jpg',
            ],
            [
                'page_slug' => 'catering',
                'meta_title' => 'Corporate Events & Birthday Catering | GOS MOMO',
                'meta_description' => 'Make your event special with live momo carts and hot catering by GOS MOMO. Bulk orders, birthday parties, college festivals, and corporate events.',
                'meta_keywords' => 'live momo catering, bulk food orders, birthday party catering, corporate food Lucknow',
                'og_image' => '/images/seo/catering_share.jpg',
            ],
            [
                'page_slug' => 'gallery',
                'meta_title' => 'GOS MOMO Food & Outlet Gallery',
                'meta_description' => 'Browse photos of GOS MOMO products, Lucknow Cart, state-of-the-art kitchen setup, and happy customers enjoying their momos.',
                'meta_keywords' => 'momo pictures, food gallery, kitchen hygiene, cart photos',
                'og_image' => '/images/seo/gallery_share.jpg',
            ],
            [
                'page_slug' => 'blog',
                'meta_title' => 'Momo Chronicles & Food Blogs | GOS MOMO',
                'meta_description' => 'Read our latest stories, recipes, business insights on the food-tech industry, and how franchise expansion works.',
                'meta_keywords' => 'food blogs, franchise business tips, street food trend',
                'og_image' => '/images/seo/blog_share.jpg',
            ],
            [
                'page_slug' => 'contact',
                'meta_title' => 'Contact GOS MOMO | Noida Head Office',
                'meta_description' => 'Get in touch with the GOS MOMO team. For inquiries, partnerships, career opportunities, or corporate events, contact Noida HO.',
                'meta_keywords' => 'contact gosmomo, mahoksh core contact, phone number, head office noida',
                'og_image' => '/images/seo/contact_share.jpg',
            ],
        ];

        foreach ($pages as $page) {
            SeoPage::updateOrCreate(
                ['page_slug' => $page['page_slug']],
                $page
            );
        }
    }
}
