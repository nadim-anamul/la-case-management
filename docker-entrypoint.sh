#!/bin/bash

echo "Starting Laravel application..."

# Run setup tasks
composer install --no-interaction --no-dev --optimize-autoloader

# Build assets for production
echo "Building assets for production..."
npm run build

# Ensure build directory exists and has proper permissions
if [ ! -d "public/build" ]; then
    echo "Creating build directory..."
    mkdir -p public/build
fi

# Generate application key
php artisan key:generate

# Run migrations and seed
php artisan migrate:fresh --seed

# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache public/build

# Clear all caches to ensure fresh assets
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "Setup complete. Starting server..."

# This line executes the CMD from the Dockerfile
exec "$@"