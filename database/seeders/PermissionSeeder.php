<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Products', 'slug' => 'manage_products'],
            ['name' => 'Manage Orders', 'slug' => 'manage_orders'],
            ['name' => 'Manage Franchise Leads', 'slug' => 'manage_franchise'],
            ['name' => 'Manage Delivery Partners', 'slug' => 'manage_delivery'],
            ['name' => 'Manage Customers', 'slug' => 'manage_customers'],
            ['name' => 'View Reports', 'slug' => 'view_reports'],
            ['name' => 'Manage Settings', 'slug' => 'manage_settings'],
            ['name' => 'Manage Blogs', 'slug' => 'manage_blogs'],
            ['name' => 'Manage Content', 'slug' => 'manage_content'],
            ['name' => 'Deliver Orders', 'slug' => 'deliver_orders'],
            ['name' => 'Manage Store Orders', 'slug' => 'manage_store_orders'],
            ['name' => 'Access Franchise Portal', 'slug' => 'access_franchise_portal'],
        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }

        // Assign all to Super Admin and Admin
        $superAdmin = Role::where('slug', 'super_admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $storeManager = Role::where('slug', 'store_manager')->first();
        $deliveryPartner = Role::where('slug', 'delivery_partner')->first();
        $franchisePartner = Role::where('slug', 'franchise_partner')->first();

        if ($superAdmin) {
            $superAdmin->permissions()->sync(collect($createdPermissions)->pluck('id'));
        }
        if ($admin) {
            $admin->permissions()->sync(collect($createdPermissions)->pluck('id'));
        }
        if ($storeManager) {
            $storeManagerPermissions = Permission::whereIn('slug', ['manage_store_orders', 'manage_orders', 'manage_products'])->pluck('id');
            $storeManager->permissions()->sync($storeManagerPermissions);
        }
        if ($deliveryPartner) {
            $deliveryPermissions = Permission::whereIn('slug', ['deliver_orders'])->pluck('id');
            $deliveryPartner->permissions()->sync($deliveryPermissions);
        }
        if ($franchisePartner) {
            $franchisePermissions = Permission::whereIn('slug', ['access_franchise_portal'])->pluck('id');
            $franchisePartner->permissions()->sync($franchisePermissions);
        }
    }
}
