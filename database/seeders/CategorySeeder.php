<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Steam Momos', 'icon' => 'bi-cloud-fog'],
            ['name' => 'Fried Momos', 'icon' => 'bi-fire'],
            ['name' => 'Kurkure Momos', 'icon' => 'bi-stars'],
            ['name' => 'Tandoori Momos', 'icon' => 'bi-circle-square'],
            ['name' => 'Gravy Momos', 'icon' => 'bi-droplet-half'],
            ['name' => 'Rolls', 'icon' => 'bi-wrap'],
            ['name' => 'Combos', 'icon' => 'bi-gift'],
            ['name' => 'Beverages', 'icon' => 'bi-cup-straw'],
        ];

        foreach ($categories as $index => $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
