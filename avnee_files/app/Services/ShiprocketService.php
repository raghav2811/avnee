<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class ShiprocketService
{
    protected $baseUrl = 'https://apiv2.shiprocket.in/v1/external';
    protected $token;

    public function __construct()
    {
        $this->token = $this->getToken();
    }

    /**
     * Get Authentication Token
     */
    public function getToken(bool $forceRefresh = false)
    {
        $settings = Setting::whereIn('key', ['shiprocket_email', 'shiprocket_password', 'shiprocket_token'])->pluck('value', 'key');

        // Return existing token if likely valid (simplified for now, ideally check expiry)
        if (!$forceRefresh && !empty($settings['shiprocket_token'])) {
            return $settings['shiprocket_token'];
        }

        if (empty($settings['shiprocket_email']) || empty($settings['shiprocket_password'])) {
            return null;
        }

        try {
            $response = Http::post($this->baseUrl . '/auth/login', [
                'email' => $settings['shiprocket_email'],
                'password' => $settings['shiprocket_password'],
            ]);

            if ($response->successful()) {
                $token = $response->json()['token'];
                Setting::updateOrCreate(['key' => 'shiprocket_token'], ['value' => $token]);
                return $token;
            }
        } catch (\Exception $e) {
            Log::error('Shiprocket Login Failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Check Serviceability and get rates
     */
    public function checkServiceability($pincode, $weight = 0.5, $subtotal = 1000)
    {
        if (!$this->token) return null;

        $pickupPincode = Setting::where('key', 'shiprocket_pickup_pincode')->value('value') ?? '110001';
        try {
            $response = Http::timeout(20)->withToken($this->token)->get($this->baseUrl . '/courier/serviceability/', [
                'pickup_postcode' => $pickupPincode,
                'delivery_postcode' => $pincode,
                'cod' => 1,
                'weight' => $weight,
            ]);

            // Token may be expired even if saved in settings; refresh and retry once.
            if (in_array($response->status(), [401, 403], true)) {
                $this->token = $this->getToken(true);

                if ($this->token) {
                    $response = Http::timeout(20)->withToken($this->token)->get($this->baseUrl . '/courier/serviceability/', [
                        'pickup_postcode' => $pickupPincode,
                        'delivery_postcode' => $pincode,
                        'cod' => 1,
                        'weight' => $weight,
                    ]);
                }
            }

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Shiprocket serviceability non-success response', [
                'status' => $response->status(),
                'pickup_pincode' => $pickupPincode,
                'delivery_pincode' => $pincode,
            ]);
        } catch (\Exception $e) {
            Log::error('Shiprocket Serviceability Check Failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Create Order in Shiprocket
     */
    public function createOrder($order)
    {
        if (!$this->token) return null;

        $shippingAddress = is_array($order->shipping_address) ? $order->shipping_address : json_decode($order->shipping_address, true);

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->product_name,
                'sku' => $item->product_id, // Ideally use a real SKU
                'units' => $item->quantity,
                'selling_price' => $item->price,
            ];
        }

        $payload = [
            'order_id' => $order->order_number,
            'order_date' => $order->created_at->format('Y-m-d H:i'),
            'pickup_location' => Setting::where('key', 'shiprocket_pickup_location')->value('value') ?? 'Primary',
            'billing_customer_name' => $shippingAddress['first_name'],
            'billing_last_name' => $shippingAddress['last_name'],
            'billing_address' => $shippingAddress['address'],
            'billing_city' => $shippingAddress['city'],
            'billing_pincode' => $shippingAddress['pincode'],
            'billing_state' => $shippingAddress['state'],
            'billing_country' => 'India',
            'billing_email' => $order->customer_email,
            'billing_phone' => $order->customer_phone,
            'shipping_is_billing' => true,
            'order_items' => $items,
            'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
            'sub_total' => $order->subtotal,
            'length' => 10, // Default dimensions
            'width' => 10,
            'height' => 10,
            'weight' => 0.5
        ];

        try {
            $response = Http::withToken($this->token)->post($this->baseUrl . '/orders/create/adhoc', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $order->update([
                    'shiprocket_order_id' => $data['order_id'],
                    'shiprocket_shipment_id' => $data['shipment_id'] ?? null
                ]);
                return $data;
            }
        } catch (\Exception $e) {
            Log::error('Shiprocket Order Creation Failed: ' . $e->getMessage());
        }

        return null;
    }
}
