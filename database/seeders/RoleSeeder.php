<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super_admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Store Manager', 'slug' => 'store_manager'],
            ['name' => 'Franchise Partner', 'slug' => 'franchise_partner'],
            ['name' => 'Delivery Partner', 'slug' => 'delivery_partner'],
            ['name' => 'Customer', 'slug' => 'customer'],
            ['name' => 'Guest', 'slug' => 'guest'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name']]
            );
        }
    }
}
