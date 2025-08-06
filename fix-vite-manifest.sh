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

print_status "🔧 Fixing Vite Manifest Issue..."
echo "======================================"

# Check if we're in the container or need to run via docker
if [ -f "/var/www/public/build/.vite/manifest.json" ]; then
    # We're inside the container
    print_status "📁 Inside container - fixing manifest location..."
    
    if [ -f "/var/www/public/build/.vite/manifest.json" ] && [ ! -f "/var/www/public/build/manifest.json" ]; then
        cp /var/www/public/build/.vite/manifest.json /var/www/public/build/manifest.json
        print_success "✅ Manifest file copied to correct location"
    else
        print_warning "⚠️ Manifest file already in correct location or missing"
    fi
else
    # We're outside the container, need to run via docker
    print_status "🐳 Running via Docker container..."
    
    if docker compose -f docker-compose.server.yml exec -T app test -f /var/www/public/build/.vite/manifest.json; then
        if ! docker compose -f docker-compose.server.yml exec -T app test -f /var/www/public/build/manifest.json; then
            docker compose -f docker-compose.server.yml exec -T app cp /var/www/public/build/.vite/manifest.json /var/www/public/build/manifest.json
            print_success "✅ Manifest file copied to correct location"
        else
            print_warning "⚠️ Manifest file already in correct location"
        fi
    else
        print_error "❌ No manifest file found in .vite directory"
        print_status "📋 Checking build directory contents:"
        docker compose -f docker-compose.server.yml exec -T app ls -la /var/www/public/build/
        exit 1
    fi
fi

print_success "🎉 Vite manifest issue fixed!"
echo ""
print_status "📱 Test the application: http://152.42.201.131:8000"
echo ""
print_status "🔧 This script can be run after any npm run build to ensure the manifest is in the correct location" 