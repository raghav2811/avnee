# AVNEE E-commerce (Laravel 12)

AVNEE is a multi-brand fashion and jewellery e-commerce application built with Laravel 12, Blade, Tailwind CSS, and Vite.

## Core Modules

- Storefront (Studio and Jewellery themes)
- Catalog, product variants, reviews, wishlist, cart, checkout
- Coupons and flash sales
- Customer account and order tracking
- Admin panel (catalog, content, orders, reports, newsletter)
- Razorpay payment integration
- Shiprocket shipping integration and webhook handling

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL (recommended for this project)
- Node.js + Vite + Tailwind

## Quick Start

1. Install dependencies:

```bash
composer install
npm install
```

2. Create environment file and app key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database in .env (MySQL recommended):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=avnee_db
DB_USERNAME=root
DB_PASSWORD=
```

4. Run migrations and seeders:

```bash
php artisan migrate --seed
```

5. Start app and frontend dev server:

```bash
php artisan serve
npm run dev
```

Or run the combined local stack:

```bash
composer run dev
```

## Environment Variables You Should Set

- APP_URL
- DB_* (MySQL settings)
- MAIL_* (for order/newsletter email)
- Razorpay keys (stored in admin settings and/or env-backed config)
- Shiprocket credentials (as used by Shiprocket service)

## Quality Commands

```bash
php artisan test
./vendor/bin/pint
```

## Project Notes

- The route file is monolithic and contains both storefront and admin routes.
- A few utility/debug scripts exist in project root and should be treated as local-only tooling.
- Some legacy/duplicate controllers are present and can be removed after verification.

See project analysis and action plan in `docs/CHANGE_REPORT.md`.
