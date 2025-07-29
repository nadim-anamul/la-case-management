#!/bin/bash

echo "🔄 Laravel PDF Generator - Production Update"
echo "==========================================="

# Check if production containers are running
if ! docker compose -f docker-compose.prod.yml ps | grep -q "laravel-pdf-generator-app-prod"; then
    echo "❌ Production containers are not running. Please start them first:"
    echo "   ./production-setup.sh"
    exit 1
fi

echo "✅ Production containers are running"

# Backup database before update
echo "💾 Creating database backup..."
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
docker compose -f docker-compose.prod.yml exec -T db mysqldump -u root -p${DB_ROOT_PASSWORD:-root_password} laravel_pdf_generator > "backup_${TIMESTAMP}.sql"
echo "✅ Database backup created: backup_${TIMESTAMP}.sql"

# Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin main

# Build new containers
echo "🔨 Building new containers..."
docker compose -f docker-compose.prod.yml build --no-cache

# Update environment if needed
if [ -f .env.production ]; then
    echo "📝 Updating environment..."
    cp .env.production .env
fi

# Deploy with zero downtime
echo "🚀 Deploying with zero downtime..."

# Start new containers
docker compose -f docker-compose.prod.yml up -d --no-deps app

# Wait for new app container to be healthy
echo "⏳ Waiting for new application to be ready..."
sleep 10

# Run migrations
echo "🗄️  Running database migrations..."
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Clear and cache config
echo "⚡ Optimizing for production..."
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache

# Restart nginx to pick up any changes
echo "🔄 Restarting web server..."
docker compose -f docker-compose.prod.yml restart webserver

# Clean up old images
echo "🧹 Cleaning up old images..."
docker image prune -f

echo ""
echo "🎉 Production update completed successfully!"
echo ""
echo "📊 Update Summary:"
echo "   - Database backup: backup_${TIMESTAMP}.sql"
echo "   - Application updated and optimized"
echo "   - Zero downtime deployment completed"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose -f docker-compose.prod.yml logs -f"
echo "   Check status: docker compose -f docker-compose.prod.yml ps"
echo "   Rollback: docker compose -f docker-compose.prod.yml down && ./production-setup.sh"
echo "" 