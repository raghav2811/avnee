<?php

use App\Http\Controllers\Api\ShiprocketController;
use App\Http\Controllers\Api\ShiprocketWebhookController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\AuthController as FrontAuthController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Front storefront routes
Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/sale', [HomeController::class, 'sale'])->name('front.sale');
Route::get('/jewellery', [HomeController::class, 'jewellery'])->name('front.jewellery');
Route::get('/jewellery/collections/{slug}', [HomeController::class, 'jewelleryCollection'])->name('front.jewellery.collection.show');

// Front auth
Route::get('/login', [FrontAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontAuthController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('login.submit');
Route::get('/register', [FrontAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [FrontAuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.submit');
Route::post('/logout', [FrontAuthController::class, 'logout'])->name('logout');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('front.products.index');
Route::get('/best-buys', [HomeController::class, 'bestBuys'])->name('front.best-buys');
Route::get('/best-buys/{slug}', [HomeController::class, 'bestBuysShow'])->name('front.best-buys.show');
Route::get('/collections/{collection}', [ProductController::class, 'collection'])
    ->whereIn('collection', [
        'sale', 'new-arrivals', 'best-sellers', 'bogo', 'organizers', 'gifting',
        'all-collections', 'party-frocks', 'summer-collections', 'festive-wear', 'daily-wear',
        'all-sarees', 'printed-cotton', 'georgette', 'semi-silk', 'daily-wear-sarees', 'cotton-sarees',
        'hand-made', 'oxidised', 'cultural',
    ])
    ->name('front.products.collection');

// Kids sections with Studio >> Kids >> [Section Name] navigation
Route::get('/kids/{section}', [ProductController::class, 'kidsSection'])
    ->whereIn('section', ['all-girls', 'party-frocks', 'dailywear', 'festive-wear'])
    ->name('front.kids.section');

// Sarees sections with Studio >> Women >> Sarees >> [Category Name] navigation
Route::get('/women/sarees/all-sarees', [ProductController::class, 'sareesSection'])->name('front.women.sarees.all-sarees');
Route::get('/women/sarees/daily-wear-sarees', [ProductController::class, 'sareesSection'])->name('front.women.sarees.daily-wear-sarees');
Route::get('/women/sarees/semi-silk-sarees', [ProductController::class, 'sareesSection'])->name('front.women.sarees.semi-silk-sarees');
Route::get('/women/sarees/cotton-sarees', [ProductController::class, 'sareesSection'])->name('front.women.sarees.cotton-sarees');
Route::get('/women/sarees/georgette-sarees', [ProductController::class, 'sareesSection'])->name('front.women.sarees.georgette-sarees');

// Filter pages for Fabric, Occasion, and Color
Route::get('/collections/fabric/{fabric}', [ProductController::class, 'fabricFilter'])->name('front.products.fabric');
Route::get('/collections/occasion/{occasion}', [ProductController::class, 'occasionFilter'])->name('front.products.occasion');
Route::get('/collections/color/{color}', [ProductController::class, 'colorFilter'])->name('front.products.color');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('front.product.detail');
Route::get('/gallery/party-frocks/{product}', [ProductController::class, 'showPartyFrockDetail'])->name('front.gallery.party-frock.detail');
Route::get('/gallery/collection/{category}/{product}', [ProductController::class, 'showCollectionGalleryDetail'])->name('front.gallery.collection.detail');
Route::post('/product/{slug}/review', [ProductController::class, 'storeReview'])->middleware('auth')->name('front.product.review');
Route::get('/search', [ProductController::class, 'search'])->name('front.products.search');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('front.cart.index');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('front.cart.summary');
Route::get('/media/storage/{path}', [CartController::class, 'storageMedia'])->where('path', '.*')->name('front.media.storage');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/combo/{id}', [CartController::class, 'addCombo'])->name('cart.add.combo');
Route::get('/cart/combo/{id}/details', [CartController::class, 'getComboDetails'])->name('front.cart.combo.details');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('front.cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('front.cart.remove');

// Wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('front.wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('front.wishlist.toggle');
Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('front.wishlist.remove');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('front.wishlist.move-to-cart');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->middleware(['auth', 'active.customer'])->name('front.checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->middleware(['auth', 'active.customer'])->name('front.checkout.process');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->middleware(['auth', 'active.customer'])->name('front.checkout.success');
Route::post('/checkout/razorpay-verify', [CheckoutController::class, 'razorpayVerify'])->middleware(['auth', 'active.customer'])->name('front.checkout.razorpay.verify');
Route::post('/checkout/coupon/apply', [CheckoutController::class, 'applyCoupon'])->middleware(['auth', 'active.customer'])->name('front.checkout.coupon.apply');
Route::post('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->middleware(['auth', 'active.customer'])->name('front.checkout.coupon.remove');
Route::get('/checkout/shipping-details', [ShiprocketController::class, 'getShippingDetails'])->middleware(['auth', 'active.customer'])->name('front.checkout.shipping-details');
Route::post('/webhooks/shiprocket', [ShiprocketWebhookController::class, 'handle'])->name('front.webhooks.shiprocket');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('front.newsletter.subscribe');
Route::get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('front.newsletter.unsubscribe');

// User account
Route::middleware(['auth', 'active.customer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-orders', [AccountController::class, 'orders'])->name('front.orders.index');
    Route::get('/my-orders/{orderNumber}', [AccountController::class, 'showOrder'])->name('front.orders.show');
    Route::post('/my-orders/{orderNumber}/return', [AccountController::class, 'requestReturn'])->name('front.orders.return');
});

// Blog and CMS pages
Route::get('/blog', [BlogController::class, 'index'])->name('front.blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('front.blog.show');
Route::get('/p/{slug}', [PageController::class, 'show'])->name('front.page');
Route::get('/concierge', [ContactController::class, 'index'])->name('front.contact');
Route::post('/concierge', [ContactController::class, 'store'])->name('front.contact.submit');
Route::get('/careers', [ContactController::class, 'careers'])->name('front.careers');
Route::get('/track-order', [AccountController::class, 'trackOrder'])->name('front.track_order');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('front.sitemap');

// Payment routes
Route::get('/payment/{slug}', [PaymentController::class, 'showPaymentPage'])->name('payment.checkout');
Route::post('/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create.order');
Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
Route::get('/payment/success/{order_id}', [PaymentController::class, 'showSuccessPage'])->name('payment.success.page');
Route::get('/orders', [PaymentController::class, 'orderHistory'])->name('payment.order.history');
