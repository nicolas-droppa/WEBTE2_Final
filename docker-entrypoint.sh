#!/bin/sh
set -e

# Wait for MySQL to be available
echo "Waiting for MySQL..."
while ! mysqladmin ping -h mysql --silent; do
    sleep 1
done

npm install
npm run build

echo "Running migrations and seeders..."
php artisan migrate:fresh --seed --force

# Then start PHP-FPM
php-fpm
