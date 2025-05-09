FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# ✅ Copy everything (artisan, app, etc.)
COPY . .

# ✅ NOW run composer install
RUN composer install --no-dev --optimize-autoloader

# 🔒 Skip running artisan stuff during build (do it after deploy)
# RUN php artisan key:generate
# RUN php artisan migrate --force
# RUN php artisan config:cache

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
