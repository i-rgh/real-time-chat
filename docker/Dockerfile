#********************************************* Stage 1: Build Laravel Application *********************************************
FROM composer:2.4 AS vendor
WORKDIR /app
COPY composer.* ./
RUN composer install --no-dev --ignore-platform-reqs --prefer-dist --no-scripts --no-autoloader

#********************************************* Stage 2: Build Node.js Environment *********************************************
FROM node:20 AS node
WORKDIR /app
COPY tsconfig.json package* *.config.js public/* resources/* ./
RUN npm install && npm run build

#********************************************* Stage 3: Build phpEnvironment *********************************************
FROM php:8.2-fpm AS php
WORKDIR /var/www
COPY docker/start.sh /usr/local/bin/start
RUN chown -R www-data:www-data /var/www \
    && chmod u+x /usr/local/bin/start \
    && apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip pcntl # Install PHP PCNTL extension

COPY --from=vendor /app/vendor /var/www/vendor
EXPOSE 9000
CMD ["sh", "-c", "/usr/local/bin/start && php-fpm"]
