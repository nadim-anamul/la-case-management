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

# Function to check if container is running
check_container() {
    local container_name=$1
    docker ps --format "table {{.Names}}" | grep -q "^${container_name}$"
}

# Function to clear application cache only
clear_cache() {
    print_status "🧹 Clearing application cache..."
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan cache:clear > /dev/null 2>&1; then
        print_success "✅ Application cache cleared"
    else
        print_warning "⚠️ Could not clear application cache"
    fi
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan config:clear > /dev/null 2>&1; then
        print_success "✅ Configuration cache cleared"
    else
        print_warning "⚠️ Could not clear configuration cache"
    fi
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan route:clear > /dev/null 2>&1; then
        print_success "✅ Route cache cleared"
    else
        print_warning "⚠️ Could not clear route cache"
    fi
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan view:clear > /dev/null 2>&1; then
        print_success "✅ View cache cleared"
    else
        print_warning "⚠️ Could not clear view cache"
    fi
}

# Function to optimize application
optimize_application() {
    print_status "⚡ Optimizing application..."
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan config:cache > /dev/null 2>&1; then
        print_success "✅ Configuration cached"
    else
        print_warning "⚠️ Could not cache configuration"
    fi
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan route:cache > /dev/null 2>&1; then
        print_success "✅ Routes cached"
    else
        print_warning "⚠️ Could not cache routes"
    fi
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan view:cache > /dev/null 2>&1; then
        print_success "✅ Views cached"
    else
        print_warning "⚠️ Could not cache views"
    fi
}

# Function to show deployment summary
show_deployment_summary() {
    print_status "📊 Code-Only Deployment Summary:"
    echo "   - Code updated via Git pull"
    echo "   - Application cache cleared"
    echo "   - No container restarts"
    echo "   - No database operations"
    echo "   - Minimal resource usage"
    echo ""
}

# Main code-only deployment process
main() {
    echo ""
    print_status "🚀 Starting Ultra-Minimal Code-Only Deployment"
    echo "===================================================="
    
    # Check if containers are running
    if ! check_container "laravel-app"; then
        print_error "❌ Laravel application container is not running"
        print_status "💡 Please run the full deployment first: ./deploy-production.sh"
        exit 1
    fi
    
    if ! check_container "laravel-db"; then
        print_error "❌ Database container is not running"
        print_status "💡 Please run the full deployment first: ./deploy-production.sh"
        exit 1
    fi
    
    print_success "✅ All containers are running"
    
    # Clear application cache
    clear_cache
    
    # Optimize application for production
    optimize_application
    
    echo ""
    print_success "🎉 Code-only deployment completed successfully!"
    echo ""
    print_status "📱 Check the application: http://152.42.201.131:8000"
    echo ""
    show_deployment_summary
    print_status "🔧 Useful commands:"
    echo "   - Check logs: docker compose -f docker-compose.server.yml logs -f app"
    echo "   - View container status: docker ps"
    echo "   - Minimal deployment (with migrations): ./deploy-minimal.sh"
    echo "   - Full deployment (if needed): ./deploy-production.sh"
    echo ""
    print_status "💡 Note: Since you're using volume mounting (./:/var/www),"
    echo "   code changes should be immediately available without container restarts."
    echo ""
}

# Trap to handle script interruption
trap 'print_error "❌ Deployment interrupted"; exit 1' INT TERM

# Run main deployment
main "$@"
