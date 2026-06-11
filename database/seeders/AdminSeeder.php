<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\DeliveryPartner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@gosmomo.com'],
            [
                'name' => 'Super Admin (Mahoksh)',
                'phone' => '9999999999',
                'password' => Hash::make('admin123'),
                'status' => 'active',
                'referral_code' => 'SUPER100',
            ]
        );
        $superAdminRole = Role::where('slug', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdmin->roles()->sync([$superAdminRole->id]);
        }

        // 2. Store Manager
        $manager = User::updateOrCreate(
            ['email' => 'manager@gosmomo.com'],
            [
                'name' => 'Lucknow Cart Manager',
                'phone' => '8888888888',
                'password' => Hash::make('manager123'),
                'status' => 'active',
                'referral_code' => 'MGR200',
            ]
        );
        $managerRole = Role::where('slug', 'store_manager')->first();
        if ($managerRole) {
            $manager->roles()->sync([$managerRole->id]);
        }

        // 3. Franchise Partner
        $franchise = User::updateOrCreate(
            ['email' => 'franchise@gosmomo.com'],
            [
                'name' => 'Rohan Gupta (Franchise)',
                'phone' => '7777777777',
                'password' => Hash::make('franchise123'),
                'status' => 'active',
                'referral_code' => 'FRAN300',
            ]
        );
        $franchiseRole = Role::where('slug', 'franchise_partner')->first();
        if ($franchiseRole) {
            $franchise->roles()->sync([$franchiseRole->id]);
        }

        // 4. Delivery Partner
        $deliveryUser = User::updateOrCreate(
            ['email' => 'delivery@gosmomo.com'],
            [
                'name' => 'Rahul Kumar (Delivery)',
                'phone' => '6666666666',
                'password' => Hash::make('delivery123'),
                'status' => 'active',
                'referral_code' => 'DEL400',
            ]
        );
        $deliveryRole = Role::where('slug', 'delivery_partner')->first();
        if ($deliveryRole) {
            $deliveryUser->roles()->sync([$deliveryRole->id]);
        }
        
        // Seed Delivery Partner Info
        DeliveryPartner::updateOrCreate(
            ['user_id' => $deliveryUser->id],
            [
                'vehicle_type' => 'bike',
                'vehicle_number' => 'UP-32-AB-1234',
                'license_number' => 'DL-99202611029',
                'is_verified' => true,
                'is_online' => true,
                'current_lat' => 26.8467,
                'current_lng' => 80.9462,
                'rating' => 4.9,
                'total_deliveries' => 45,
            ]
        );

        // 5. Customer
        $customerUser = User::updateOrCreate(
            ['email' => 'customer@gosmomo.com'],
            [
                'name' => 'Mohit Verma',
                'phone' => '5555555555',
                'password' => Hash::make('customer123'),
                'status' => 'active',
                'referral_code' => 'CUST500',
            ]
        );
        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $customerUser->roles()->sync([$customerRole->id]);
        }
        
        // Seed customer wallet
        $wallet = Wallet::updateOrCreate(
            ['user_id' => $customerUser->id],
            ['balance' => 500.00]
        );
        $wallet->transactions()->updateOrCreate(
            ['description' => 'Welcome Bonus'],
            [
                'type' => 'credit',
                'amount' => 500.00,
                'balance_after' => 500.00,
            ]
        );
    }
}
