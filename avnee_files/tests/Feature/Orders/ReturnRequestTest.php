<?php

namespace Tests\Feature\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReturnRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_request_return_for_delivered_paid_order(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user, [
            'status' => 'delivered',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($user)->post(route('front.orders.return', $order->order_number), [
            'reason' => 'Product did not fit as expected.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'return_status' => 'requested',
            'return_reason' => 'Product did not fit as expected.',
        ]);
    }

    public function test_customer_cannot_request_return_for_non_delivered_order(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user, [
            'status' => 'processing',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($user)->post(route('front.orders.return', $order->order_number), [
            'reason' => 'Need to return.',
        ]);

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'return_status' => null,
        ]);
    }

    public function test_customer_cannot_request_return_after_window_expires(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user, [
            'status' => 'delivered',
            'payment_status' => 'paid',
        ]);

        $this->travel(15)->days();

        $response = $this->actingAs($user)->post(route('front.orders.return', $order->order_number), [
            'reason' => 'Late return request.',
        ]);

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'return_status' => null,
        ]);
    }

    private function createOrder(User $user, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => $user->id,
            'session_id' => null,
            'status' => 'pending',
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
            'subtotal' => 1000,
            'discount_amount' => 0,
            'shipping_cost' => 0,
            'total_amount' => 1000,
            'shipping_address' => [
                'first_name' => 'Test',
                'last_name' => 'User',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'billing_address' => [
                'first_name' => 'Test',
                'last_name' => 'User',
                'address' => 'Line 1',
                'city' => 'Bangalore',
                'state' => 'KA',
                'pincode' => '560001',
                'country' => 'India',
            ],
            'customer_email' => $user->email,
            'customer_phone' => '9999999999',
        ], $overrides));
    }
}
