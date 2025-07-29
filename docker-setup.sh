#!/bin/bash

echo "🚀 Laravel PDF Generator - Docker Setup"
echo "========================================"

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
    echo "⚠️  Please update .env file with your database credentials"
    echo "   - Set DB_PASSWORD to a secure password"
    echo "   - Set DB_ROOT_PASSWORD to a secure password"
else
    echo "✅ .env file already exists"
fi

# Build and start containers
echo "🐳 Building and starting Docker containers..."
docker compose up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 20

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    if docker compose exec db mysqladmin ping -h"localhost" --silent 2>/dev/null; then
        echo "✅ Database is ready"
        break
    else
        echo "⏳ Waiting for database connection... (attempt $attempt/$max_attempts)"
        sleep 5
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "❌ Database failed to start within expected time"
    echo "📋 Checking container logs..."
    docker compose logs db
    exit 1
fi

# Check if vendor directory exists, if not install PHP dependencies
echo "📦 Checking PHP dependencies..."
if ! docker compose exec app test -d vendor; then
    echo "📦 Installing PHP dependencies..."
    if ! docker compose exec app composer install --no-interaction; then
        echo "❌ Failed to install PHP dependencies. Trying with dev dependencies..."
        docker compose exec app composer install --no-interaction
    fi
else
    echo "✅ PHP dependencies already installed"
fi

# Check if node_modules exists, if not install Node.js dependencies
echo "📦 Checking Node.js dependencies..."
if ! docker compose exec app test -d node_modules; then
    echo "📦 Installing Node.js dependencies..."
    docker compose exec app npm install
else
    echo "✅ Node.js dependencies already installed"
fi

# Generate application key
echo "🔑 Generating application key..."
docker compose exec app php artisan key:generate

# Run migrations and seeders
echo "🗄️  Running database migrations and seeders..."
docker compose exec app php artisan migrate --seed

# Create storage link
echo "🔗 Creating storage link..."
docker compose exec app php artisan storage:link

# Set permissions
echo "🔐 Setting proper permissions..."
docker compose exec app chmod -R 775 storage bootstrap/cache

# Build assets (only if not already built)
echo "🎨 Building frontend assets..."
docker compose exec app npm run build

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://localhost:8000"
echo "   Database: localhost:3306"
echo "   Redis: localhost:6379"
echo ""
echo "📊 Demo data has been loaded with 4 compensation records"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop services: docker compose down"
echo "   Restart services: docker compose restart"
echo "   Execute commands: docker compose exec app php artisan [command]"
echo "" 