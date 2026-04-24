<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'reward', 'min_order_amount', 
        'max_discount', 'expiry_date', 'usage_limit', 
        'used_count', 'status'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Check if the coupon is valid.
     */
    public function isValid($totalAmount = 0)
    {
        if (!$this->status) return false;

        if ($this->expiry_date && $this->expiry_date->isPast()) return false;

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;

        if ($totalAmount < $this->min_order_amount) return false;

        return true;
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount($totalAmount)
    {
        if ($this->type === 'fixed') {
            return min($this->reward, $totalAmount);
        }

        if ($this->type === 'percent') {
            $discount = $totalAmount * ($this->reward / 100);
            return $this->max_discount ? min($discount, $this->max_discount) : $discount;
        }

        return 0; // free_shipping handled separately in shipping cost
    }
}
