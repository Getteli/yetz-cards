#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Running npm install"
npm install

echo "Create .env..."
cp /var/www/html/.env.example /var/www/html/.env

echo "Clear..."
php artisan view:clear
php artisan cache:clear
php artisan route:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "generate keys..."
php artisan key:generate
php artisan key:generate --show

echo "Running migrations..."
php artisan migrate:refresh --seed

echo "Running npm build..."
npm run build