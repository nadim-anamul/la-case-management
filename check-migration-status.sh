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

# Function to wait for database to be ready
wait_for_database() {
    print_status "🔍 Waiting for database to be ready..."
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if docker compose -f docker-compose.server.yml exec -T db mysqladmin ping -h localhost -u laravel -ppassword --silent; then
            print_success "✅ Database is ready"
            return 0
        else
            print_warning "⏳ Waiting for database... (attempt $attempt/$max_attempts)"
            sleep 2
            attempt=$((attempt + 1))
        fi
    done
    
    print_error "❌ Database failed to start"
    return 1
}

# Function to check migration status
check_migration_status() {
    print_status "🗄️ Checking migration status..."
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan migrate:status --no-ansi; then
        print_success "✅ Migration status retrieved successfully"
    else
        print_error "❌ Failed to get migration status"
        return 1
    fi
}

# Function to check database connection
check_database_connection() {
    print_status "🔌 Testing database connection..."
    
    if docker compose -f docker-compose.server.yml exec -T app php artisan tinker --execute="echo 'Database connection: ' . (DB::connection()->getPdo() ? 'OK' : 'FAILED');" 2>/dev/null; then
        print_success "✅ Database connection is working"
    else
        print_error "❌ Database connection failed"
        return 1
    fi
}

# Function to check table structure
check_table_structure() {
    print_status "📋 Checking table structure..."
    
    local tables=("users" "compensations" "order_sheets" "migrations" "jobs" "cache")
    
    for table in "${tables[@]}"; do
        if docker compose -f docker-compose.server.yml exec -T db mysql -u laravel -ppassword laravel -e "DESCRIBE $table;" 2>/dev/null | grep -q .; then
            print_success "✅ Table '$table' exists"
        else
            print_warning "⚠️ Table '$table' does not exist or is empty"
        fi
    done
}

# Function to check data counts
check_data_counts() {
    print_status "📊 Checking data counts..."
    
    local tables=("users" "compensations" "order_sheets")
    
    for table in "${tables[@]}"; do
        local count=$(docker compose -f docker-compose.server.yml exec -T db mysql -u laravel -ppassword laravel -e "SELECT COUNT(*) FROM $table;" 2>/dev/null | tail -n 1 || echo "0")
        print_status "   $table: $count records"
    done
}

# Function to check application health
check_application_health() {
    print_status "🔍 Checking application health..."
    
    if curl -f http://localhost:8000 > /dev/null 2>&1; then
        print_success "✅ Application is responding"
        return 0
    else
        print_error "❌ Application is not responding"
        return 1
    fi
}

# Function to show recent logs
show_recent_logs() {
    print_status "📋 Recent application logs:"
    docker compose -f docker-compose.server.yml logs --tail=20 app
}

# Main check process
main() {
    echo ""
    print_status "🔍 Database and Migration Status Checker"
    echo "============================================="
    
    # Check if containers are running
    if ! check_container "laravel-db"; then
        print_error "❌ Database container is not running"
        print_status "Starting database container..."
        docker compose -f docker-compose.server.yml up -d db
    fi
    
    if ! check_container "laravel-app"; then
        print_error "❌ Application container is not running"
        print_status "Starting application container..."
        docker compose -f docker-compose.server.yml up -d app
    fi
    
    # Wait for database to be ready
    if ! wait_for_database; then
        print_error "❌ Database failed to start properly"
        exit 1
    fi
    
    echo ""
    print_status "📊 Running comprehensive checks..."
    echo ""
    
    # Check database connection
    check_database_connection
    
    echo ""
    
    # Check table structure
    check_table_structure
    
    echo ""
    
    # Check data counts
    check_data_counts
    
    echo ""
    
    # Check migration status
    check_migration_status
    
    echo ""
    
    # Check application health
    check_application_health
    
    echo ""
    print_success "🎉 Status check completed!"
    echo ""
    print_status "🔧 Useful commands:"
    echo "   - View logs: docker compose -f docker-compose.server.yml logs -f"
    echo "   - Check migrations: docker compose -f docker-compose.server.yml exec app php artisan migrate:status"
    echo "   - Run migrations: docker compose -f docker-compose.server.yml exec app php artisan migrate --force"
    echo "   - Run seeders: docker compose -f docker-compose.server.yml exec app php artisan db:seed --force"
    echo ""
}

# Trap to handle script interruption
trap 'print_error "❌ Check interrupted"; exit 1' INT TERM

# Run main check
main "$@" 