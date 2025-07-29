#!/bin/bash

echo "🚀 Rebuilding Application with Assets"
echo "===================================="

# Stop containers
echo "🛑 Stopping containers..."
docker compose -f docker-compose.server.yml down

# Remove all containers and images
echo "🧹 Removing all containers and images..."
docker system prune -a -f

# Rebuild and start
echo "🐳 Rebuilding and starting containers..."
docker compose -f docker-compose.server.yml up -d --build

# Wait for containers
echo "⏳ Waiting for containers to be ready..."
sleep 30

# Check if assets are built
echo "🔍 Checking asset building..."
sleep 10

# Check container logs
echo "📋 Container logs:"
docker compose -f docker-compose.server.yml logs app

echo ""
echo "🎉 Rebuild completed!"
echo ""
echo "📱 Check the application: http://152.42.201.131:8000"
echo ""
echo "🔧 If assets still don't load, run: ./check-assets.sh" 