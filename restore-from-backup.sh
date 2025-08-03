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

# Function to backup current database before restore
backup_current_database() {
    print_status "💾 Creating backup of current database..."
    local timestamp=$(date +"%Y%m%d_%H%M%S")
    local backup_file="pre_restore_backup_${timestamp}.sql"
    
    if docker compose -f docker-compose.server.yml exec -T db mysqldump -u laravel -ppassword laravel > "$backup_file" 2>/dev/null; then
        print_success "✅ Current database backup created: $backup_file"
    else
        print_warning "⚠️ Could not create backup of current database (might be empty)"
    fi
}

# Function to restore database from backup
restore_database() {
    local backup_file=$1
    
    if [ ! -f "$backup_file" ]; then
        print_error "❌ Backup file not found: $backup_file"
        exit 1
    fi
    
    print_status "🔄 Restoring database from backup: $backup_file"
    
    # Drop and recreate database to ensure clean restore
    print_status "🧹 Dropping and recreating database..."
    docker compose -f docker-compose.server.yml exec -T db mysql -u laravel -ppassword -e "DROP DATABASE IF EXISTS laravel; CREATE DATABASE laravel;"
    
    # Restore from backup
    if docker compose -f docker-compose.server.yml exec -T db mysql -u laravel -ppassword laravel < "$backup_file"; then
        print_success "✅ Database restored successfully from: $backup_file"
    else
        print_error "❌ Failed to restore database from: $backup_file"
        exit 1
    fi
}

# Function to check application health after restore
check_application_health() {
    print_status "🔍 Checking application health after restore..."
    local max_attempts=15
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if curl -f http://localhost:8000 > /dev/null 2>&1; then
            print_success "✅ Application is responding after restore"
            return 0
        else
            print_warning "⏳ Waiting for application... (attempt $attempt/$max_attempts)"
            sleep 3
            attempt=$((attempt + 1))
        fi
    done
    
    print_error "❌ Application failed to start after restore"
    print_status "📋 Container logs:"
    docker compose -f docker-compose.server.yml logs app
    return 1
}

# Main restore process
main() {
    if [ $# -eq 0 ]; then
        print_error "❌ Usage: $0 <backup_file>"
        echo ""
        print_status "Available backup files:"
        ls -la backup_*.sql 2>/dev/null || echo "No backup files found"
        echo ""
        print_status "Example: $0 backup_20241201_143022.sql"
        exit 1
    fi
    
    local backup_file=$1
    
    echo ""
    print_status "🔄 Starting Database Restore Process"
    echo "========================================"
    
    # Check if containers are running
    if ! check_container "laravel-db"; then
        print_error "❌ Database container is not running"
        print_status "Starting containers..."
        docker compose -f docker-compose.server.yml up -d db
    fi
    
    # Wait for database to be ready
    if ! wait_for_database; then
        print_error "❌ Database failed to start properly"
        exit 1
    fi
    
    # Backup current database before restore
    backup_current_database
    
    # Restore database from backup
    restore_database "$backup_file"
    
    # Check application health
    if ! check_application_health; then
        print_error "❌ Application health check failed after restore"
        exit 1
    fi
    
    echo ""
    print_success "🎉 Database restore completed successfully!"
    echo ""
    print_status "📱 Check the application: http://152.42.201.131:8000"
    echo ""
    print_status "✅ Restore summary:"
    echo "   - Restored from: $backup_file"
    echo "   - Current backup created before restore"
    echo "   - Application health verified"
    echo ""
    print_status "🔧 Useful commands:"
    echo "   - Check logs: docker compose -f docker-compose.server.yml logs -f"
    echo "   - View all backups: ls -la backup_*.sql"
    echo ""
}

# Trap to handle script interruption
trap 'print_error "❌ Restore interrupted"; exit 1' INT TERM

# Run main restore
main "$@" 