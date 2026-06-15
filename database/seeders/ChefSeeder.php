<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chef;

class ChefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chefs = [
            [
                'name' => 'Chef Rajeev Verma',
                'role' => 'Executive Head Chef',
                'bio' => 'Expert in North Indian culinary arts and traditional momo variations with over 12 years of experience leading five-star hotel kitchens.',
                'image' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=300&q=80',
                'facebook_url' => 'https://facebook.com/chefrajeev',
                'instagram_url' => 'https://instagram.com/chefrajeev',
                'twitter_url' => 'https://twitter.com/chefrajeev',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Chef Sarah Khan',
                'role' => 'Kitchen Operations Manager',
                'bio' => 'Dedicated to maintaining absolute culinary precision, safety standards, and operations management across all our franchise kitchens.',
                'image' => 'https://images.unsplash.com/photo-1581579438747-1dc8d17fce2c?auto=format&fit=crop&w=300&q=80',
                'facebook_url' => 'https://facebook.com/chefsarah',
                'instagram_url' => 'https://instagram.com/chefsarah',
                'twitter_url' => 'https://twitter.com/chefsarah',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Chef Aman Gupta',
                'role' => 'Sous & Quality Chef',
                'bio' => 'Specialized in authentic Himalayan steam ratios, hand-folded techniques, and creative sauce fusion formulations.',
                'image' => 'https://images.unsplash.com/photo-1581299894007-aaa50297cf16?auto=format&fit=crop&w=300&q=80',
                'facebook_url' => 'https://facebook.com/chefaman',
                'instagram_url' => 'https://instagram.com/chefaman',
                'twitter_url' => 'https://twitter.com/chefaman',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($chefs as $chefData) {
            Chef::updateOrCreate(
                ['name' => $chefData['name']],
                $chefData
            );
        }
    }
}
