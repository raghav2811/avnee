<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'AVNEE'],
            ['key' => 'site_email', 'value' => 'contact@avnee.in'],
            ['key' => 'site_phone', 'value' => '+91 9876543210'],
            ['key' => 'site_address', 'value' => '123 Fashion Street, New Delhi, India'],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'instagram_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'shipping_flat_rate', 'value' => '100'],
            ['key' => 'shipping_free_above', 'value' => '1499'],
            ['key' => 'razorpay_key_id', 'value' => ''],
            ['key' => 'razorpay_key_secret', 'value' => ''],
            ['key' => 'currency_symbol', 'value' => '₹'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
