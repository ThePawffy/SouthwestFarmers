FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql zip gd bcmath \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
 && php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# ✅ COPY nginx config (this is the missing brain cell)
COPY nginx.conf /etc/nginx/sites-available/default

RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php-fpm -D && nginx -g 'daemon off;'
