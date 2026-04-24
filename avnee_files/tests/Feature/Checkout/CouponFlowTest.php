<?php

namespace Tests\Feature\Checkout;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_coupon_can_be_applied_when_valid(): void
    {
        Coupon::create([
            'code' => 'SAVE100',
            'type' => 'fixed',
            'reward' => 100,
            'min_order_amount' => 0,
            'max_discount' => null,
            'expiry_date' => now()->addDay(),
            'usage_limit' => 10,
            'used_count' => 0,
            'status' => true,
        ]);

        $response = $this->withSession(['_token' => 'test-token'])
            ->post(route('front.checkout.coupon.apply'), [
                'code' => 'SAVE100',
            ]);

        $response->assertSessionHas('success');
        $response->assertSessionHas('applied_coupon', 'SAVE100');
    }

    public function test_checkout_coupon_apply_fails_when_min_order_not_met(): void
    {
        Coupon::create([
            'code' => 'BIGSAVE',
            'type' => 'fixed',
            'reward' => 100,
            'min_order_amount' => 1000,
            'max_discount' => null,
            'expiry_date' => now()->addDay(),
            'usage_limit' => 10,
            'used_count' => 0,
            'status' => true,
        ]);

        $response = $this->withSession(['_token' => 'test-token'])
            ->post(route('front.checkout.coupon.apply'), [
                'code' => 'BIGSAVE',
            ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('applied_coupon'));
    }

    public function test_checkout_coupon_can_be_removed_from_session(): void
    {
        $response = $this->withSession([
            '_token' => 'test-token',
            'applied_coupon' => 'SAVE100',
            'coupon_discount' => 100,
        ])->post(route('front.checkout.coupon.remove'));

        $response->assertSessionHas('success');
        $this->assertNull(session('applied_coupon'));
        $this->assertNull(session('coupon_discount'));
    }

    public function test_checkout_process_is_idempotent_for_same_key(): void
    {
        Setting::updateOrCreate(
            ['key' => 'is_cod_enabled'],
            ['value' => '1']
        );

        $user = User::factory()->create();
        $brand = Brand::create([
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'is_active' => true,
        ]);

        $category = Category::create([
            'brand_id' => $brand->id,
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'is_active' => true,
        ]);

        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'variant_id' => null,
            'quantity' => 1,
            'price' => 499,
        ]);

        $payload = [
            'email' => $user->email,
            'phone' => '9999999999',
            'first_name' => 'Test',
            'last_name' => 'User',
            'address' => 'Line 1',
            'city' => 'Bangalore',
            'state' => 'KA',
            'pincode' => '560001',
            'payment_method' => 'cod',
        ];

        $firstResponse = $this->actingAs($user)
            ->withHeader('X-Idempotency-Key', 'idem-abc-123')
            ->postJson(route('front.checkout.process'), $payload);

        $firstResponse->assertOk()->assertJson([
            'success' => true,
            'payment_needed' => false,
        ]);

        $this->assertDatabaseCount('orders', 1);
        $firstOrderNumber = $firstResponse->json('redirect_url');

        $secondResponse = $this->actingAs($user)
            ->withHeader('X-Idempotency-Key', 'idem-abc-123')
            ->postJson(route('front.checkout.process'), $payload);

        $secondResponse->assertOk()->assertJson([
            'success' => true,
            'payment_needed' => false,
        ]);

        $this->assertDatabaseCount('orders', 1);
        $this->assertSame($firstOrderNumber, $secondResponse->json('redirect_url'));
    }
}
