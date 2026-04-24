<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'brand_id', 'category_id', 'subcategory_id', 'name', 'slug', 'image', 'video', 'description',
        'care_instructions', 'weight_grams', 'is_featured', 'is_active',
        'meta_title', 'meta_description',
        'is_returnable',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    protected $appends = ['is_wishlisted', 'price', 'compare_price', 'discount'];

    public function getNameAttribute($value)
    {
        $name = (string) $value;
        $slug = (string) ($this->attributes['slug'] ?? '');
        $normalized = Str::of($name)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', ' ')
            ->trim()
            ->value();

        $canonicalNames = [
            'classic peach layered frock' => 'Classic Peach Layered Frock',
            'ethnic charm festive dress' => 'Ethnic Charm Festive Dress',
            'floral garden party dress' => 'Floral Garden Party Dress',
            'casual chic denim set' => 'Casual Chic Denim Set',
            'shimmer silver party dress' => 'Shimmer Silver Party Dress',
            'glam black sequin dress' => 'Glam Black Sequin Dress',
            'twinkle pink party dress' => 'Twinkle Pink Party Dress',
            'blush bloom ethnic set' => 'Blush Bloom Ethnic Set',
        ];

        foreach ($canonicalNames as $needle => $canonical) {
            if (Str::contains($normalized, $needle) || Str::contains($slug, Str::slug($needle))) {
                return $canonical;
            }
        }

        return $name;
    }

    public function getPriceAttribute()
    {
        $basePrice = $this->variants->first()?->price ?? 0;

        // Check for active flash sale
        $flashSale = $this->currentlyActiveFlashSale();
        if ($flashSale) {
            $discountPct = $flashSale->pivot->discount_percentage ?? 0;
            $discountAmt = $flashSale->pivot->discount_amount ?? 0;

            if ($discountPct > 0) {
                $basePrice = $basePrice - ($basePrice * ($discountPct / 100));
            } elseif ($discountAmt > 0) {
                $basePrice = $basePrice - $discountAmt;
            }
        }

        return max(0, $basePrice);
    }

    public function getComparePriceAttribute()
    {
        return $this->variants->first()?->compare_price ?? 0;
    }

    public function getDiscountAttribute()
    {
        $price = $this->price; // This already includes flash sale discount if active
        $comparePrice = $this->compare_price;

        if ($comparePrice > $price) {
            return round((($comparePrice - $price) / $comparePrice) * 100);
        }

        return 0;
    }

    public function getIsWishlistedAttribute()
    {
        if (auth()->check()) {
            return \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $this->id)->exists();
        }

        return \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $this->id)->exists();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_products')
                    ->withPivot('discount_amount', 'discount_percentage', 'sort_order')
                    ->withTimestamps();
    }

    public function currentlyActiveFlashSale()
    {
        return $this->flashSales()
                    ->where('is_active', true)
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->orderBy('sort_order', 'asc')
                    ->first();
    }

    public function combos()
    {
        return $this->belongsToMany(Combo::class, 'combo_products')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
