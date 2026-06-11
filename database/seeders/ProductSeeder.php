<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $steam = Category::where('slug', 'steam-momos')->first();
        $fried = Category::where('slug', 'fried-momos')->first();
        $kurkure = Category::where('slug', 'kurkure-momos')->first();
        $tandoori = Category::where('slug', 'tandoori-momos')->first();
        $gravy = Category::where('slug', 'gravy-momos')->first();
        $rolls = Category::where('slug', 'rolls')->first();
        $combos = Category::where('slug', 'combos')->first();
        $beverages = Category::where('slug', 'beverages')->first();

        $products = [
            // Steam Momos
            [
                'category_id' => $steam->id,
                'name' => 'Signature Veg Steam Momo',
                'description' => 'Fresh vegetables finely chopped and mixed with secret herbs, steamed to perfection. Served with spicy momo chutney.',
                'short_description' => 'Classic steamed vegetable momos',
                'base_price' => 99.00,
                'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 12,
                'calories' => 180,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 99.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 179.00],
                ]
            ],
            [
                'category_id' => $steam->id,
                'name' => 'Classic Chicken Steam Momo',
                'description' => 'Juicy minced chicken blended with aromatic ginger, garlic, and fresh coriander, wrapped in thin dough. Served with fiery schezwan sauce.',
                'short_description' => 'Juicy minced chicken steamed momos',
                'base_price' => 120.00,
                'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
                'is_veg' => false,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 12,
                'calories' => 240,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 120.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 219.00],
                ]
            ],

            // Fried Momos
            [
                'category_id' => $fried->id,
                'name' => 'Paneer Fried Momo',
                'description' => 'Crispy golden fried momos stuffed with rich cottage cheese, onion, and herbs. Served with mayo and hot chutney.',
                'short_description' => 'Crispy fried momos with rich paneer stuffing',
                'base_price' => 119.00,
                'image' => 'https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 15,
                'calories' => 320,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 119.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 219.00],
                ]
            ],

            // Kurkure Momos
            [
                'category_id' => $kurkure->id,
                'name' => 'Classic Chicken Kurkure Momo',
                'description' => 'Mouthwatering chicken momos coated in crunchy cornflake batter and deep-fried. The ultimate crunch experience!',
                'short_description' => 'Super crunchy cornflake-crusted chicken momos',
                'base_price' => 149.00,
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'is_veg' => false,
                'is_bestseller' => true,
                'is_new' => true,
                'preparation_time' => 15,
                'calories' => 380,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 149.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 279.00],
                ]
            ],
            [
                'category_id' => $kurkure->id,
                'name' => 'Crunchy Veg Kurkure Momo',
                'description' => 'Classic vegetable momos dipped in a special batter, coated with crispy flakes, and fried. Extra crispy outside, tender inside.',
                'short_description' => 'Super crunchy cornflake-crusted vegetable momos',
                'base_price' => 129.00,
                'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'preparation_time' => 15,
                'calories' => 290,
                'spice_level' => 1,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 129.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 239.00],
                ]
            ],

            // Tandoori Momos
            [
                'category_id' => $tandoori->id,
                'name' => 'Spicy Paneer Tandoori Momo',
                'description' => 'Paneer momos marinated in yogurt and tandoori spices, charcoal-grilled in a clay oven. Served with mint chutney.',
                'short_description' => 'Clay-oven charcoal-grilled paneer momos',
                'base_price' => 139.00,
                'image' => 'https://images.unsplash.com/photo-1601050690597-df056fb4ce78?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 18,
                'calories' => 260,
                'spice_level' => 3,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 139.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 249.00],
                ]
            ],

            // Gravy Momos
            [
                'category_id' => $gravy->id,
                'name' => 'Butter Chicken Gravy Momo',
                'description' => 'Fried chicken momos tossed in a rich, buttery, creamy tomato-based butter chicken gravy, garnished with fresh cream.',
                'short_description' => 'Juicy chicken momos in rich buttery tomato gravy',
                'base_price' => 169.00,
                'image' => 'https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?auto=format&fit=crop&w=600&q=80',
                'is_veg' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'preparation_time' => 18,
                'calories' => 450,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Half (5 Pcs)', 'price' => 169.00],
                    ['name' => 'Full (10 Pcs)', 'price' => 299.00],
                ]
            ],

            // Rolls
            [
                'category_id' => $rolls->id,
                'name' => 'Schezwan Veg Roll',
                'description' => 'Warm flaky paratha loaded with stir-fried crisp vegetables and a generous splash of spicy schezwan sauce.',
                'short_description' => 'Crispy roll with stir-fried vegetables and schezwan',
                'base_price' => 89.00,
                'image' => 'https://images.unsplash.com/photo-1626700051175-6518c4793f4f?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 10,
                'calories' => 280,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Single Roll', 'price' => 89.00],
                    ['name' => 'Double Roll', 'price' => 159.00],
                ]
            ],

            // Combos
            [
                'category_id' => $combos->id,
                'name' => 'GOS Ultimate Veg Momo Platter',
                'description' => 'Can\'t choose? Get 2 pieces each of Veg Steam, Fried, Kurkure, Tandoori, and Gravy momos. Served with 2 dips and a beverage.',
                'short_description' => 'Assorted veg momos platter (10 Pcs) with dips & drink',
                'base_price' => 299.00,
                'image' => 'https://images.unsplash.com/photo-1615870216519-2f9fa575fa5c?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'preparation_time' => 20,
                'calories' => 650,
                'spice_level' => 2,
                'variants' => [
                    ['name' => 'Single Platter', 'price' => 299.00],
                ]
            ],

            // Beverages
            [
                'category_id' => $beverages->id,
                'name' => 'Classic Lemon Mojito',
                'description' => 'Cooling drink with fresh mint leaves, lime juice, sugar syrup, and soda served chilled with crushed ice.',
                'short_description' => 'Refreshing mint and lime mocktail',
                'base_price' => 79.00,
                'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=600&q=80',
                'is_veg' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'preparation_time' => 5,
                'calories' => 90,
                'spice_level' => 0,
                'variants' => [
                    ['name' => 'Standard Glass', 'price' => 79.00],
                ]
            ],
        ];

        foreach ($products as $prod) {
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

            // Add variants
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
