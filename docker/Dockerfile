FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev  # PostgreSQL development package

# Install libonig-dev for oniguruma support
RUN apt-get install -y libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl pdo_pgsql gd

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a system user to run Composer and Artisan commands
RUN addgroup --gid 1000 laravel \
    && adduser --ingroup laravel --shell /bin/sh laravel

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Set permissions for storage directory
RUN chmod -R 775 storage

# Switch to the laravel user
USER laravel

# Expose port 9000 (if necessary, adjust according to your setup)
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
