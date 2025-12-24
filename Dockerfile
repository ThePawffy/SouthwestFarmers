FROM php:8.2-apache

# First, completely disable all MPM modules, then enable only one
RUN a2dismod mpm_prefork mpm_worker mpm_event || true \
 && rm -f /etc/apache2/mods-enabled/mpm_*.load \
 && rm -f /etc/apache2/mods-enabled/mpm_*.conf \
 && a2enmod mpm_event \
 && a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql zip gd bcmath \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Point Apache to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html/storage \
 && chmod -R 755 /var/www/html/bootstrap/cache

# Verify only one MPM is enabled (for debugging)
RUN echo "Enabled MPM modules:" && ls -la /etc/apache2/mods-enabled/mpm_* || echo "No MPM modules found"

EXPOSE 80

CMD ["apache2-foreground"]