# AVNEE Codebase Change Report

Date: 2026-04-06
Scope: `avnee_files`

## Summary

This codebase is functional and feature-rich, but it needs structural cleanup, environment hardening, and focused quality work before major feature expansion.

## Required Updates

1. Route modularization
- Problem: `routes/web.php` is very large and mixes storefront, account, webhook, and admin concerns.
- Change: Split into route files by domain (`routes/front.php`, `routes/admin.php`, `routes/webhooks.php`) and load in `bootstrap/app.php`.
- Benefit: Better maintainability and safer future changes.

2. Controller/service refactor for checkout
- Problem: `app/Http/Controllers/Front/CheckoutController.php` holds many responsibilities (validation, totals, coupon logic, order creation, payment handoff, stock updates, email, shipping trigger).
- Change: Extract to dedicated services (`OrderPricingService`, `OrderPlacementService`, `PaymentService`, `InventoryService`).
- Benefit: Easier testing and fewer regressions.

3. Environment consistency
- Problem: `.env.example` defaults to SQLite while project scripts and helper files indicate MySQL usage.
- Change: Align `.env.example` and docs to one recommended local setup (MySQL), while preserving optional SQLite fallback.
- Benefit: Fewer setup failures.

4. Test coverage expansion
- Problem: Minimal tests relative to app complexity.
- Change: Add feature tests for checkout success/failure paths, coupon application, admin auth, and webhook handling.
- Benefit: Prevents regressions during future updates.

5. Error-handling and observability
- Problem: Key flows rely on best-effort behavior without structured diagnostics.
- Change: Add structured logging contexts around payment verification, order placement, and Shiprocket API calls.
- Benefit: Faster production debugging.

## Candidates To Remove

1. Legacy/duplicate controller namespace
- `app/Http/Controllers/Frontend/HomeController.php`
- Notes: Similar responsibility exists under `app/Http/Controllers/Front/HomeController.php`. Remove only after confirming no references.

2. Root-level one-off DB scripts (replace with Artisan command or docs)
- `check_db_exists.php`
- `create_db.php`
- `test_db.php`
- Notes: Keep only if actively used by the team; otherwise replace with documented Artisan or SQL workflow.

3. Seed error artifact
- `seed_error.txt`
- Notes: Archive in docs/history if needed, otherwise remove from active workspace.

## Features To Add

1. Admin role/permission management
- Current admin middleware checks role values directly.
- Add policy/gate-based authorization for fine-grained panel access.

2. Centralized settings cache
- Reduce repeated `Setting::where(...)->value(...)` reads in runtime paths.
- Add app-level settings repository with caching and invalidation.

3. Checkout hardening features
- Idempotency key for order creation endpoints.
- Retry-safe payment verification flow.
- Stronger stock race handling (transaction + row lock in placement path).

4. Customer communication features
- Order timeline notifications (placed, packed, shipped, delivered).
- Better self-service order tracking page with event history.

5. Operational features
- Health check for third-party integrations (Razorpay/Shiprocket).
- Admin dashboard cards for payment failures and webhook errors.

## What Was Started Now

1. Replaced generic framework README with project-specific setup and run instructions.
2. Created this `docs/CHANGE_REPORT.md` to track update/remove/add work.
3. Route modularization has started by splitting route definitions into front/admin files.
4. Next implementation target: cleanup pass for legacy utility files and checkout service extraction.

## Proposed Execution Order

1. Setup and documentation alignment
2. Safe cleanup (unused files/controllers)
3. Route modularization
4. Checkout service extraction
5. Tests and observability
6. New feature implementation
