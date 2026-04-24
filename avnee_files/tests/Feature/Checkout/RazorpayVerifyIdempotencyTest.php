<?php

namespace Tests\Feature\Checkout;

use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RazorpayVerifyIdempotencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_razorpay_verify_replay_with_same_payment_id_is_idempotent(): void
    {
        $secret = 'test_secret_key';
        Setting::updateOrCreate(['key' => 'razorpay_key_id'], ['value' => 'rzp_test_key']);
        Setting::updateOrCreate(['key' => 'razorpay_key_secret'], ['value' => $secret]);

        $user = User::factory()->create();
        $order = $this->createRazorpayOrder($user->id, 'order_test_123');

        $firstPaymentId = 'pay_test_111';
        $firstSignature = hash_hmac('sha256', 'order_test_123|' . $firstPaymentId, $secret);

        $firstResponse = $this->actingAs($user)->postJson(route('front.checkout.razorpay.verify'), [
            'razorpay_signature' => $firstSignature,
            'razorpay_payment_id' => $firstPaymentId,
            'razorpay_order_id' => 'order_test_123',
            'order_number' => $order->order_number,
        ]);

        $firstResponse->assertOk()->assertJson(['success' => true]);

        $secondResponse = $this->actingAs($user)->postJson(route('front.checkout.razorpay.verify'), [
            'razorpay_signature' => $firstSignature,
            'razorpay_payment_id' => $firstPaymentId,
            'razorpay_order_id' => 'order_test_123',
            'order_number' => $order->order_number,
        ]);

        $secondResponse->assertOk()->assertJson(['success' => true]);

        $order->refresh();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame($firstPaymentId, $order->razorpay_payment_id);
    }

    public function test_razorpay_verify_replay_with_different_payment_id_is_rejected(): void
    {
        $secret = 'test_secret_key';
        Setting::updateOrCreate(['key' => 'razorpay_key_id'], ['value' => 'rzp_test_key']);
        Setting::updateOrCreate(['key' => 'razorpay_key_secret'], ['value' => $secret]);

        $user = User::factory()->create();
        $order = $this->createRazorpayOrder($user->id, 'order_test_456');

        $initialPaymentId = 'pay_test_222';
        $initialSignature = hash_hmac('sha256', 'order_test_456|' . $initialPaymentId, $secret);

        $this->actingAs($user)->postJson(route('front.checkout.razorpay.verify'), [
            'razorpay_signature' => $initialSignature,
            'razorpay_payment_id' => $initialPaymentId,
            'razorpay_order_id' => 'order_test_456',
            'order_number' => $order->order_number,
        ])->assertOk();

        $differentPaymentId = 'pay_test_333';
        $differentSignature = hash_hmac('sha256', 'order_test_456|' . $differentPaymentId, $secret);

        $duplicateResponse = $this->actingAs($user)->postJson(route('front.checkout.razorpay.verify'), [
            'razorpay_signature' => $differentSignature,
            'razorpay_payment_id' => $differentPaymentId,
            'razorpay_order_id' => 'order_test_456',
            'order_number' => $order->order_number,
        ]);

        $duplicateResponse->assertStatus(409);
    }

    private function createRazorpayOrder(int $userId, string $razorpayOrderId): Order
    {
        return Order::create([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => $userId,
            'session_id' => null,
            'status' => 'pending',
            'payment_method' => 'razorpay',
            'payment_status' => 'unpaid',
            'razorpay_order_id' => $razorpayOrderId,
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
            'customer_email' => 'customer@example.com',
            'customer_phone' => '9999999999',
        ]);
    }
}
