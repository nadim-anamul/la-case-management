FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy the entire application
COPY . /var/www

# Install PHP dependencies with retry mechanism
RUN composer install --no-interaction --no-dev --optimize-autoloader || \
    (echo "Retrying composer install..." && composer install --no-interaction --no-dev --optimize-autoloader) || \
    (echo "Final retry with dev dependencies..." && composer install --no-interaction)

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www

# Copy and set up the entrypoint script
COPY docker-entrypoint.sh /var/www/docker-entrypoint.sh
RUN chmod +x /var/www/docker-entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Use the entrypoint script
CMD ["/var/www/docker-entrypoint.sh", "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"] 