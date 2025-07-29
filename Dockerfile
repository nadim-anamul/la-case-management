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

# Create a startup script to ensure dependencies are available
RUN echo '#!/bin/bash\n\
echo "Starting Laravel application..."\n\
if [ ! -f "/var/www/vendor/autoload.php" ]; then\n\
    echo "Installing PHP dependencies..."\n\
    composer install --no-interaction --no-dev --optimize-autoloader\n\
fi\n\
if [ ! -d "/var/www/node_modules" ]; then\n\
    echo "Installing Node.js dependencies..."\n\
    npm install\n\
    npm run build\n\
fi\n\
echo "Setting up Laravel..."\n\
php artisan key:generate\n\
php artisan migrate:fresh --seed\n\
php artisan storage:link\n\
chmod -R 775 storage bootstrap/cache\n\
echo "Starting server..."\n\
php artisan serve --host=0.0.0.0 --port=8000' > /var/www/start.sh && \
    chmod +x /var/www/start.sh

# Expose port 8000
EXPOSE 8000

# Use the startup script
CMD ["/var/www/start.sh"] 