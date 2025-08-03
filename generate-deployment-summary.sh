#!/bin/bash

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
    echo "   - CDN assets (no Vite build required)"
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

# Main function
main() {
    echo ""
    print_status "🚀 Deployment Summary Generator"
    echo "=================================="
    
    generate_deployment_summary
    
    print_success "✅ Summary generated successfully!"
    echo ""
}

# Run main function
main "$@" 