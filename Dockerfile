# -------- Stage 1: Build Vue assets --------
FROM node:20 AS node

WORKDIR /var/www

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# -------- Stage 2: Build Laravel App --------
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel files
COPY . .

# Copy built assets from Node stage
COPY --from=node /var/www/public /var/www/public

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expose port
EXPOSE 9000

# Start Laravel using PHP-FPM
CMD ["php-fpm"]
