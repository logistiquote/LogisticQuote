FROM php:7.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    nano \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    && pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug

# Set working directory
WORKDIR /var/www/html

# Copy application code to the container
COPY ./../ /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
