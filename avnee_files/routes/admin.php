<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComboController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return auth()->guard('admin')->check()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.login');
    })->name('admin.home');

    // Admin guest auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('admin.login.submit');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('admin.register.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin protected routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('admin.permission:dashboard.view')
            ->name('admin.dashboard');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])
            ->middleware('admin.permission:settings.manage')
            ->name('admin.settings.index');
        Route::get('/setting', function () {
            return redirect()->route('admin.settings.index');
        })->middleware('admin.permission:settings.manage')->name('admin.setting.index');
        Route::post('/settings', [SettingController::class, 'update'])
            ->middleware('admin.permission:settings.manage')
            ->name('admin.settings.update');

        // Resources
        Route::resource('products', AdminProductController::class)
            ->middleware('admin.permission:products.manage')
            ->names('admin.products');
        Route::resource('categories', CategoryController::class)
            ->middleware('admin.permission:categories.manage')
            ->names('admin.categories');
        Route::resource('banners', BannerController::class)
            ->middleware('admin.permission:banners.manage')
            ->names('admin.banners');
        Route::resource('coupons', CouponController::class)
            ->middleware('admin.permission:coupons.manage')
            ->names('admin.coupons');
        Route::resource('flash-sales', FlashSaleController::class)
            ->middleware('admin.permission:flash_sales.manage')
            ->names('admin.flash-sales');
        Route::resource('combos', ComboController::class)
            ->middleware('admin.permission:combos.manage')
            ->names('admin.combos');
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)
            ->middleware('admin.permission:customers.manage')
            ->names('admin.customers');
        Route::post('customers/{user}/toggle-block', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleBlock'])
            ->middleware('admin.permission:customers.manage')
            ->name('admin.customers.toggle-block');

        // Orders
        Route::get('orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])
            ->middleware('admin.permission:orders.view')
            ->name('admin.orders.invoice');
        Route::post('orders/{order}/return-status', [OrderController::class, 'updateReturnStatus'])
            ->middleware('admin.permission:orders.manage')
            ->name('admin.orders.return-status');
        Route::resource('orders', OrderController::class)
            ->middleware('admin.permission:orders.manage')
            ->names('admin.orders')
            ->only(['index', 'show', 'update']);

        // Reviews
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])
            ->middleware('admin.permission:reviews.manage')
            ->name('admin.reviews.reply');
        Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])
            ->middleware('admin.permission:reviews.manage')
            ->name('admin.reviews.approve');
        Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])
            ->middleware('admin.permission:reviews.manage')
            ->name('admin.reviews.reject');
        Route::resource('reviews', ReviewController::class)
            ->middleware('admin.permission:reviews.manage')
            ->names('admin.reviews')
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Blog CMS
        Route::resource('blog-categories', BlogCategoryController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.blog-categories');
        Route::resource('blog-posts', BlogPostController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.blog-posts');

        // Static pages CMS
        Route::resource('pages', AdminPageController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.pages');

        // Home experience resources
        Route::resource('home-sections', \App\Http\Controllers\Admin\HomeSectionController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.home-sections');
        Route::resource('price-bands', \App\Http\Controllers\Admin\PriceBandController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.price-bands');
        Route::resource('home-styles', \App\Http\Controllers\Admin\HomeStyleController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.home-styles');
        Route::get('experiences', function () {
            return redirect()->route('admin.brand-experiences.index');
        })->middleware('admin.permission:content.manage')->name('admin.experiences.index');

        Route::get('homepage-sections-editor', function () {
            return redirect()->route('admin.brand-experiences.index');
        })->middleware('admin.permission:content.manage')->name('admin.homepage-sections-editor');

        Route::resource('brand-experiences', \App\Http\Controllers\Admin\BrandExperienceController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.brand-experiences');
        Route::resource('just-in-experiences', \App\Http\Controllers\Admin\JustInExperienceController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.just-in-experiences');
        Route::resource('home-explore-grids', \App\Http\Controllers\Admin\HomeExploreGridController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.home-explore-grids');
        Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class)
            ->middleware('admin.permission:content.manage')
            ->names('admin.contact-messages')
            ->only(['index', 'show', 'destroy']);

        // Newsletter
        Route::get('newsletter', [AdminNewsletterController::class, 'index'])
            ->middleware('admin.permission:newsletter.view')
            ->name('admin.newsletter.index');
        Route::post('newsletter/send', [AdminNewsletterController::class, 'send'])
            ->middleware('admin.permission:newsletter.manage')
            ->name('admin.newsletter.send');
        Route::delete('newsletter/{subscriber}', [AdminNewsletterController::class, 'destroy'])
            ->middleware('admin.permission:newsletter.manage')
            ->name('admin.newsletter.destroy');

        // Reporting engine
        Route::get('reports', [ReportController::class, 'index'])
            ->middleware('admin.permission:reports.view')
            ->name('admin.reports.index');
        Route::get('reports/sales', [ReportController::class, 'sales'])
            ->middleware('admin.permission:reports.view')
            ->name('admin.reports.sales');
        Route::get('reports/coupons', [ReportController::class, 'coupons'])
            ->middleware('admin.permission:reports.view')
            ->name('admin.reports.coupons');
        Route::get('reports/export/{type}', [ReportController::class, 'export'])
            ->middleware('admin.permission:reports.view')
            ->name('admin.reports.export');
    });
});
