# Start from PHP + Composer image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git unzip libzip-dev libonig-dev libpng-dev \
  && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Copy only composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Then copy the rest of your project
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html

# Expose port and run PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]