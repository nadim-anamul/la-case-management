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

# Function to check git status
check_git_status() {
    print_status "🔍 Checking Git status..."
    
    # Check if we're in a git repository
    if ! git rev-parse --git-dir > /dev/null 2>&1; then
        print_error "❌ Not in a git repository"
        exit 1
    fi
    
    # Check if there are uncommitted changes
    if ! git diff-index --quiet HEAD --; then
        print_warning "⚠️ You have uncommitted changes"
        print_status "📋 Current changes:"
        git status --short
        echo ""
        read -p "Do you want to continue? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_status "🛑 Update cancelled"
            exit 0
        fi
    fi
    
    print_success "✅ Git repository status checked"
}

# Function to pull latest changes
pull_latest_changes() {
    print_status "📥 Pulling latest changes from remote..."
    
    # Get current branch
    local current_branch=$(git branch --show-current)
    print_status "📍 Current branch: $current_branch"
    
    # Fetch latest changes
    if git fetch origin; then
        print_success "✅ Fetched latest changes"
    else
        print_error "❌ Failed to fetch changes"
        exit 1
    fi
    
    # Check if there are new commits
    local behind_count=$(git rev-list --count HEAD..origin/$current_branch 2>/dev/null || echo "0")
    
    if [ "$behind_count" -eq "0" ]; then
        print_success "✅ Already up to date"
        return 0
    else
        print_status "📝 Found $behind_count new commit(s)"
        
        # Pull changes
        if git pull origin $current_branch; then
            print_success "✅ Successfully pulled latest changes"
            
            # Show recent commits
            print_status "📋 Recent commits:"
            git log --oneline -$behind_count
            echo ""
            return 0
        else
            print_error "❌ Failed to pull changes"
            exit 1
        fi
    fi
}

# Function to run minimal deployment
run_minimal_deployment() {
    print_status "🚀 Running minimal deployment..."
    
    if [ -f "./deploy-code-only.sh" ]; then
        ./deploy-code-only.sh
    elif [ -f "./deploy-minimal.sh" ]; then
        ./deploy-minimal.sh
    else
        print_error "❌ No deployment scripts found"
        exit 1
    fi
}

# Function to show summary
show_summary() {
    print_status "📊 Quick Update Summary:"
    echo "   - Git repository checked"
    echo "   - Latest changes pulled"
    echo "   - Minimal deployment completed"
    echo "   - Ready for testing"
    echo ""
}

# Main quick update process
main() {
    echo ""
    print_status "🚀 Starting Quick Code Update Workflow"
    echo "============================================="
    
    # Check git status
    check_git_status
    
    # Pull latest changes
    if pull_latest_changes; then
        # Run minimal deployment
        run_minimal_deployment
        
        echo ""
        print_success "🎉 Quick update completed successfully!"
        echo ""
        show_summary
        print_status "🔧 Next steps:"
        echo "   - Test your changes at: http://152.42.201.131:8000"
        echo "   - Check logs if needed: docker compose -f docker-compose.server.yml logs -f app"
        echo "   - Run full deployment if needed: ./deploy-production.sh"
        echo ""
    else
        print_success "✅ No updates needed"
        echo ""
        print_status "🔧 Current status:"
        echo "   - Code is up to date"
        echo "   - No deployment needed"
        echo ""
    fi
}

# Trap to handle script interruption
trap 'print_error "❌ Update interrupted"; exit 1' INT TERM

# Run main update
main "$@"
