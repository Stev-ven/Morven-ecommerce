# Start from PHP 8.2 FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git unzip libzip-dev libonig-dev libpng-dev curl \
  && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd


# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy only composer files first
COPY composer.json composer.lock ./

# Then copy the rest of the project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader



# Set permissions
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html

# Expose port and run PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]