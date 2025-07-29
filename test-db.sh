#!/bin/bash

echo "🔍 Testing Database Connection"
echo "============================="

# Check if containers are running
echo "📋 Container Status:"
docker compose -f docker-compose.server.yml ps

echo ""
echo "📋 Database Logs:"
docker compose -f docker-compose.server.yml logs db

echo ""
echo "📋 Application Logs:"
docker compose -f docker-compose.server.yml logs app

echo ""
echo "🔍 Testing Database Connection:"
if docker compose -f docker-compose.server.yml exec -T db mysqladmin ping -h"localhost" --silent 2>/dev/null; then
    echo "✅ Database connection successful"
else
    echo "❌ Database connection failed"
fi

echo ""
echo "🌐 Testing Application:"
if curl -f http://localhost:8000 > /dev/null 2>&1; then
    echo "✅ Application is responding"
else
    echo "❌ Application is not responding"
fi 