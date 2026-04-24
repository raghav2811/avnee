<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_settings_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.settings.index'));

        $response->assertOk();
    }

    public function test_staff_cannot_access_settings_page_without_permission(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
        ]);

        $response = $this->actingAs($staff, 'admin')->get(route('admin.settings.index'));

        $response->assertForbidden();
    }

    public function test_staff_can_access_reports_page_with_permission(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
        ]);

        $response = $this->actingAs($staff, 'admin')->get(route('admin.reports.index'));

        $response->assertOk();
    }

    public function test_staff_permission_matrix_for_admin_resource_groups(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
        ]);

        $matrix = [
            'admin.dashboard' => 200,
            'admin.products.index' => 200,
            'admin.categories.index' => 200,
            'admin.banners.index' => 200,
            'admin.coupons.index' => 200,
            'admin.flash-sales.index' => 200,
            'admin.combos.index' => 200,
            'admin.customers.index' => 200,
            'admin.orders.index' => 200,
            'admin.reviews.index' => 200,
            'admin.blog-categories.index' => 200,
            'admin.blog-posts.index' => 200,
            'admin.pages.index' => 200,
            'admin.home-sections.index' => 200,
            'admin.price-bands.index' => 200,
            'admin.home-styles.index' => 200,
            'admin.brand-experiences.index' => 200,
            'admin.just-in-experiences.index' => 200,
            'admin.home-explore-grids.index' => 200,
            'admin.contact-messages.index' => 200,
            'admin.newsletter.index' => 200,
            'admin.reports.index' => 200,
            'admin.settings.index' => 403,
        ];

        foreach ($matrix as $routeName => $expectedStatus) {
            $response = $this->actingAs($staff, 'admin')->get(route($routeName));
            $response->assertStatus($expectedStatus);
        }
    }

    public function test_admin_cannot_complete_return_without_approval_first(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = $this->createOrder([
            'return_status' => 'requested',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($admin, 'admin')->post(route('admin.orders.return-status', $order), [
            'return_status' => 'completed',
            'refund_amount' => 500,
            'return_notes' => 'Trying direct completion',
        ]);

        $response->assertSessionHas('error');

        $order->refresh();
        $this->assertSame('requested', $order->return_status);
        $this->assertSame('paid', $order->payment_status);
    }

    public function test_admin_can_approve_then_complete_return_and_mark_refunded(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = $this->createOrder([
            'return_status' => 'requested',
            'payment_status' => 'paid',
        ]);

        $approveResponse = $this->actingAs($admin, 'admin')->post(route('admin.orders.return-status', $order), [
            'return_status' => 'approved',
            'return_notes' => 'Approved after inspection',
        ]);

        $approveResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertSame('approved', $order->return_status);

        $completeResponse = $this->actingAs($admin, 'admin')->post(route('admin.orders.return-status', $order), [
            'return_status' => 'completed',
            'refund_amount' => 500,
            'return_notes' => 'Refund processed',
        ]);

        $completeResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertSame('completed', $order->return_status);
        $this->assertSame('refunded', $order->payment_status);
        $this->assertNotNull($order->return_completed_at);
    }

    private function createOrder(array $overrides = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'ORD-' . strtoupper(bin2hex(random_bytes(5))),
            'user_id' => null,
            'session_id' => 'session-test',
            'status' => 'delivered',
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
        ], $overrides));
    }
}
