<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            LocationSeeder::class,
            SettingSeeder::class,
            BannerSeeder::class,
            TestimonialSeeder::class,
            ChefSeeder::class,
            SeoPageSeeder::class,
            BlogSeeder::class,
            GallerySeeder::class,
            PageSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
