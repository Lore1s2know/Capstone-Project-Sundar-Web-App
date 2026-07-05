#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Running composer..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

if [ "${SEED_DATABASE:-false}" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi
