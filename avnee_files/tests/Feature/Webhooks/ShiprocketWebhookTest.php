<?php

namespace Tests\Feature\Webhooks;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiprocketWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_shiprocket_webhook_rejects_invalid_signature(): void
    {
        Setting::updateOrCreate(
            ['key' => 'shiprocket_webhook_secret'],
            ['value' => 'test-secret']
        );

        $payload = [
            'order_id' => 'SR-1001',
            'current_status' => 'delivered',
            'awb' => 'AWB-1001',
        ];

        $response = $this->postJson(route('front.webhooks.shiprocket'), $payload, [
            'x-shiprocket-signature' => 'invalid-signature',
        ]);

        $response->assertStatus(401);
    }

    public function test_shiprocket_webhook_updates_order_status_with_valid_signature(): void
    {
        Setting::updateOrCreate(
            ['key' => 'shiprocket_webhook_secret'],
            ['value' => 'test-secret']
        );

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => null,
            'session_id' => 'session-test',
            'status' => 'processing',
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
            'shiprocket_order_id' => 'SR-2001',
            'subtotal' => 1000,
            'discount_amount' => 0,
            'shipping_cost' => 0,
            'total_amount' => 1000,
            'shipping_address' => [
                'first_name' => 'Guest',
                'last_name' => 'Buyer',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'billing_address' => [
                'first_name' => 'Guest',
                'last_name' => 'Buyer',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'customer_email' => 'guest@example.com',
            'customer_phone' => '9999999999',
        ]);

        $payload = [
            'order_id' => 'SR-2001',
            'current_status' => 'delivered',
            'awb' => 'AWB-2001',
        ];

        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $secret = (string) Setting::where('key', 'shiprocket_webhook_secret')->value('value');
        $signature = hash_hmac('sha256', $jsonPayload, $secret);

        $response = $this->call(
            'POST',
            route('front.webhooks.shiprocket'),
            [],
            [],
            [],
            ['HTTP_X_SHIPROCKET_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'],
            $jsonPayload
        );

        $response->assertOk();

        $order->refresh();
        $this->assertSame('delivered', $order->status);
        $this->assertSame('AWB-2001', $order->tracking_number);
    }

    public function test_shiprocket_webhook_returns_bad_request_when_order_id_missing(): void
    {
        Setting::updateOrCreate(
            ['key' => 'shiprocket_webhook_secret'],
            ['value' => 'test-secret']
        );

        $payload = [
            'current_status' => 'delivered',
            'awb' => 'AWB-3001',
        ];

        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $secret = (string) Setting::where('key', 'shiprocket_webhook_secret')->value('value');
        $signature = hash_hmac('sha256', $jsonPayload, $secret);

        $response = $this->call(
            'POST',
            route('front.webhooks.shiprocket'),
            [],
            [],
            [],
            ['HTTP_X_SHIPROCKET_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'],
            $jsonPayload
        );

        $response->assertStatus(400);
    }

    public function test_shiprocket_webhook_returns_not_found_for_unknown_order_id(): void
    {
        Setting::updateOrCreate(
            ['key' => 'shiprocket_webhook_secret'],
            ['value' => 'test-secret']
        );

        $payload = [
            'order_id' => 'SR-UNKNOWN',
            'current_status' => 'in transit',
            'awb' => 'AWB-4001',
        ];

        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $secret = (string) Setting::where('key', 'shiprocket_webhook_secret')->value('value');
        $signature = hash_hmac('sha256', $jsonPayload, $secret);

        $response = $this->call(
            'POST',
            route('front.webhooks.shiprocket'),
            [],
            [],
            [],
            ['HTTP_X_SHIPROCKET_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'],
            $jsonPayload
        );

        $response->assertStatus(404);
    }

    public function test_shiprocket_webhook_duplicate_event_is_suppressed(): void
    {
        Setting::updateOrCreate(
            ['key' => 'shiprocket_webhook_secret'],
            ['value' => 'test-secret']
        );

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => null,
            'session_id' => 'session-test',
            'status' => 'processing',
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
            'shiprocket_order_id' => 'SR-DEDUPE-1',
            'subtotal' => 1000,
            'discount_amount' => 0,
            'shipping_cost' => 0,
            'total_amount' => 1000,
            'shipping_address' => [
                'first_name' => 'Guest',
                'last_name' => 'Buyer',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'billing_address' => [
                'first_name' => 'Guest',
                'last_name' => 'Buyer',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'customer_email' => 'guest@example.com',
            'customer_phone' => '9999999999',
        ]);

        $payload = [
            'event_id' => 'evt-001',
            'order_id' => 'SR-DEDUPE-1',
            'current_status' => 'in transit',
            'awb' => 'AWB-DEDUPE-1',
        ];

        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $secret = (string) Setting::where('key', 'shiprocket_webhook_secret')->value('value');
        $signature = hash_hmac('sha256', $jsonPayload, $secret);

        $firstResponse = $this->call(
            'POST',
            route('front.webhooks.shiprocket'),
            [],
            [],
            [],
            ['HTTP_X_SHIPROCKET_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'],
            $jsonPayload
        );

        $firstResponse->assertOk();

        $secondResponse = $this->call(
            'POST',
            route('front.webhooks.shiprocket'),
            [],
            [],
            [],
            ['HTTP_X_SHIPROCKET_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'],
            $jsonPayload
        );

        $secondResponse->assertOk();
        $secondResponse->assertJson(['success' => true, 'duplicate' => true]);

        $order->refresh();
        $this->assertSame('shipped', $order->status);
        $this->assertSame('AWB-DEDUPE-1', $order->tracking_number);
    }
}
