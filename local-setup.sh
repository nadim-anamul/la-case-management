#!/bin/bash

echo "🚀 Laravel PDF Generator - Local Setup"
echo "======================================"

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1+ first."
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    exit 1
fi

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js first."
    exit 1
fi

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL is not installed. Please install MySQL first."
    exit 1
fi

echo "✅ All required software is installed"

# Copy local environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Copying .env.local to .env"
    cp .env.local .env
    echo "⚠️  Please update .env file with your database credentials"
else
    echo "✅ .env file already exists"
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Run migrations and seeders
echo "🗄️  Running database migrations and seeders..."
php artisan migrate --seed

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Set permissions
echo "🔐 Setting proper permissions..."
chmod -R 775 storage bootstrap/cache

# Build assets
echo "🎨 Building frontend assets..."
npm run build

echo ""
echo "🎉 Local setup completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://localhost:8000"
echo ""
echo "🔧 Useful commands:"
echo "   Start server: php artisan serve"
echo "   Watch assets: npm run dev"
echo "   Run tests: php artisan test"
echo "" 