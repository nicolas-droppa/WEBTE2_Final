# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libzip-dev zip unzip git curl libpng-dev libjpeg-dev libonig-dev libxml2-dev supervisor \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd

# Install Node.js (version 20.x) and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer (copy from official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application code
COPY . /var/www

# Make docker-entrypoint.sh executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Run npm install and build your frontend assets
RUN npm install
RUN npm run build

# Set permissions for Laravel storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 for php-fpm
EXPOSE 9000

# Start php-fpm (default command)
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
