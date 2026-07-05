#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Running composer..."
composer install --no-dev --optimize-autoloader --no-interaction
php artisan package:discover --ansi

echo "Running migrations..."
php artisan migrate --force

if [ "${SEED_DATABASE:-false}" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

php artisan storage:link --force 2>/dev/null || true

echo "Clearing old caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Fixing storage permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

echo "Verifying build assets..."
test -f public/build/manifest.json
