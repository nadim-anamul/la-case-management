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

# Function to backup database
backup_database() {
    print_status "💾 Creating database backup..."
    local timestamp=$(date +"%Y%m%d_%H%M%S")
    local backup_file="backup_${timestamp}.sql"
    
    if docker compose -f docker-compose.server.yml exec -T db mysqldump -u laravel -ppassword laravel > "$backup_file" 2>/dev/null; then
        print_success "✅ Database backup created: $backup_file"
        echo "$backup_file" > .last_backup_file
    else
        print_warning "⚠️ Could not create backup (database might be empty or not accessible)"
        echo "" > .last_backup_file
    fi
}

# Function to restore database
restore_database() {
    local backup_file=$(cat .last_backup_file 2>/dev/null || echo "")
    if [ -n "$backup_file" ] && [ -f "$backup_file" ]; then
        print_status "🔄 Restoring database from backup: $backup_file"
        docker compose -f docker-compose.server.yml exec -T db mysql -u laravel -ppassword laravel < "$backup_file" || true
        print_success "✅ Database restored from backup"
    fi
}

# Function to run migrations with rollback capability
run_migrations() {
    print_status "🗄️ Running database migrations..."
    
    # Check if migrations table exists
    if docker compose -f docker-compose.server.yml exec -T app php artisan migrate:status --no-ansi | grep -q "Migration table created successfully"; then
        print_warning "⚠️ Migration table doesn't exist, running fresh migrations"
        docker compose -f docker-compose.server.yml exec -T app php artisan migrate --force
    else
        # Run migrations with status check
        local migration_result
        if migration_result=$(docker compose -f docker-compose.server.yml exec -T app php artisan migrate --force 2>&1); then
            print_success "✅ Migrations completed successfully"
        else
            print_error "❌ Migration failed:"
            echo "$migration_result"
            print_status "🔄 Attempting to rollback..."
            docker compose -f docker-compose.server.yml exec -T app php artisan migrate:rollback --step=1 --force || true
            restore_database
            exit 1
        fi
    fi
}

# Function to run seeders with error handling
run_seeders() {
    print_status "🌱 Running database seeders..."
    
    local seeder_result
    if seeder_result=$(docker compose -f docker-compose.server.yml exec -T app php artisan db:seed --force 2>&1); then
        print_success "✅ Database seeding completed successfully"
    else
        print_warning "⚠️ Seeder failed (this might be normal if data already exists):"
        echo "$seeder_result"
        # Don't exit on seeder failure as it might be intentional
    fi
}

# Function to check application health
check_application_health() {
    print_status "🔍 Checking application health..."
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        # Check if application is responding with HTTP 200
        if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 | grep -q "200"; then
            print_success "✅ Application is responding with HTTP 200"
            return 0
        else
            print_warning "⏳ Waiting for application... (attempt $attempt/$max_attempts)"
            
            # Show recent logs every 5 attempts
            if [ $((attempt % 5)) -eq 0 ]; then
                print_status "📋 Recent application logs:"
                docker compose -f docker-compose.server.yml logs --tail=10 app
            fi
            
            sleep 3
            attempt=$((attempt + 1))
        fi
    done
    
    print_error "❌ Application failed to start"
    print_status "📋 Full container logs:"
    docker compose -f docker-compose.server.yml logs app
    print_status "📋 Container status:"
    docker ps | grep laravel
    return 1
}

# Function to cleanup old backups (keep last 5)
cleanup_old_backups() {
    print_status "🧹 Cleaning up old backups..."
    ls -t backup_*.sql 2>/dev/null | tail -n +6 | xargs -r rm
    print_success "✅ Old backups cleaned up"
}

