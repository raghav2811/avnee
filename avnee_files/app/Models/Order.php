<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'status',
        'payment_method',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'tracking_number',
        'expected_delivery_date',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'shipping_cost',
        'total_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'pincode',
        'notes',
        'amount',
        'currency',
        'paid_at'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'coupon_code' => 'string',
        'return_requested_at' => 'datetime',
        'return_completed_at' => 'datetime',
        'expected_delivery_date' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot(['quantity', 'price', 'total', 'variant_id']);
    }
}
