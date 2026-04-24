<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900/50 dark:border-green-800 dark:text-green-300" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        
                        <!-- General Settings -->
                        <h3 class="text-lg font-medium mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2">General Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Name</label>
                                <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="site_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Email</label>
                                <input type="email" name="site_email" id="site_email" value="{{ $settings['site_email'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="site_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Phone</label>
                                <input type="text" name="site_phone" id="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="site_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Address</label>
                                <textarea name="site_address" id="site_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ $settings['site_address'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Shipping Settings Section Removed (Handled by Shiprocket) -->

                        <!-- Order Tracking & Logistics -->
                        <h3 class="text-lg font-medium mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2 italic">Order Tracking & Logistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="tracking_provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Tracking Provider</label>
                                <select name="tracking_provider" id="tracking_provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                                    <option value="shiprocket" {{ ($settings['tracking_provider'] ?? 'shiprocket') == 'shiprocket' ? 'selected' : '' }}>Shiprocket (Integrated)</option>
                                    <option value="manual" {{ ($settings['tracking_provider'] ?? '') == 'manual' ? 'selected' : '' }}>Manual (Custom Tracking Links)</option>
                                </select>
                            </div>
                            <div>
                                <label for="live_tracking_enabled" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Live Status Updates</label>
                                <select name="live_tracking_enabled" id="live_tracking_enabled" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                                    <option value="1" {{ ($settings['live_tracking_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Enabled (Auto-Sync via API)</option>
                                    <option value="0" {{ ($settings['live_tracking_enabled'] ?? '') == '0' ? 'selected' : '' }}>Disabled (Manual Status Updates)</option>
                                </select>
                            </div>
                            <div>
                                <label for="shiprocket_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shiprocket Email</label>
                                <input type="email" name="shiprocket_email" id="shiprocket_email" value="{{ $settings['shiprocket_email'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="shiprocket_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shiprocket Password</label>
                                <input type="password" name="shiprocket_password" id="shiprocket_password" value="{{ $settings['shiprocket_password'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="shiprocket_pickup_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shiprocket Pickup Location</label>
                                <input type="text" name="shiprocket_pickup_location" id="shiprocket_pickup_location" value="{{ $settings['shiprocket_pickup_location'] ?? 'Primary' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="shiprocket_pickup_pincode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Warehouse Pincode</label>
                                <input type="text" name="shiprocket_pickup_pincode" id="shiprocket_pickup_pincode" value="{{ $settings['shiprocket_pickup_pincode'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                            </div>
                        </div>

                        <!-- Social Media & Business -->
                        <h3 class="text-lg font-medium mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2">Business & Social Media</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp Number (with country code, e.g. 919876543210)</label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook URL</label>
                                <input type="url" name="facebook_url" id="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/yourpage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram URL</label>
                                <input type="url" name="instagram_url" id="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/yourprofile" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Twitter / X URL</label>
                                <input type="url" name="twitter_url" id="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/yourhandle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube URL</label>
                                <input type="url" name="youtube_url" id="youtube_url" value="{{ $settings['youtube_url'] ?? '' }}" placeholder="https://youtube.com/@yourchannel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                        </div>

                        <!-- SEO & Analytics -->
                        <h3 class="text-lg font-medium mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2">SEO & Analytics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="google_analytics_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Google Analytics ID (G-XXXXX)</label>
                                <input type="text" name="google_analytics_id" id="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="facebook_pixel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Legacy Facebook Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" id="facebook_pixel_id" value="{{ $settings['facebook_pixel_id'] ?? '' }}" placeholder="1234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="custom_pixels" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking Pixels (Meta, Google, etc.) - Paste full &lt;script&gt; tags here</label>
                                <textarea name="custom_pixels" id="custom_pixels" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono text-xs">{{ $settings['custom_pixels'] ?? '' }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="default_meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Meta Title</label>
                                <input type="text" name="default_meta_title" id="default_meta_title" value="{{ $settings['default_meta_title'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="default_meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Meta Description</label>
                                <textarea name="default_meta_description" id="default_meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ $settings['default_meta_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Razorpay API -->
                        <h3 class="text-lg font-medium mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2">Payment Gateway</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="razorpay_key_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razorpay Key ID</label>
                                <input type="text" name="razorpay_key_id" id="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="razorpay_key_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razorpay Key Secret</label>
                                <input type="password" name="razorpay_key_secret" id="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="hidden" name="is_cod_enabled" value="0">
                                <input type="checkbox" name="is_cod_enabled" id="is_cod_enabled" value="1" {{ ($settings['is_cod_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_cod_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">Enable Cash on Delivery (COD)</label>
                            </div>
                        </div>
                        
                        <!-- Email / SMTP Settings -->
                        <h3 class="text-lg font-medium mb-2 text-indigo-600 dark:text-indigo-400 border-b pb-2">Email / SMTP Settings</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">
                            Configure how outgoing emails (order confirmations, newsletters, etc.) are sent.
                            Your email provider will give you these details. Common providers: 
                            <strong>Gmail</strong> (smtp.gmail.com, port 587), 
                            <strong>Zoho</strong> (smtp.zoho.in, port 587),
                            <strong>Hostinger</strong> (smtp.hostinger.com, port 587).
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    SMTP Host
                                    <span class="text-xs text-gray-400 font-normal ml-1">— e.g. smtp.gmail.com</span>
                                </label>
                                <input type="text" name="mail_host" id="mail_host"
                                    value="{{ $settings['mail_host'] ?? '' }}"
                                    placeholder="smtp.gmail.com"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    SMTP Port
                                    <span class="text-xs text-gray-400 font-normal ml-1">— usually 587</span>
                                </label>
                                <input type="number" name="mail_port" id="mail_port"
                                    value="{{ $settings['mail_port'] ?? '587' }}"
                                    placeholder="587"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email Address (Username)
                                    <span class="text-xs text-gray-400 font-normal ml-1">— your sending email</span>
                                </label>
                                <input type="email" name="mail_username" id="mail_username"
                                    value="{{ $settings['mail_username'] ?? '' }}"
                                    placeholder="orders@avneecollections.com"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email Password / App Password
                                    <span class="text-xs text-gray-400 font-normal ml-1">— Gmail users: use App Password</span>
                                </label>
                                <input type="password" name="mail_password" id="mail_password"
                                    value="{{ $settings['mail_password'] ?? '' }}"
                                    placeholder="••••••••••••"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">⚠ For Gmail: Go to Google Account → Security → App Passwords and generate one.</p>
                            </div>
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    From Email Address
                                    <span class="text-xs text-gray-400 font-normal ml-1">— shown in recipient's inbox</span>
                                </label>
                                <input type="email" name="mail_from_address" id="mail_from_address"
                                    value="{{ $settings['mail_from_address'] ?? '' }}"
                                    placeholder="no-reply@avneecollections.com"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    From Name
                                    <span class="text-xs text-gray-400 font-normal ml-1">— shown in recipient's inbox</span>
                                </label>
                                <input type="text" name="mail_from_name" id="mail_from_name"
                                    value="{{ $settings['mail_from_name'] ?? '' }}"
                                    placeholder="AVNEE Collections"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Encryption
                                    <span class="text-xs text-gray-400 font-normal ml-1">— use "tls" for port 587, "ssl" for port 465</span>
                                </label>
                                <select name="mail_encryption" id="mail_encryption"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS (Recommended — Port 587)</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                                    <option value="" {{ ($settings['mail_encryption'] ?? '') === '' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                                <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">📋 Quick Provider Reference</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-blue-700 dark:text-blue-400">
                                    <div class="bg-white/50 dark:bg-white/5 p-2 rounded">
                                        <strong>Gmail</strong><br>
                                        Host: smtp.gmail.com<br>
                                        Port: 587 | TLS<br>
                                        <span class="text-amber-600">Use App Password!</span>
                                    </div>
                                    <div class="bg-white/50 dark:bg-white/5 p-2 rounded">
                                        <strong>Zoho Mail</strong><br>
                                        Host: smtp.zoho.in<br>
                                        Port: 587 | TLS
                                    </div>
                                    <div class="bg-white/50 dark:bg-white/5 p-2 rounded">
                                        <strong>Hostinger</strong><br>
                                        Host: smtp.hostinger.com<br>
                                        Port: 587 | TLS
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