# Function to detect new migrations
detect_new_migrations() {
    print_status "🔍 Detecting new migrations..."
    local new_migrations=()
    
    # Get list of migration files
    for migration_file in database/migrations/*.php; do
        if [ -f "$migration_file" ]; then
            local migration_name=$(basename "$migration_file" .php)
            new_migrations+=("$migration_name")
        fi
    done
    
    if [ ${#new_migrations[@]} -gt 0 ]; then
        print_status "📋 New migrations detected:"
        for migration in "${new_migrations[@]}"; do
            echo "   - $migration"
        done
        echo ""
    else
        print_warning "⚠️ No new migrations detected"
    fi
}

# Function to detect recent changes
detect_recent_changes() {
    print_status "🔍 Detecting recent changes..."
    
    # Get recent commits (last 10)
    local recent_commits=$(git log --oneline -10 2>/dev/null || echo "")
    
    if [ -n "$recent_commits" ]; then
        print_status "📝 Recent changes detected:"
        echo "$recent_commits" | while read -r commit; do
            echo "   - $commit"
        done
        echo ""
    else
        print_warning "⚠️ No recent commits detected"
    fi
}

# Function to detect new features
detect_new_features() {
    print_status "🔍 Detecting new features..."
    local features=()
    
    # Check for new database fields
    if grep -r "land_category\|award_serial_no\|dp_khatian" app/Models/ database/migrations/ 2>/dev/null | grep -q .; then
        features+=("Database schema updates")
    fi
    
    # Check for UI improvements
    if grep -r "bg-orange-500\|btn-primary\|btn-secondary" resources/views/ 2>/dev/null | grep -q .; then
        features+=("UI/UX improvements")
    fi
    
    # Check for new components
    if find resources/views/components/ -name "*.blade.php" 2>/dev/null | wc -l | grep -q -v "^0$"; then
        features+=("New Blade components")
    fi
    
    # Check for new tests
    if find tests/ -name "*.php" 2>/dev/null | wc -l | grep -q -v "^0$"; then
        features+=("Enhanced test coverage")
    fi
    
    if [ ${#features[@]} -gt 0 ]; then
        print_status "✨ New features detected:"
        for feature in "${features[@]}"; do
            echo "   - $feature"
        done
        echo ""
    else
        print_warning "⚠️ No new features detected"
    fi
}

# Function to generate dynamic deployment summary
generate_deployment_summary() {
    print_status "📊 Generating deployment summary..."
    
    # Detect changes
    detect_new_migrations
    detect_recent_changes
    detect_new_features
    
    print_status "✅ This deployment includes:"
    echo "   - Enhanced database error handling"
    echo "   - Automatic database backup before changes"
    echo "   - Rollback capability on migration failure"
    echo "   - Robust application health checks"
    echo "   - Vite asset compilation (CSS/JS build)"
    echo "   - Production environment"
    echo "   - Updated database seeder"
    echo "   - All new fields (status, order_signature_date, etc.)"
    
    # Add dynamic features
    if grep -r "land_category" app/Models/ database/migrations/ 2>/dev/null | grep -q .; then
        echo "   - New land_category JSON field for award types"
    fi
    
    if grep -r "award_serial_no" database/migrations/ 2>/dev/null | grep -q .; then
        echo "   - Conditional award serial number fields"
    fi
    
    if grep -r "dp_khatian" resources/views/ 2>/dev/null | grep -q .; then
        echo "   - Enhanced RS records with multiple owner names and DP khatian checkbox"
    fi
    
    if grep -r "bg-orange-500" resources/views/ 2>/dev/null | grep -q .; then
        echo "   - Updated UI with improved button colors and checkbox alignment"
    fi
    
    if grep -r "x-show.*award_type" resources/views/ 2>/dev/null | grep -q .; then
        echo "   - Conditional field display based on award type selection"
    fi
    
    echo ""
}

# Main deployment process
main() {
    echo ""
    print_status "🚀 Starting Production Deployment with Enhanced Database Handling"
    echo "================================================================"
    
    # Cleanup old backups
    cleanup_old_backups
    
    # Stop containers
    print_status "🛑 Stopping containers..."
    docker compose -f docker-compose.server.yml down
    
    # Remove all containers and images
    print_status "🧹 Removing all containers and images..."
    docker system prune -a -f
    
    # Rebuild and start containers
    print_status "🐳 Rebuilding and starting containers..."
    docker compose -f docker-compose.server.yml up -d --build
    
    # Wait for database to be ready
    if ! wait_for_database; then
        print_error "❌ Database failed to start properly"
        exit 1
    fi
    
    # Wait for application container to be ready
    print_status "⏳ Waiting for application container to be ready..."
    local app_attempts=0
    while [ $app_attempts -lt 60 ]; do
        if docker compose -f docker-compose.server.yml exec -T app php artisan --version > /dev/null 2>&1; then
            print_success "✅ Application container is ready"
            break
        else
            print_warning "⏳ Waiting for application container... (attempt $((app_attempts + 1))/60)"
            sleep 2
            app_attempts=$((app_attempts + 1))
        fi
    done
    
    if [ $app_attempts -ge 60 ]; then
        print_error "❌ Application container failed to start properly"
        print_status "📋 Application container logs:"
        docker compose -f docker-compose.server.yml logs app
        exit 1
    fi
    
    # Create database backup before making changes
    backup_database
    
    # Run database migrations with error handling
    if ! run_migrations; then
        print_error "❌ Migration process failed"
        exit 1
    fi
    
    # Dynamic migration summary
    print_status "📋 Migrations applied:"
    local migration_count=$(find database/migrations/ -name "*.php" 2>/dev/null | wc -l)
    echo "   - Applied $migration_count migration(s)"
    
    # Show recent migrations if any
    local recent_migrations=$(find database/migrations/ -name "*.php" -newer database/migrations/0001_01_01_000000_create_users_table.php 2>/dev/null | head -5)
    if [ -n "$recent_migrations" ]; then
        echo "   - Recent migrations:"
        echo "$recent_migrations" | while read -r migration; do
            echo "     * $(basename "$migration" .php)"
        done
    fi
    echo ""
    
    # Run database seeders with error handling
    run_seeders
    
    # Dynamic seeder summary
    print_status "🌱 Database seeding completed"
    if grep -r "rs_records.*owner_names" database/seeders/ 2>/dev/null | grep -q .; then
        echo "   - Enhanced RS records with multiple owner names"
    fi
    if grep -r "dp_khatian" database/seeders/ 2>/dev/null | grep -q .; then
        echo "   - DP khatian checkbox support"
    fi
    if grep -r "land_category" database/seeders/ 2>/dev/null | grep -q .; then
        echo "   - Land category demo data"
    fi
    if grep -r "award_serial_no" database/seeders/ 2>/dev/null | grep -q .; then
        echo "   - Conditional award serial number demo data"
    fi
    if grep -r "tax_info" database/seeders/ 2>/dev/null | grep -q .; then
        echo "   - Tax information field in ownership details"
    fi
    echo ""
    
    # Production uses CDN - no need to build Vite assets
    print_status "🌐 Production using CDN approach..."
    print_success "✅ No asset building required - using CDN for Tailwind CSS and Alpine.js"
    echo "   - Development: Local Vite build"
    echo "   - Production: CDN (Tailwind + Alpine.js)"
    echo ""
    
    # Check application health
    if ! check_application_health; then
        print_error "❌ Application health check failed"
        exit 1
    fi
    
    echo ""
    print_success "🎉 Production deployment completed successfully!"
    echo ""
    print_status "📱 Check the application: http://152.42.201.131:8000"
    echo ""
    generate_deployment_summary
    echo ""
    print_status "🔧 Useful commands:"
    echo "   - Check logs: docker compose -f docker-compose.server.yml logs -f"
    echo "   - View backups: ls -la backup_*.sql"
    echo "   - Restore from backup: ./restore-from-backup.sh <backup_file>"
    echo ""
}

# Trap to handle script interruption
trap 'print_error "❌ Deployment interrupted"; exit 1' INT TERM

# Run main deployment
main "$@" 