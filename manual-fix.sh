#!/bin/bash

echo "🔧 Manual Server Fix"
echo "===================="

# Stop containers
docker compose down

# Remove everything
docker system prune -a -f

# Rebuild
docker compose build --no-cache

# Start
docker compose up -d

# Wait
sleep 20

# Install dependencies manually
echo "Installing dependencies manually..."
docker compose exec app composer install --no-interaction --no-dev --optimize-autoloader
docker compose exec app npm install
docker compose exec app npm run build

# Setup Laravel
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
docker compose exec app chmod -R 775 storage bootstrap/cache

echo "✅ Manual fix completed!"
echo "🌐 Access at: http://152.42.201.131:8000" 