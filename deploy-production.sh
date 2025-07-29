#!/bin/bash

echo "🚀 Deploying to Production with CDN Assets"
echo "=========================================="

# Stop containers
echo "🛑 Stopping containers..."
docker compose -f docker-compose.server.yml down

# Remove all containers and images
echo "🧹 Removing all containers and images..."
docker system prune -a -f

# Rebuild and start containers
echo "🐳 Rebuilding and starting containers..."
docker compose -f docker-compose.server.yml up -d --build

# Wait for containers
echo "⏳ Waiting for containers to be ready..."
sleep 45

# Check if the application is responding
echo "🔍 Checking application status..."
max_attempts=15
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
    echo "📋 Container logs:"
    docker compose -f docker-compose.server.yml logs app
    exit 1
fi

echo ""
echo "🎉 Production deployment completed successfully!"
echo ""
echo "📱 Check the application: http://152.42.201.131:8000"
echo ""
echo "✅ This deployment uses:"
echo "   - CDN assets (no Vite build required)"
echo "   - Production environment"
echo "   - Updated database seeder"
echo "   - All new fields (status, order_signature_date, etc.)"
echo ""
echo "🔧 If you need to check logs:"
echo "   docker compose -f docker-compose.server.yml logs -f" 