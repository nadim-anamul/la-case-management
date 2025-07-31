#!/bin/bash

echo "🚀 Deploying Laravel PDF Generator"
echo "=================================="

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker compose -f docker-compose.server.yml down

# Clean up old builds
echo "🧹 Cleaning up old builds..."
docker system prune -f

# Rebuild and start containers
echo "🐳 Rebuilding and starting containers..."
docker compose -f docker-compose.server.yml up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 30

# Run database migrations first
echo "🗄️ Running database migrations..."
docker compose -f docker-compose.server.yml exec -T app php artisan migrate --force

# Run database seeder
echo "🌱 Running database seeder..."
docker compose -f docker-compose.server.yml exec -T app php artisan db:seed --force

# Check if the application is responding
echo "🔍 Checking application status..."
max_attempts=10
attempt=1

while [ $attempt -le $max_attempts ]; do
    if curl -f http://localhost:8000 > /dev/null 2>&1; then
        echo "✅ Application is responding"
        break
    else
        echo "⏳ Waiting for application... (attempt $attempt/$max_attempts)"
        sleep 5
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "❌ Application failed to start"
    docker compose -f docker-compose.server.yml logs app
    exit 1
fi

echo ""
echo "🎉 Deployment completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://152.42.201.131:8000"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose -f docker-compose.server.yml logs -f"
echo "   Stop services: docker compose -f docker-compose.server.yml down"
echo "   Restart services: docker compose -f docker-compose.server.yml restart"
echo "" 