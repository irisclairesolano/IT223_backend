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

# Copy only composer files first
COPY composer.json composer.lock ./

# ✅ Full install with autoloader + scripts
RUN composer install --no-dev --optimize-autoloader

# Copy rest of the app
COPY . .

# ✅ Comment these out — run them in the Render Shell instead after deploy
# RUN php artisan key:generate
# RUN php artisan migrate --force
# RUN php artisan config:clear && \
#     php artisan config:cache && \
#     php artisan route:cache && \
#     php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port (optional, Render uses web service port instead)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
