<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Aarav Sharma',
                'designation' => 'Food Blogger',
                'content' => 'GOS MOMO has completely changed my perception of street-style momos. The Kurkure Chicken Momo is a masterpiece — super crunchy outside and incredibly juicy inside!',
                'avatar' => '/images/testimonials/avatar1.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sneha Verma',
                'designation' => 'Tech Professional',
                'content' => 'The hygiene levels are exceptional, and the ordering flow is incredibly smooth. The Butter Chicken Gravy Momo is my comfort food now. Highly recommended!',
                'avatar' => '/images/testimonials/avatar2.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Rohan Gupta',
                'designation' => 'Franchise Partner, Lucknow',
                'content' => 'Investing in the GOS MOMO Cart model was the best business decision I made. The backend supply chain and training support from Mahoksh Core are top-class.',
                'avatar' => '/images/testimonials/avatar3.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ]
        ];

        foreach ($testimonials as $test) {
            Testimonial::updateOrCreate(
                ['name' => $test['name']],
                $test
            );
        }
    }
}
