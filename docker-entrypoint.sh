#!/bin/bash

echo "Starting Laravel application..."

# Set Chrome path for Puppeteer
export PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome
export CHROME_PATH=/usr/bin/google-chrome
export PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true

# Run setup tasks
echo "Installing Composer dependencies..."
composer install --no-interaction --no-dev --optimize-autoloader

# Only build assets in development environment
if [ "$APP_ENV" != "production" ]; then
    echo "Installing npm dependencies..."
    npm install

    echo "Building assets for development..."
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

    # Fix Vite manifest location issue
    echo "🔧 Fixing Vite manifest location..."
    if [ -f "public/build/.vite/manifest.json" ] && [ ! -f "public/build/manifest.json" ]; then
        cp public/build/.vite/manifest.json public/build/manifest.json
        echo "✅ Manifest file copied to correct location"
    elif [ -f "public/build/manifest.json" ]; then
        echo "✅ Manifest file already in correct location"
    else
        echo "⚠️ No manifest file found"
    fi
else
    echo "🌐 Production environment detected - using CDN for assets"
    echo "   - Tailwind CSS: CDN"
    echo "   - Alpine.js: CDN"
    echo "   - No local asset building required"
fi

echo "Generating application key..."
php artisan key:generate

echo "Running migrations and seeding..."
# Use --force to avoid interactive prompts and handle production environment
php artisan migrate --force

echo "Creating storage link..."
# Remove existing link if it exists, then create new one
if [ -L "public/storage" ]; then
    echo "Removing existing storage link..."
    rm public/storage
fi
php artisan storage:link

echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache public/build

echo "Setup complete. Starting server..."

# This line executes the CMD from the Dockerfile
exec "$@"