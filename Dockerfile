# Use official PHP image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip \
    curl \
    git \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all project files into container
COPY . .

# ✅ Create an empty SQLite database file
RUN mkdir -p database && touch database/database.sqlite

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node and build frontend
RUN npm install && npm run build

# Set proper permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose the port Laravel uses
EXPOSE 8000

# Run the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
