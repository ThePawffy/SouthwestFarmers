FROM php:8.2-fpm

# Install system dependencies (ADD gettext-base)
RUN apt-get update && apt-get install -y \
    nginx \
    gettext-base \
    git unzip \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql zip gd bcmath \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files first
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application
COPY . .

# Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

# Nginx config template
COPY nginx.conf /etc/nginx/templates/default.conf.template

EXPOSE 8080

# Render nginx config + start services
CMD sh -c "envsubst '\$PORT' < /etc/nginx/templates/default.conf.template > /etc/nginx/sites-enabled/default && php-fpm -D && nginx -g 'daemon off;'"
