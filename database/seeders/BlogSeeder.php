<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first(); // Author

        $recipes = BlogCategory::updateOrCreate(['slug' => 'recipes'], ['name' => 'Recipes & Flavors']);
        $business = BlogCategory::updateOrCreate(['slug' => 'business'], ['name' => 'Franchise & Business']);
        $culture = BlogCategory::updateOrCreate(['slug' => 'culture'], ['name' => 'Street Food Culture']);

        $blogs = [
            [
                'blog_category_id' => $recipes->id,
                'user_id' => $admin->id,
                'title' => 'The Art of Steaming: Crafting the Perfect Momo wrapper',
                'excerpt' => 'Discover the scientific secrets behind making thin, elastic, and melt-in-the-mouth wrapper dough for steamed momos.',
                'content' => '<p>Steaming momos might look simple, but the secret lies in the dough. Our master chefs explain the exact ratio of flour to water, temperature controls, and kneading patterns to make the ultra-thin, premium wrappers that GOS MOMO is famous for.</p><p>We use premium unbleached wheat flour and pure mineral water to ensure that the texture remains soft, chewy, yet strong enough to hold the juicy vegetable fillings.</p>',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'blog_category_id' => $business->id,
                'user_id' => $admin->id,
                'title' => 'Why Food Carts are the Future of Food Retail in India',
                'excerpt' => 'With low setup costs and high flexibility, mobile food carts are scaling faster than traditional sit-down restaurants.',
                'content' => '<p>Scalability is key to modern startups. GOS MOMO has adopted the Lucknow Cart pilot model to demonstrate high efficiency, minimal real estate dependence, and extremely fast payback timelines. We break down the startup margins and why a cart model makes sense for micro-investors.</p>',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'blog_category_id' => $culture->id,
                'user_id' => $admin->id,
                'title' => 'Lucknow Hazratganj Street Food Crawl: Top 5 Spots',
                'excerpt' => 'Hazratganj is the heart of Lucknow\'s heritage and street food. We list the top places you must queue up for.',
                'content' => '<p>Hazratganj is famous for its rich history and delicious food culture. From traditional kebabs to the crispy tandoori momos at GOS MOMO, here is our ultimate weekend guide for foodies in Lucknow.</p>',
                'image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
                'published_at' => now(),
            ]
        ];

        foreach ($blogs as $b) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($b['title'])],
                $b
            );
        }
    }
}
