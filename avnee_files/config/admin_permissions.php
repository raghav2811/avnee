<?php

return [
    'roles' => [
        'admin' => [
            '*',
        ],
        'staff' => [
            'dashboard.view',
            'orders.*',
            'customers.*',
            'reviews.*',
            'newsletter.view',
            'reports.view',
            'products.view',
            'products.manage',
            'categories.view',
            'categories.manage',
            'banners.view',
            'banners.manage',
            'coupons.view',
            'coupons.manage',
            'flash_sales.view',
            'flash_sales.manage',
            'combos.view',
            'combos.manage',
            'content.view',
            'content.manage',
        ],
    ],
];
