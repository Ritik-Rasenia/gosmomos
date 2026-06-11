<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General settings
            ['key' => 'site_name', 'value' => 'GOS MOMO', 'group' => 'general', 'type' => 'text'],
            ['key' => 'tagline', 'value' => 'The Taste India Will Queue For', 'group' => 'general', 'type' => 'text'],
            ['key' => 'brand_owner', 'value' => 'Mahoksh Core', 'group' => 'general', 'type' => 'text'],
            ['key' => 'logo', 'value' => '/images/logo.png', 'group' => 'general', 'type' => 'file'],
            ['key' => 'favicon', 'value' => '/favicon.ico', 'group' => 'general', 'type' => 'file'],

            // Contact settings
            ['key' => 'contact_email', 'value' => 'info@gosmomo.com', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+91 88888 77777', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'head_office_address', 'value' => 'Noida, Uttar Pradesh, India', 'group' => 'contact', 'type' => 'textarea'],
            
            // Social Links
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/gosmomo', 'group' => 'social', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/gosmomo', 'group' => 'social', 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/gosmomo', 'group' => 'social', 'type' => 'text'],

            // Payment settings
            ['key' => 'razorpay_key_id', 'value' => 'rzp_test_placeholderKey', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'razorpay_key_secret', 'value' => 'placeholderSecret', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'enable_cod', 'value' => '1', 'group' => 'payment', 'type' => 'boolean'],
            ['key' => 'enable_wallet', 'value' => '1', 'group' => 'payment', 'type' => 'boolean'],

            // WhatsApp Settings
            ['key' => 'whatsapp_number', 'value' => '918888877777', 'group' => 'notification', 'type' => 'text'],
            ['key' => 'enable_whatsapp_notifications', 'value' => '0', 'group' => 'notification', 'type' => 'boolean'],

            // PWA settings
            ['key' => 'pwa_theme_color', 'value' => '#0F5132', 'group' => 'pwa', 'type' => 'text'],
            ['key' => 'pwa_background_color', 'value' => '#FFF8F0', 'group' => 'pwa', 'type' => 'text'],
        ];

        foreach ($settings as $set) {
            Setting::updateOrCreate(
                ['key' => $set['key']],
                [
                    'value' => $set['value'],
                    'group' => $set['group'],
                    'type' => $set['type'],
                ]
            );
        }
    }
}
