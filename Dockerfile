# Use official PHP image as base
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    curl \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    zlib-dev \
    libzip-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install gd pdo pdo_pgsql intl zip

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Ensure storage and cache directories exist and are writable (all subfolders)
RUN mkdir -p /var/www/storage/framework/views /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Set dummy Pusher env vars for build-time only, then unset after composer install
ENV PUSHER_APP_ID=dummy \
    PUSHER_APP_KEY=dummy \
    PUSHER_APP_SECRET=dummy \
    PUSHER_APP_CLUSTER=mt1

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    unset PUSHER_APP_ID PUSHER_APP_KEY PUSHER_APP_SECRET PUSHER_APP_CLUSTER

# Expose port 9000 for php-fpm
EXPOSE 9000

CMD ["php-fpm"]