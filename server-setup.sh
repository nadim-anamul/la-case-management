#!/bin/bash

echo "🚀 Server Setup for Laravel PDF Generator"
echo "========================================="

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

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Copying .env.example to .env"
    cp .env.example .env
    echo "✅ Environment file created"
else
    echo "✅ .env file already exists"
fi

# Stop any existing containers
echo "🛑 Stopping existing containers..."
docker compose down

# Clean up everything
echo "🧹 Cleaning up everything..."
docker system prune -a -f

# Use the server-specific docker-compose file
echo "🐳 Building and starting containers with server configuration..."
docker compose -f docker-compose.server.yml up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 30

# Wait for database to be ready
echo "⏳ Waiting for database..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    if docker compose exec db mysqladmin ping -h"localhost" --silent 2>/dev/null; then
        echo "✅ Database is ready"
        break
    else
        echo "⏳ Waiting for database... (attempt $attempt/$max_attempts)"
        sleep 3
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "❌ Database failed to start"
    docker compose logs db
    exit 1
fi

# Check if app container is running
echo "🔍 Checking application container..."
sleep 10

# Verify the application is working
echo "✅ Verifying application..."
if curl -f http://localhost:8000 > /dev/null 2>&1; then
    echo "✅ Application is responding"
else
    echo "⚠️  Application may still be starting up"
fi

echo ""
echo "🎉 Server setup completed!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://152.42.201.131:8000"
echo "   Compensation List: http://152.42.201.131:8000/compensations"
echo "   Database: localhost:3307"
echo ""
echo "📊 Demo data should be automatically loaded"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop services: docker compose down"
echo "   Restart services: docker compose restart"
echo "" 