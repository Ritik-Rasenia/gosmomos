<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Noida Head Office',
                'type' => 'outlet',
                'address' => 'Sector 62, Noida',
                'city' => 'Noida',
                'state' => 'Uttar Pradesh',
                'pincode' => '201301',
                'lat' => 28.6273,
                'lng' => 77.3725,
                'phone' => '+91 99999 88888',
                'opening_time' => '10:00:00',
                'closing_time' => '22:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lucknow Cart',
                'type' => 'cart',
                'address' => 'Hazratganj, Near Cathedral School',
                'city' => 'Lucknow',
                'state' => 'Uttar Pradesh',
                'pincode' => '226001',
                'lat' => 26.8467,
                'lng' => 80.9462,
                'phone' => '+91 88888 77777',
                'opening_time' => '12:00:00',
                'closing_time' => '23:00:00',
                'is_active' => true,
            ]
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(
                ['name' => $loc['name']],
                $loc
            );
        }
    }
}
