#!/bin/bash

# Set error handling
set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}$1${NC}"
}

print_success() {
    echo -e "${GREEN}$1${NC}"
}

print_warning() {
    echo -e "${YELLOW}$1${NC}"
}

print_error() {
    echo -e "${RED}$1${NC}"
}

print_status "🔧 Fixing Production CDN CSS Issues..."
echo "============================================="

# Clear Laravel cache
print_status "🧹 Clearing Laravel cache..."
docker compose -f docker-compose.server.yml exec -T app php artisan cache:clear
docker compose -f docker-compose.server.yml exec -T app php artisan config:clear
docker compose -f docker-compose.server.yml exec -T app php artisan view:clear
docker compose -f docker-compose.server.yml exec -T app php artisan route:clear
print_success "✅ Laravel cache cleared"

# Restart the application container to ensure changes are loaded
print_status "🔄 Restarting application container..."
docker compose -f docker-compose.server.yml restart app
print_success "✅ Application container restarted"

# Wait for container to be ready
print_status "⏳ Waiting for application to be ready..."
sleep 10

# Check application health
print_status "🔍 Checking application health..."
if docker compose -f docker-compose.server.yml exec -T app php artisan --version > /dev/null 2>&1; then
    print_success "✅ Application is healthy"
else
    print_warning "⚠️ Application might still be starting up"
fi

print_success "🎉 CDN CSS fix completed!"
echo ""
print_status "📱 Check the application: http://152.42.201.131:8000"
echo ""
print_status "🔧 Browser cache hint:"
echo "   - Press Ctrl+F5 (or Cmd+Shift+R on Mac) to hard refresh"
echo "   - Or clear browser cache manually"
echo ""
print_status "📋 What was fixed:"
echo "   - Added safelist to Tailwind CDN config"
echo "   - Included all progress indicator CSS classes"
echo "   - Cleared Laravel cache"
echo "   - Restarted application container"
echo "" 