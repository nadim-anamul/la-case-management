#!/bin/bash

echo "🔍 Checking Asset Building in Container"
echo "======================================"

# Check if containers are running
echo "📋 Container Status:"
docker compose -f docker-compose.server.yml ps

echo ""
echo "📋 Application Logs (last 50 lines):"
docker compose -f docker-compose.server.yml logs --tail=50 app

echo ""
echo "🔍 Checking if assets exist in container:"
docker compose -f docker-compose.server.yml exec app ls -la public/build/ 2>/dev/null || echo "❌ Build directory not found"

echo ""
echo "🔍 Checking if assets exist in container (assets folder):"
docker compose -f docker-compose.server.yml exec app ls -la public/build/assets/ 2>/dev/null || echo "❌ Assets directory not found"

echo ""
echo "🔍 Checking if manifest exists:"
docker compose -f docker-compose.server.yml exec app ls -la public/build/.vite/ 2>/dev/null || echo "❌ Vite directory not found"

echo ""
echo "🌐 Testing asset loading:"
if curl -f http://152.42.201.131:8000/build/assets/app-*.css > /dev/null 2>&1; then
    echo "✅ CSS assets are accessible"
else
    echo "❌ CSS assets are not accessible"
fi

if curl -f http://152.42.201.131:8000/build/assets/app-*.js > /dev/null 2>&1; then
    echo "✅ JS assets are accessible"
else
    echo "❌ JS assets are not accessible"
fi

echo ""
echo "💡 If assets are missing, try rebuilding:"
echo "   docker compose -f docker-compose.server.yml down"
echo "   docker compose -f docker-compose.server.yml up -d --build" 