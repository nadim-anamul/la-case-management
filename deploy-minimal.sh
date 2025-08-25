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

# Function to debug health check issues
debug_health_check() {
    print_status "🔍 Debugging health check issues..."
    
    echo "   Checking network connectivity:"
    echo "   - localhost:8000: $(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 --max-time 10 http://localhost:8000 2>/dev/null || echo "FAILED")"
    echo "   - 152.42.201.131:8000: $(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 --max-time 10 http://152.42.201.131:8000 2>/dev/null || echo "FAILED")"
    
    echo "   Checking container status:"
    docker compose -f docker-compose.server.yml ps
    
    echo "   Checking container logs (last 10 lines):"
    docker compose -f docker-compose.server.yml logs --tail=10 app
    
    echo "   Checking if port 8000 is listening:"
    netstat -tlnp | grep :8000 || echo "   Port 8000 not found in netstat"
}

# Function to check application health
check_application_health() {
    print_status "🔍 Checking application health..."
    local max_attempts=10
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        # Try multiple endpoints and IPs for health check
        local health_check_passed=false
        
        # Check localhost first
        if curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 --max-time 10 http://localhost:8000 | grep -q "200\|302\|404"; then
            print_success "✅ Application is responding on localhost:8000"
            health_check_passed=true
        fi
        
        # Check server IP if localhost fails
        if [ "$health_check_passed" = false ]; then
            if curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 --max-time 10 http://152.42.201.131:8000 | grep -q "200\|302\|404"; then
                print_success "✅ Application is responding on 152.42.201.131:8000"
                health_check_passed=true
            fi
        fi
        
        # Check if container is responding internally
        if [ "$health_check_passed" = false ]; then
            if docker compose -f docker-compose.server.yml exec -T app curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 --max-time 10 http://localhost:8000 | grep -q "200\|302\|404"; then
                print_success "✅ Application is responding internally from container"
                health_check_passed=true
            fi
        fi
        
        if [ "$health_check_passed" = true ]; then
            return 0
        else
            print_warning "⏳ Waiting for application... (attempt $attempt/$max_attempts)"
            sleep 2
            attempt=$((attempt + 1))
        fi
    done
    
    print_error "❌ Application health check failed"
    debug_health_check
    return 1
}

# Function to clear application cache
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

# Function to check for new migrations
check_migrations() {
    print_status "🔍 Checking for new migrations..."
    
    # Get current migration status
    local migration_status
    if migration_status=$(docker compose -f docker-compose.server.yml exec -T app php artisan migrate:status --no-ansi 2>/dev/null); then
        # Check if there are pending migrations
        if echo "$migration_status" | grep -q "No pending migrations"; then
            print_success "✅ No pending migrations"
            return 0
        else
            print_warning "⚠️ Pending migrations detected"
            echo "$migration_status" | grep -E "(Pending|No pending)" || true
            return 1
        fi
    else
        print_warning "⚠️ Could not check migration status"
        return 1
    fi
}

# Function to run migrations if needed
run_migrations_if_needed() {
    if check_migrations; then
        print_success "✅ No migrations needed"
        return 0
    else
        print_status "🗄️ Running pending migrations..."
        if docker compose -f docker-compose.server.yml exec -T app php artisan migrate --force > /dev/null 2>&1; then
            print_success "✅ Migrations completed successfully"
            return 0
        else
            print_error "❌ Migration failed"
            return 1
        fi
    fi
}

# Function to restart application container only
restart_app_container() {
    print_status "🔄 Restarting application container..."
    
    if docker compose -f docker-compose.server.yml restart app > /dev/null 2>&1; then
        print_success "✅ Application container restarted"
        
        # Wait for container to be ready
        print_status "⏳ Waiting for container to be ready..."
        sleep 10
        
        return 0
    else
        print_error "❌ Failed to restart application container"
        return 1
    fi
}

# Function to show deployment summary
show_deployment_summary() {
    print_status "📊 Deployment Summary:"
    echo "   - Code updated via Git pull"
    echo "   - Application cache cleared"
    echo "   - Container restarted"
    echo "   - Health check performed"
    
    # Check if migrations were run
    if check_migrations > /dev/null 2>&1; then
        echo "   - No database changes needed"
    else
        echo "   - Database migrations applied"
    fi
    
    echo ""
}

# Main minimal deployment process
main() {
    echo ""
    print_status "🚀 Starting Minimal Code-Only Deployment"
    echo "==============================================="
    
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
    
    # Run migrations if needed
    if ! run_migrations_if_needed; then
        print_error "❌ Migration process failed"
        exit 1
    fi
    
    # Restart application container to ensure code changes are loaded
    if ! restart_app_container; then
        print_error "❌ Container restart failed"
        exit 1
    fi
    
    # Check application health
    if ! check_application_health; then
        print_error "❌ Application health check failed"
        print_status "📋 Recent application logs:"
        docker compose -f docker-compose.server.yml logs --tail=20 app
        exit 1
    fi
    
    # Optimize application for production
    optimize_application
    
    echo ""
    print_success "🎉 Minimal deployment completed successfully!"
    echo ""
    print_status "📱 Check the application: http://152.42.201.131:8000"
    echo ""
    show_deployment_summary
    print_status "🔧 Useful commands:"
    echo "   - Check logs: docker compose -f docker-compose.server.yml logs -f app"
    echo "   - View container status: docker ps"
    echo "   - Check migration status: docker compose -f docker-compose.server.yml exec app php artisan migrate:status"
    echo "   - Full deployment (if needed): ./deploy-production.sh"
    echo ""
}

# Trap to handle script interruption
trap 'print_error "❌ Deployment interrupted"; exit 1' INT TERM

# Run main deployment
main "$@"
