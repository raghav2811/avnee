<?php

namespace Tests\Feature\Orders;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_track_order_with_order_number_and_customer_email(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => null,
            'session_id' => 'session-test',
            'status' => 'processing',
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
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

        $response = $this->get(route('front.track_order', [
            'order_number' => $order->order_number,
            'email' => 'guest@example.com',
        ]));

        $response->assertOk();
        $response->assertViewHas('order', function ($viewOrder) use ($order) {
            return $viewOrder && $viewOrder->id === $order->id;
        });
    }

    public function test_guest_track_order_fails_with_wrong_email(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => null,
            'session_id' => 'session-test',
            'status' => 'processing',
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
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

        $response = $this->get(route('front.track_order', [
            'order_number' => $order->order_number,
            'email' => 'wrong@example.com',
        ]));

        $response->assertRedirect(route('front.track_order', [], false));
    }
}
