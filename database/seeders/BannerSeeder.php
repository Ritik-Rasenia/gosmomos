<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Gos Momo — The Taste India Will Queue For',
                'subtitle' => 'Taste the premium street style momos crafted with absolute hygiene.',
                'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=1200&q=80',
                'link' => '/menu',
                'button_text' => 'Order Now',
                'sort_order' => 1,
                'is_active' => true,
                'location' => 'home',
            ],
            [
                'title' => 'Grow With GOS MOMO',
                'subtitle' => 'Join the fastest growing momo brand franchise network with low investment & high ROI.',
                'image' => 'https://images.unsplash.com/photo-1601050690597-df056fb4ce78?auto=format&fit=crop&w=1200&q=80',
                'link' => '/franchise',
                'button_text' => 'Apply Franchise',
                'sort_order' => 2,
                'is_active' => true,
                'location' => 'franchise',
            ]
        ];

        foreach ($banners as $ban) {
            Banner::updateOrCreate(
                ['title' => $ban['title']],
                $ban
            );
        }
    }
}
