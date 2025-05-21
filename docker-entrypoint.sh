#!/bin/sh
set -e

# Wait for MySQL to be available
echo "Waiting for MySQL..."
while ! mysqladmin ping -h mysql --silent; do
    sleep 1
done

# Fix permissions on the server
echo "Setting correct permissions for storage and bootstrap/cache..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install dependencies and build 
npm install
npm run build

# Database setup + population
echo "Running migrations and seeders..."
php artisan migrate:fresh --seed --force

# Start PHP-FPM
php-fpm
