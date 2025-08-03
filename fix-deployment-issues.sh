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

# Function to fix storage link issues
fix_storage_link() {
    print_status "🔧 Fixing storage link issues..."
    
    # Remove existing storage link if it exists
    if docker compose -f docker-compose.server.yml exec -T app test -L public/storage 2>/dev/null; then
        print_status "Removing existing storage link..."
        docker compose -f docker-compose.server.yml exec -T app rm -f public/storage
    fi
    
    # Create new storage link
    print_status "Creating new storage link..."
    docker compose -f docker-compose.server.yml exec -T app php artisan storage:link
    
    print_success "✅ Storage link fixed"
}

# Function to fix permissions
fix_permissions() {
    print_status "🔧 Fixing permissions..."
    
    docker compose -f docker-compose.server.yml exec -T app chmod -R 775 storage bootstrap/cache public/build
    
    print_success "✅ Permissions fixed"
}

# Function to clear caches
clear_caches() {
    print_status "🧹 Clearing application caches..."
    
    docker compose -f docker-compose.server.yml exec -T app php artisan config:clear
    docker compose -f docker-compose.server.yml exec -T app php artisan cache:clear
    docker compose -f docker-compose.server.yml exec -T app php artisan view:clear
    docker compose -f docker-compose.server.yml exec -T app php artisan route:clear
    
    print_success "✅ Caches cleared"
}

# Function to restart application
restart_application() {
    print_status "🔄 Restarting application container..."
    
    docker compose -f docker-compose.server.yml restart app
    
    # Wait for application to be ready
    print_status "⏳ Waiting for application to restart..."
    local attempts=0
    while [ $attempts -lt 30 ]; do
        if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 | grep -q "200"; then
            print_success "✅ Application is responding after restart"
            return 0
        else
            print_warning "⏳ Waiting for application... (attempt $((attempts + 1))/30)"
            sleep 2
            attempts=$((attempts + 1))
        fi
    done
    
    print_error "❌ Application failed to restart"
    return 1
}

# Function to check application health
check_application_health() {
    print_status "🔍 Checking application health..."
    
    if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 | grep -q "200"; then
        print_success "✅ Application is responding with HTTP 200"
        return 0
    else
        print_error "❌ Application is not responding"
        return 1
    fi
}

# Function to show diagnostic information
show_diagnostics() {
    print_status "📊 Diagnostic Information:"
    echo ""
    
    print_status "Container Status:"
    docker ps | grep laravel
    echo ""
    
    print_status "Application Logs (last 20 lines):"
    docker compose -f docker-compose.server.yml logs --tail=20 app
    echo ""
    
    print_status "Database Logs (last 10 lines):"
    docker compose -f docker-compose.server.yml logs --tail=10 db
    echo ""
}

# Main fix process
main() {
    echo ""
    print_status "🔧 Deployment Issue Fixer"
    echo "============================="
    
    # Check if containers are running
    if ! docker ps | grep -q laravel-app; then
        print_error "❌ Application container is not running"
        print_status "Starting containers..."
        docker compose -f docker-compose.server.yml up -d
        sleep 10
    fi
    
    # Show current diagnostics
    show_diagnostics
    
    # Fix storage link issues
    fix_storage_link
    
    # Fix permissions
    fix_permissions
    
    # Clear caches
    clear_caches
    
    # Restart application
    if restart_application; then
        print_success "🎉 Deployment issues fixed successfully!"
        echo ""
        print_status "📱 Check the application: http://152.42.201.131:8000"
    else
        print_error "❌ Failed to fix deployment issues"
        echo ""
        print_status "📋 Final diagnostics:"
        show_diagnostics
        exit 1
    fi
}

# Trap to handle script interruption
trap 'print_error "❌ Fix interrupted"; exit 1' INT TERM

# Run main fix
main "$@" 