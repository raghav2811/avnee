<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Setting;
use App\Models\Category;
use App\Models\PriceBand;
use App\Models\SareeEditSetting;
use App\Models\JewelleryExperienceSetting;
use App\Models\JustInExperience;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.front.*', 'welcome', 'jewellery'], function ($view) {
            if (request()->is('admin/*')) {
                return;
            }

            $cartCount = 0;
            $wishlistCount = 0;

            if (auth()->check()) {
                $cart = Cart::where('user_id', auth()->id())->first();
                $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
                $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
            } else {
                $sessionId = session()->getId();
                $cart = Cart::where('session_id', $sessionId)->first();
                $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
                $wishlistCount = Wishlist::where('session_id', $sessionId)->count();
            }

            // Determine brand context (1: Studio, 2: Jewellery)
            $brandId = session('brand_id', 1);

            $categories = Cache::remember("front:categories:{$brandId}", 300, function () use ($brandId) {
                return Category::where('is_active', true)
                    ->where('brand_id', $brandId)
                    ->where('show_in_site_header', true)
                    ->whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->with(['children' => function($q) {
                        $q->where('is_active', true)->orderBy('sort_order');
                    }, 'products' => function($q) {
                        $q->where('is_active', true)->latest()->take(4);
                    }])
                    ->get();
            });

            $priceBands = Cache::remember("front:price_bands:{$brandId}", 300, function () use ($brandId) {
                return PriceBand::where('brand_id', $brandId)
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            });

            $sareeEdit = Cache::remember('front:saree_edit', 300, function () {
                return SareeEditSetting::first();
            });

            $jewelleryExperience = Cache::remember('front:jewellery_experience', 300, function () {
                return JewelleryExperienceSetting::first();
            });

            $justInExperiences = Cache::remember("front:just_in_experiences:{$brandId}", 300, function () use ($brandId) {
                return JustInExperience::where('brand_id', $brandId)
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            });

            $settings = Cache::remember('settings:all', 300, function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            $view->with('cartCount', $cartCount);
            $view->with('wishlistCount', $wishlistCount);
            $view->with('settings', $settings);
            $view->with('categories', $categories);
            $view->with('priceBands', $priceBands);
            $view->with('sareeEdit', $sareeEdit);
            $view->with('jewelleryExperience', $jewelleryExperience);
            $view->with('justInExperiences', $justInExperiences);
        });
    }
}
