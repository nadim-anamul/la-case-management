#!/bin/bash

echo "🔧 Laravel PDF Generator - Fix Dependencies"
echo "==========================================="

# Check if Docker containers are running
if ! docker compose ps | grep -q "laravel-pdf-generator-app"; then
    echo "❌ Application container is not running. Please start Docker containers first:"
    echo "   docker compose up -d"
    exit 1
fi

echo "📦 Installing PHP dependencies..."
docker compose exec app composer install --no-interaction

echo "📦 Installing Node.js dependencies..."
docker compose exec app npm install

echo "🎨 Building frontend assets..."
docker compose exec app npm run build

echo "🔐 Setting proper permissions..."
docker compose exec app chmod -R 775 storage bootstrap/cache

echo ""
echo "✅ Dependencies fixed successfully!"
echo ""
echo "🌐 Your application should now be accessible at: http://localhost:8000"
echo "" 