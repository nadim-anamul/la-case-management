#!/bin/bash

echo "🚀 Laravel PDF Generator - Production Setup"
echo "==========================================="

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

# Check if .env.production exists
if [ ! -f .env.production ]; then
    echo "❌ .env.production file not found. Please create it first."
    echo "   Copy .env.docker to .env.production and update the settings."
    exit 1
fi

# Check for required environment variables
echo "🔍 Checking production environment variables..."

# Check if passwords are still default
if grep -q "CHANGE_THIS_TO_STRONG_PASSWORD" .env.production; then
    echo "❌ Please update the database password in .env.production"
    exit 1
fi

if grep -q "CHANGE_THIS_TO_STRONG_REDIS_PASSWORD" .env.production; then
    echo "❌ Please update the Redis password in .env.production"
    exit 1
fi

if grep -q "yourdomain.com" .env.production; then
    echo "❌ Please update the APP_URL in .env.production"
    exit 1
fi

echo "✅ Production environment variables are configured"

# Copy production environment file
echo "📝 Setting up production environment..."
cp .env.production .env

# Build and start production containers
echo "🐳 Building and starting production containers..."
docker compose -f docker-compose.prod.yml up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 20

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
until docker compose -f docker-compose.prod.yml exec db mysqladmin ping -h"localhost" --silent; do
    echo "⏳ Waiting for database connection..."
    sleep 2
done
echo "✅ Database is ready"

# Run production setup commands
echo "🔧 Running production setup commands..."

# Generate application key
echo "🔑 Generating application key..."
docker compose -f docker-compose.prod.yml exec app php artisan key:generate

# Run migrations (no seeders in production)
echo "🗄️  Running database migrations..."
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Create storage link
echo "🔗 Creating storage link..."
docker compose -f docker-compose.prod.yml exec app php artisan storage:link

# Set proper permissions
echo "🔐 Setting proper permissions..."
docker compose -f docker-compose.prod.yml exec app chmod -R 755 storage bootstrap/cache

# Clear and cache config
echo "⚡ Optimizing for production..."
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache

echo ""
echo "🎉 Production setup completed successfully!"
echo ""
echo "📱 Your application is now running in production mode:"
echo "   Web Application: https://yourdomain.com"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose -f docker-compose.prod.yml logs -f"
echo "   Stop services: docker compose -f docker-compose.prod.yml down"
echo "   Restart services: docker compose -f docker-compose.prod.yml restart"
echo "   Update application: ./production-update.sh"
echo ""
echo "⚠️  IMPORTANT SECURITY NOTES:"
echo "   - Ensure SSL certificates are properly configured"
echo "   - Set up proper firewall rules"
echo "   - Configure regular backups"
echo "   - Monitor application logs"
echo "   - Set up monitoring and alerting"
echo "" 