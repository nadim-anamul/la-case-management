#!/bin/bash

echo "🚀 Starting Laravel PDF Generator"
echo "================================"

# Check if containers are running
if docker compose ps | grep -q "laravel-app"; then
    echo "✅ Application is already running"
    echo "🌐 Access at: http://localhost:8000"
    exit 0
fi

# Start containers
echo "🐳 Starting containers..."
docker compose up -d

# Wait for application to be ready
echo "⏳ Waiting for application to be ready..."
sleep 10

echo ""
echo "✅ Application started successfully!"
echo "🌐 Access at: http://localhost:8000"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop: docker compose down"
echo "   Restart: docker compose restart"
echo "" 