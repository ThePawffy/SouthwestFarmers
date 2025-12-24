FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git unzip \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql zip gd bcmath \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files first (layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy app
COPY . .

# Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 8080

CMD sh -c "envsubst '\$PORT' < /etc/nginx/sites-available/default > /etc/nginx/sites-enabled/default && php-fpm -D && nginx -g 'daemon off;'"

