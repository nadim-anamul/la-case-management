#!/bin/bash

echo "🔧 Laravel PDF Generator - Fix Docker Issues"
echo "============================================"

# Stop all containers
echo "🛑 Stopping all containers..."
docker compose down

# Remove volumes to start fresh
echo "🧹 Cleaning up volumes..."
docker volume prune -f

# Remove any existing images
echo "🗑️  Removing existing images..."
docker compose down --rmi all

# Rebuild containers
echo "🔨 Rebuilding containers..."
docker compose up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 25

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

# Install dependencies
echo "📦 Installing PHP dependencies..."
docker compose exec app composer install --no-interaction

echo "📦 Installing Node.js dependencies..."
docker compose exec app npm install

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

# Build assets
echo "🎨 Building frontend assets..."
docker compose exec app npm run build

echo ""
echo "✅ Docker issues fixed successfully!"
echo ""
echo "🌐 Your application should now be accessible at: http://localhost:8000"
echo "" 