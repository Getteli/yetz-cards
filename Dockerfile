FROM php:7.4-fpm

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install extensions for PHP
RUN docker-php-ext-install pdo mbstring pdo_mysql tokenizer xml ctype json

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents to the working directory
COPY . /var/www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]