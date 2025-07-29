#!/bin/bash

echo "Starting Laravel application..."

# Run setup tasks
echo "Installing Composer dependencies..."
composer install --no-interaction --no-dev --optimize-autoloader

echo "Installing npm dependencies..."
npm install

echo "Building assets for production..."
npm run build

# Check if build was successful
if [ ! -d "public/build" ]; then
    echo "❌ Asset build failed - public/build directory not found"
    echo "📋 Checking npm and node versions:"
    node --version
    npm --version
    echo "📋 Checking if package.json exists:"
    ls -la package.json
    echo "📋 Checking if node_modules exists:"
    ls -la node_modules
    exit 1
fi

echo "✅ Assets built successfully"
echo "📋 Build directory contents:"
ls -la public/build/

echo "Generating application key..."
php artisan key:generate

echo "Running migrations and seeding..."
php artisan migrate:fresh --seed

echo "Creating storage link..."
php artisan storage:link

echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache public/build

echo "Setup complete. Starting server..."

# This line executes the CMD from the Dockerfile
exec "$@"