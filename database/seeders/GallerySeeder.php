<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            [
                'title' => 'Signature Steamed Momos',
                'category' => 'food',
                'image_path' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Golden Fried Crispy Momos',
                'category' => 'food',
                'image_path' => 'https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Hygienic Modern Kitchen Station',
                'category' => 'kitchen',
                'image_path' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Lucknow Hazratganj Cart pilot',
                'category' => 'outlet',
                'image_path' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 4,
                'is_active' => true,
            ]
        ];

        foreach ($photos as $p) {
            Gallery::updateOrCreate(
                ['title' => $p['title']],
                $p
            );
        }
    }
}
