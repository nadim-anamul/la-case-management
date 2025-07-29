#!/bin/bash

echo "🚀 Redeploying Laravel PDF Generator with Fixed Assets"
echo "====================================================="

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker compose -f docker-compose.server.yml down

# Remove all containers and images to ensure clean rebuild
echo "🧹 Removing all containers and images..."
docker system prune -a -f

# Rebuild and start containers
echo "🐳 Rebuilding and starting containers with fixed asset building..."
docker compose -f docker-compose.server.yml up -d --build

# Wait for containers to be ready
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
echo "🎉 Redeployment completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://152.42.201.131:8000"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose -f docker-compose.server.yml logs -f"
echo "   Stop services: docker compose -f docker-compose.server.yml down"
echo "   Restart services: docker compose -f docker-compose.server.yml restart"
echo ""
echo "💡 If assets are still not loading, check the container logs:"
echo "   docker compose -f docker-compose.server.yml logs app"
echo "" 