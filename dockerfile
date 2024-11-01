# php sodium

# Gunakan image dasar PHP dengan Nginx
FROM php:8.2-fpm

# Install ekstensi yang diperlukan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Install Sodium
RUN apt-get update && apt-get install -y \
    libsodium-dev \
    && docker-php-ext-install sodium

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy file composer.json dan composer.lock
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-autoloader --no-scripts

# Copy semua file aplikasi
COPY . .

# Jalankan autoloader
RUN composer dump-autoload

# Set permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Mulai PHP-FPM
CMD ["php-fpm"]
