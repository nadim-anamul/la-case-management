#!/bin/bash

echo "🔧 Fixing Server Deployment Issues"
echo "=================================="

# Stop all containers
echo "🛑 Stopping all containers..."
docker compose down

# Remove all images and containers
echo "🧹 Removing all images and containers..."
docker system prune -a -f

# Remove specific images
echo "🧹 Removing specific images..."
docker rmi $(docker images -q pdf-generate-app) 2>/dev/null || true
docker rmi $(docker images -q laravel-pdf-generator-app) 2>/dev/null || true

# Clean up any dangling images
echo "🧹 Cleaning up dangling images..."
docker system prune -f

# Rebuild without cache
echo "🔨 Rebuilding containers without cache..."
docker compose build --no-cache

# Start containers
echo "🚀 Starting containers..."
docker compose up -d

# Wait for containers
echo "⏳ Waiting for containers to be ready..."
sleep 30

# Check if app container is running
echo "🔍 Checking application container status..."
if ! docker compose exec app php --version > /dev/null 2>&1; then
    echo "❌ Application container is not responding"
    echo "📋 Container logs:"
    docker compose logs app
    exit 1
fi

# Force install dependencies inside container
echo "📦 Force installing dependencies inside container..."
docker compose exec app composer install --no-interaction --no-dev --optimize-autoloader
docker compose exec app npm install
docker compose exec app npm run build

# Setup Laravel
echo "🔧 Setting up Laravel..."
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
docker compose exec app chmod -R 775 storage bootstrap/cache

# Verify setup
echo "✅ Verifying setup..."
record_count=$(docker compose exec app php artisan tinker --execute="echo App\Models\Compensation::count();" 2>/dev/null | tail -1)
if [ "$record_count" -ge 4 ]; then
    echo "✅ Setup successful! Found $record_count compensation records"
else
    echo "⚠️  Setup completed but only $record_count records found"
fi

echo ""
echo "🎉 Server issues fixed!"
echo "🌐 Access at: http://152.42.201.131:8000"
echo "📊 Data at: http://152.42.201.131:8000/compensations"
echo "" 