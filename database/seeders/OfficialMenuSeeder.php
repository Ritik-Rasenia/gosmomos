<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class OfficialMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Re-create Categories to align with Menu Card
        $steam = Category::updateOrCreate(['slug' => 'steam-momos'], ['name' => 'Steam Momos', 'icon' => 'bi-cloud-fog', 'sort_order' => 1, 'is_active' => true]);
        $kurkure = Category::updateOrCreate(['slug' => 'kurkure-momos'], ['name' => 'Kurkure Momos', 'icon' => 'bi-stars', 'sort_order' => 2, 'is_active' => true]);
        $rolls = Category::updateOrCreate(['slug' => 'special-rolls'], ['name' => 'Special Rolls', 'icon' => 'bi-wrap', 'sort_order' => 3, 'is_active' => true]);
        $combos = Category::updateOrCreate(['slug' => 'combo-pack'], ['name' => 'Combo Pack', 'icon' => 'bi-gift', 'sort_order' => 4, 'is_active' => true]);

        // Disable or delete other categories to keep the menu clean
        Category::whereNotIn('slug', ['steam-momos', 'kurkure-momos', 'special-rolls', 'combo-pack'])->update(['is_active' => false]);

        // Delete existing products to avoid conflicts
        Product::query()->delete();

        // 2. Insert Products
        $menuProducts = [
            // STEAM MOMOS
            [
                'category_id' => $steam->id,
                'name' => 'Veg Steam Momo',
                'description' => '100% Pure Veg steamed momos stuffed with finely chopped fresh cabbage, carrots, onion, and herbs. Served with spicy momo chutney.',
                'short_description' => 'Pure Veg, Fresh & Handmade Steamed Momos',
                'base_price' => 49.00,
                'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 10,
                'calories' => 160,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half (6 Pcs)', 'price' => 49.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 89.00],
                ]
            ],
            [
                'category_id' => $steam->id,
                'name' => 'Paneer Steam Momo',
                'description' => 'Handmade steamed momos stuffed with premium grated cottage cheese (paneer), herbs, and spices. Served with fiery momo dip.',
                'short_description' => 'Fresh paneer stuffed steamed momos',
                'base_price' => 69.00,
                'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 10,
                'calories' => 210,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half (6 Pcs)', 'price' => 69.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 129.00],
                ]
            ],

            // KURKURE MOMOS
            [
                'category_id' => $kurkure->id,
                'name' => 'Veg Kurkure Momo',
                'description' => 'Veg momos coated in crunchy cornflake batter and deep-fried to a golden crisp. Extra crunchy shell with tender veggie stuffing.',
                'short_description' => 'Super crunchy cornflake crusted veg momos',
                'base_price' => 79.00,
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'preparation_time' => 12,
                'calories' => 290,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Half (6 Pcs)', 'price' => 79.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 129.00],
                ]
            ],
            [
                'category_id' => $kurkure->id,
                'name' => 'Paneer Kurkure Momo',
                'description' => 'Delicious paneer momos crusted in crispy batter flakes and fried. Extra crispy outside, rich paneer texture inside.',
                'short_description' => 'Super crunchy cornflake crusted paneer momos',
                'base_price' => 89.00,
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'preparation_time' => 12,
                'calories' => 340,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Half (6 Pcs)', 'price' => 89.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 149.00],
                ]
            ],

            // SPECIAL ROLLS
            [
                'category_id' => $rolls->id,
                'name' => 'Special Roll',
                'description' => 'Tasty vegetable and herb roll cooked in special wrap, served hot. 6 pieces per plate.',
                'short_description' => 'Tasty special vegetable rolls (6 Pcs)',
                'base_price' => 79.00,
                'image' => 'https://images.unsplash.com/photo-1626700051175-6518c4793f4f?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 10,
                'calories' => 260,
                'spice_level' => 1,
                'variants' => [
                    ['name' => '1 Plate (6 Pcs)', 'price' => 79.00],
                ]
            ],
            [
                'category_id' => $rolls->id,
                'name' => 'Cheese Ball',
                'description' => 'Gooey, cheese-stuffed balls seasoned with herbs and fried to a crisp outer crust. 4 pieces per plate.',
                'short_description' => 'Crispy cheese-filled herb balls (4 Pcs)',
                'base_price' => 89.00,
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 8,
                'calories' => 310,
                'spice_level' => 0,
                'variants' => [
                    ['name' => '1 Plate (4 Pcs)', 'price' => 89.00],
                ]
            ],
            [
                'category_id' => $rolls->id,
                'name' => 'Spring Roll',
                'description' => 'Classic crispy fried spring rolls packed with seasoned noodles and vegetables. Available in half or full orders.',
                'short_description' => 'Crispy fried vegetable spring rolls',
                'base_price' => 49.00,
                'image' => 'https://images.unsplash.com/photo-1626700051175-6518c4793f4f?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 8,
                'calories' => 220,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half', 'price' => 49.00],
                    ['name' => 'Full', 'price' => 89.00],
                ]
            ],

            // COMBO PACK
            [
                'category_id' => $combos->id,
                'name' => 'Go\'s Special Combo Pack',
                'description' => 'Best value combo pack containing 2 Special Rolls, 2 Cheese Balls, 4 Paneer Steamed Momos, and 4 Veg Steamed Momos.',
                'short_description' => 'Premium Assorted Combo (2 Rolls + 2 Cheese Balls + 8 Momos)',
                'base_price' => 149.00,
                'image' => 'https://images.unsplash.com/photo-1615870216519-2f9fa575fa5c?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'preparation_time' => 15,
                'calories' => 580,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Combo Order', 'price' => 149.00],
                ]
            ],
        ];

        foreach ($menuProducts as $prod) {
            $createdProduct = Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                [
                    'category_id' => $prod['category_id'],
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'short_description' => $prod['short_description'],
                    'base_price' => $prod['base_price'],
                    'image' => $prod['image'],
                    'is_veg' => $prod['is_veg'],
                    'is_bestseller' => $prod['is_bestseller'],
                    'is_new' => $prod['is_new'],
                    'is_available' => true,
                    'preparation_time' => $prod['preparation_time'],
                    'calories' => $prod['calories'],
                    'spice_level' => $prod['spice_level'],
                ]
            );

            foreach ($prod['variants'] as $variant) {
                $createdProduct->variants()->updateOrCreate(
                    ['name' => $variant['name']],
                    [
                        'price' => $variant['price'],
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}
