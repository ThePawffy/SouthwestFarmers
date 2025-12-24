FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd bcmath

WORKDIR /var/www/html

# Copy entire repo
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/SUPER-ADMIN

RUN composer install --no-dev --optimize-autoloader

# 👉 IMPORTANT PART
ENV APACHE_DOCUMENT_ROOT=/var/www/html/SUPER-ADMIN/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN chown -R www-data:www-data /var/www/html/SUPER-ADMIN \
 && chmod -R 755 /var/www/html/SUPER-ADMIN

CMD ["apache2-foreground"]
