<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    private const ALLOWED_SETTING_RULES = [
        'razorpay_key_id' => 'nullable|string|max:255',
        'razorpay_key_secret' => 'nullable|string|max:255',
        'is_cod_enabled' => 'nullable|in:0,1',
        'shiprocket_email' => 'nullable|email|max:255',
        'shiprocket_password' => 'nullable|string|max:255',
        'shiprocket_token' => 'nullable|string|max:2048',
        'shiprocket_pickup_pincode' => 'nullable|string|max:12',
        'shiprocket_pickup_location' => 'nullable|string|max:255',
        'shiprocket_webhook_secret' => 'nullable|string|max:255',
        'product_promo_primary_text' => 'nullable|string|max:255',
        'product_promo_primary_code' => 'nullable|string|max:80',
        'product_promo_secondary_text' => 'nullable|string|max:255',
        'product_promo_secondary_code' => 'nullable|string|max:80',
    ];

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $input = $request->only(array_keys(self::ALLOWED_SETTING_RULES));
        $data = validator($input, self::ALLOWED_SETTING_RULES)->validate();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('settings:all');
        Cache::forget('front:categories:1');
        Cache::forget('front:categories:2');
        Cache::forget('front:price_bands:1');
        Cache::forget('front:price_bands:2');
        Cache::forget('front:saree_edit');
        Cache::forget('front:jewellery_experience');
        Cache::forget('front:just_in_experiences:1');
        Cache::forget('front:just_in_experiences:2');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
