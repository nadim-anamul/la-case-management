#!/bin/bash

echo "🚀 Laravel PDF Generator - Simple Docker Setup"
echo "=============================================="

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

# Ensure MySQL configuration in .env
echo "🔧 Ensuring MySQL database configuration..."
docker compose exec app sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env 2>/dev/null || true
docker compose exec app sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=db/' .env 2>/dev/null || true
docker compose exec app sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env 2>/dev/null || true
docker compose exec app sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=laravel/' .env 2>/dev/null || true
docker compose exec app sed -i 's/# DB_USERNAME=root/DB_USERNAME=laravel/' .env 2>/dev/null || true
docker compose exec app sed -i 's/# DB_PASSWORD=/DB_PASSWORD=password/' .env 2>/dev/null || true

# Stop any existing containers
echo "🛑 Stopping existing containers..."
docker compose down

# Build and start containers
echo "🐳 Building and starting containers..."
docker compose up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 15

# Wait for database to be ready
echo "⏳ Waiting for database..."
max_attempts=20
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

# Setup Laravel application
echo "🔧 Setting up Laravel application..."

# Clear any cached configurations
echo "🧹 Clearing cached configurations..."
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear

# Generate application key
echo "🔑 Generating application key..."
docker compose exec app php artisan key:generate

# Run migrations and seeders with fresh data
echo "🗄️  Running database migrations and seeders..."
docker compose exec app php artisan migrate:fresh --seed

# Create storage link
echo "🔗 Creating storage link..."
docker compose exec app php artisan storage:link

# Set permissions
echo "🔐 Setting proper permissions..."
docker compose exec app chmod -R 775 storage bootstrap/cache

# Verify data population
echo "📊 Verifying data population..."
record_count=$(docker compose exec app php artisan tinker --execute="echo App\Models\Compensation::count();" 2>/dev/null | tail -1)
if [ "$record_count" -ge 4 ]; then
    echo "✅ Successfully populated with $record_count compensation records"
else
    echo "⚠️  Warning: Only $record_count records found (expected 4)"
fi

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📱 Access your application:"
echo "   Web Application: http://localhost:8000"
echo "   Compensation List: http://localhost:8000/compensations"
echo "   Database: localhost:3307"
echo ""
echo "📊 Demo data includes:"
echo "   • 4 comprehensive compensation records"
echo "   • SA and RS-based cases"
echo "   • Multiple applicants and ownership details"
echo "   • Complete form data for testing"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop services: docker compose down"
echo "   Restart services: docker compose restart"
echo "   Execute commands: docker compose exec app php artisan [command]"
echo "" 