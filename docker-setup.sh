#!/bin/bash

echo "🚀 Laravel PDF Generator - Simple Docker Setup"
echo "=============================================="

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is available
if ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose is not available. Please ensure Docker is installed with Compose support."
    exit 1
fi

echo "✅ Docker and Docker Compose are available"

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Copying .env.example to .env"
    cp .env.example .env
    echo "✅ Environment file created"
else
    echo "✅ .env file already exists"
fi

# Stop any existing containers
echo "🛑 Stopping existing containers..."
docker compose down

# Clean up any existing images to ensure fresh build
echo "🧹 Cleaning up existing images..."
docker compose build --no-cache

# Build and start containers
echo "🐳 Building and starting containers..."
docker compose up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 20

# Wait for database to be ready
echo "⏳ Waiting for database..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    if docker compose exec db mysqladmin ping -h"localhost" --silent 2>/dev/null; then
        echo "✅ Database is ready"
        break
    else
        echo "⏳ Waiting for database... (attempt $attempt/$max_attempts)"
        sleep 3
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "❌ Database failed to start"
    docker compose logs db
    exit 1
fi

# Check if app container is running properly
echo "🔍 Checking application container..."
if ! docker compose exec app php --version > /dev/null 2>&1; then
    echo "❌ Application container is not responding"
    docker compose logs app
    echo "🔄 Attempting to restart application container..."
    docker compose restart app
    sleep 10
fi

# Setup Laravel application
echo "🔧 Setting up Laravel application..."

# Clear any cached configurations
echo "🧹 Clearing cached configurations..."
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear

# Check if vendor directory exists, if not install dependencies
echo "📦 Checking PHP dependencies..."
if ! docker compose exec app test -d vendor; then
    echo "📦 Installing PHP dependencies..."
    docker compose exec app composer install --no-interaction --optimize-autoloader
fi

# Check if node_modules exists, if not install Node.js dependencies
echo "📦 Checking Node.js dependencies..."
if ! docker compose exec app test -d node_modules; then
    echo "📦 Installing Node.js dependencies..."
    docker compose exec app npm install
    docker compose exec app npm run build
fi

# Generate application key
echo "🔑 Generating application key..."
docker compose exec app php artisan key:generate

# Run migrations and seeders with fresh data
echo "🗄️  Running database migrations and seeders..."
docker compose exec app php artisan migrate:fresh --seed

# Create storage link
echo "🔗 Creating storage link..."
docker compose exec app php artisan storage:link

# Set permissions
echo "🔐 Setting proper permissions..."
docker compose exec app chmod -R 775 storage bootstrap/cache

# Verify data population
echo "📊 Verifying data population..."
record_count=$(docker compose exec app php artisan tinker --execute="echo App\Models\Compensation::count();" 2>/dev/null | tail -1)
if [ "$record_count" -ge 4 ]; then
    echo "✅ Successfully populated with $record_count compensation records"
else
    echo "⚠️  Warning: Only $record_count records found (expected 4)"
fi

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://localhost:8000"
echo "   Compensation List: http://localhost:8000/compensations"
echo "   Database: localhost:3307"
echo ""
echo "📊 Demo data includes:"
echo "   • 4 comprehensive compensation records"
echo "   • SA and RS-based cases"
echo "   • Multiple applicants and ownership details"
echo "   • Complete form data for testing"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop services: docker compose down"
echo "   Restart services: docker compose restart"
echo "   Execute commands: docker compose exec app php artisan [command]"
echo "" 