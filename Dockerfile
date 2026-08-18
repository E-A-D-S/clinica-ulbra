FROM php:8.1-apache

# dependencias do sistema + extensoes PHP necessarias (postgres, gd, zip, etc.)
RUN apt-get update && apt-get install -y \
        libpq-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
        libcurl4-openssl-dev libicu-dev \
        unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip gd exif bcmath curl intl \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Node 20 para compilar os assets (Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Apache passa a servir a pasta public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# instala dependencias e compila assets
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && npm install --no-audit --no-fund && npm run build \
    && chown -R www-data:www-data storage bootstrap/cache

RUN chmod +x docker-entrypoint.sh
CMD ["./docker-entrypoint.sh"]
