# DEPLOYMENT INSTRUCTIONS

## Requirements
- PHP 8.x
- Composer
- MySQL or compatible database
- Node.js & npm (for asset build, optional)

## 1. Clone the repository
```
git clone https://github.com/RR024/avnee.git
cd avnee
```

## 2. Install PHP dependencies
```
composer install
```

## 3. Copy and configure environment file
```
cp .env.example .env
```
- Edit `.env` and set your database and mail credentials.

## 4. Generate application key
```
php artisan key:generate
```

## 5. Run migrations (and seeders if needed)
```
php artisan migrate --seed
```

## 6. (Optional) Build frontend assets
If using Laravel Mix/Vite:
```
npm install
npm run build
```

## 7. Set permissions
- Ensure `storage/` and `bootstrap/cache/` are writable by the web server.

## 8. Configure web server
- Point your web root to `public/` directory.

## 9. (Optional) Link storage
```
php artisan storage:link
```

## 10. (Optional) Restore media
- Upload large media (videos, images, etc.) from the provided backup link to their respective folders.

---

## Hostinger Quick Steps
1. Upload code (via Git or File Manager)
2. Set PHP version to 8.x
3. Import database using `avnee_db.sql`
4. Configure `.env` for database and mail
5. Set web root to `public/`
6. Run `composer install` and `php artisan key:generate`
7. (Optional) Build assets with npm if needed
8. Restore media files if required

---

For any issues, contact the developer.
