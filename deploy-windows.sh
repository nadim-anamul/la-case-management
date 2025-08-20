#!/bin/bash

# Laravel PDF Generator - Windows Deployment Script (Bash Version)
# This script will set up and deploy the Laravel PDF Generator project on Windows
# Can be run in WSL (Windows Subsystem for Linux) or Git Bash

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
WHITE='\033[1;37m'
NC='\033[0m' # No Color

# Default values
PROJECT_PORT=8000
DB_PORT=3307
SKIP_CHECKS=false
FORCE_INSTALL=false

# Global variable to track Chocolatey failures
CHOCO_FAILURE_COUNT=0

# Function to print colored output
print_status() {
    echo -e "${CYAN}🚀 Laravel PDF Generator - Windows Deployment Script${NC}"
    echo -e "${CYAN}==================================================${NC}"
}

print_info() {
    echo -e "${BLUE}$1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_yellow() {
    echo -e "${YELLOW}$1${NC}"
}

# Function to check if a command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to check if running on Windows
is_windows() {
    [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "cygwin" ]] || [[ -n "$WINDIR" ]]
}

# Function to check if running in WSL
is_wsl() {
    [[ -n "$WSL_DISTRO_NAME" ]] || grep -qi microsoft /proc/version 2>/dev/null
}

# Function to detect Windows environment
detect_windows_env() {
    if is_wsl; then
        echo "WSL (Windows Subsystem for Linux)"
    elif is_windows; then
        echo "Git Bash/Cygwin/MSYS2"
    else
        echo "Linux/Unix"
    fi
}

# Function to install Chocolatey (Windows only)
install_chocolatey() {
    print_yellow "📦 Installing Chocolatey package manager..."
    
    if ! is_windows; then
        print_warning "Chocolatey is only available on Windows. Skipping..."
        return 0
    fi
    
    # Check if running as administrator
    if ! net session >/dev/null 2>&1; then
        print_error "Chocolatey installation requires administrator privileges."
        print_warning "Please run this script as Administrator or install Chocolatey manually."
        return 1
    fi
    
    # Install Chocolatey
    powershell.exe -Command "Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))"
    
    if command_exists choco; then
        print_success "Chocolatey installed successfully!"
        return 0
    else
        print_error "Chocolatey installation failed!"
        return 1
    fi
}

# Function to perform aggressive Chocolatey cleanup
aggressive_chocolatey_cleanup() {
    print_yellow "🧹 Performing aggressive Chocolatey cleanup..."
    
    if is_windows; then
        # Stop any running Chocolatey processes
        print_info "Stopping Chocolatey processes..."
        cmd //c "taskkill /f /im choco.exe" 2>/dev/null || true
        cmd //c "taskkill /f /im nuget.exe" 2>/dev/null || true
        
        # Wait for processes to stop
        sleep 5
        
        # Clean lock files with elevated permissions
        print_info "Cleaning lock files with elevated permissions..."
        
        # Try to use PowerShell with elevated permissions
        if command_exists powershell; then
            powershell.exe -Command "Start-Process powershell -ArgumentList '-Command \"Remove-Item -Path C:\ProgramData\chocolatey\lib-bad -Recurse -Force -ErrorAction SilentlyContinue; Remove-Item -Path C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef -Force -ErrorAction SilentlyContinue; Remove-Item -Path C:\ProgramData\chocolatey\lib\*.lock -Force -ErrorAction SilentlyContinue\"' -Verb RunAs -WindowStyle Hidden"
            sleep 3
        fi
        
        # Also try direct Windows commands
        cmd //c "rmdir /s /q C:\ProgramData\chocolatey\lib-bad" 2>/dev/null || true
        cmd //c "del /f /q C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef" 2>/dev/null || true
        cmd //c "del /f /q C:\ProgramData\chocolatey\lib\*.lock" 2>/dev/null || true
        
        print_success "Aggressive cleanup completed"
    else
        print_warning "Aggressive cleanup only available on Windows"
        return 1
    fi
}

# Function to clean Chocolatey lock files
clean_chocolatey_locks() {
    print_yellow "🧹 Cleaning Chocolatey lock files..."
    
    if is_windows; then
        # Try to use Windows commands if available
        if command_exists cmd; then
            print_info "Using Windows commands to clean lock files..."
            
            # Remove lib-bad directory
            cmd //c "rmdir /s /q C:\ProgramData\chocolatey\lib-bad" 2>/dev/null || true
            
            # Remove specific lock file
            cmd //c "del /f /q C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef" 2>/dev/null || true
            
            # Remove all lock files
            cmd //c "del /f /q C:\ProgramData\chocolatey\lib\*.lock" 2>/dev/null || true
            
            print_success "Chocolatey lock files cleaned using Windows commands"
        else
            # Fallback to bash commands
            print_info "Using bash commands to clean lock files..."
            
            # Remove lock files and bad directories
            if [ -d "/c/ProgramData/chocolatey/lib-bad" ]; then
                rm -rf "/c/ProgramData/chocolatey/lib-bad" 2>/dev/null || true
                print_success "Removed lib-bad directory"
            fi
            
            # Find and remove lock files
            find "/c/ProgramData/chocolatey" -name "*.lock" -type f -delete 2>/dev/null || true
            find "/c/ProgramData/chocolatey" -name "*f7305e8da17e94357fea6af6fcda055f18a81cef*" -type f -delete 2>/dev/null || true
            
            print_success "Chocolatey lock files cleaned using bash commands"
        fi
    elif is_wsl; then
        # For WSL, we need to use Windows commands
        print_warning "Running in WSL. Please run these commands in Windows Command Prompt as Administrator:"
        echo ""
        echo "1. Open Command Prompt as Administrator"
        echo "2. Run: rmdir /s /q C:\ProgramData\chocolatey\lib-bad"
        echo "3. Run: del /f /q C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef"
        echo "4. Run: del /f /q C:\ProgramData\chocolatey\lib\*.lock"
        echo ""
        echo "Then run this script again."
        return 1
    else
        print_warning "Not running on Windows. This script is for Windows systems."
        return 1
    fi
}

# Function to install Docker Desktop using Chocolatey
install_docker_desktop() {
    print_yellow "🐳 Installing Docker Desktop..."
    
    if ! is_windows; then
        print_warning "Docker Desktop installation via Chocolatey is only available on Windows. Skipping..."
        return 0
    fi
    
    if ! command_exists choco; then
        print_error "Chocolatey not found. Please install Chocolatey first."
        return 1
    fi
    
    # Clean any existing lock files first
    clean_chocolatey_locks
    
    # Wait a moment for any processes to finish
    sleep 5
    
    # Try to install Docker Desktop
    if choco install docker-desktop -y; then
        print_success "Docker Desktop installed successfully!"
        return 0
    else
        print_error "Docker Desktop installation failed!"
        print_warning "This might be due to lock file issues. Trying to clean and retry..."
        
        # Clean lock files again and retry
        clean_chocolatey_locks
        sleep 3
        
        if choco install docker-desktop -y --force; then
            print_success "Docker Desktop installed successfully on retry!"
            return 0
        else
            print_error "Docker Desktop installation failed even after cleanup!"
            print_warning "Trying aggressive cleanup and final attempt..."
            
            # Try aggressive cleanup
            aggressive_chocolatey_cleanup
            
            # Final attempt with longer wait
            sleep 10
            
                            if choco install docker-desktop -y --force; then
                    print_success "Docker Desktop installed successfully after aggressive cleanup!"
                    return 0
                else
                    print_error "Docker Desktop installation failed even after aggressive cleanup!"
                    track_chocolatey_failure
                    print_warning "You may need to install Docker Desktop manually:"
                    echo "1. Download from: https://www.docker.com/products/docker-desktop/"
                    echo "2. Run as Administrator"
                    echo "3. Restart your computer"
                    return 1
                fi
        fi
    fi
}

# Function to install Git
install_git() {
    print_yellow "📚 Installing Git..."
    
    if is_windows && command_exists choco; then
        # Clean any existing lock files first
        clean_chocolatey_locks
        
        # Wait a moment for any processes to finish
        sleep 5
        
        # Try to install Git
        if choco install git -y; then
            print_success "Git installed successfully!"
            return 0
        else
            print_error "Git installation failed!"
            print_warning "This might be due to lock file issues. Trying to clean and retry..."
            
            # Clean lock files again and retry
            clean_chocolatey_locks
            sleep 3
            
            if choco install git -y --force; then
                print_success "Git installed successfully on retry!"
                return 0
            else
                print_error "Git installation failed even after cleanup!"
                print_warning "Trying aggressive cleanup and final attempt..."
                
                # Try aggressive cleanup
                aggressive_chocolatey_cleanup
                
                # Final attempt with longer wait
                sleep 10
                
                if choco install git -y --force; then
                    print_success "Git installed successfully after aggressive cleanup!"
                    return 0
                else
                    print_error "Git installation failed even after aggressive cleanup!"
                    track_chocolatey_failure
                    print_warning "You may need to install Git manually or use alternative methods."
                    return 1
                fi
            fi
        fi
    elif is_wsl; then
        sudo apt-get update
        sudo apt-get install -y git
    else
        print_warning "Please install Git manually for your system."
        return 1
    fi
    
    if command_exists git; then
        print_success "Git installed successfully!"
        return 0
    else
        print_error "Git installation failed!"
        return 1
    fi
}

# Function to install Node.js
install_nodejs() {
    print_yellow "🟢 Installing Node.js..."
    
    if is_windows && command_exists choco; then
        # Clean any existing lock files first
        clean_chocolatey_locks
        
        # Wait a moment for any processes to finish
        sleep 5
        
        # Try to install Node.js
        if choco install nodejs -y; then
            print_success "Node.js installed successfully!"
            return 0
        else
            print_error "Node.js installation failed!"
            print_warning "This might be due to lock file issues. Trying to clean and retry..."
            
            # Clean lock files again and retry
            clean_chocolatey_locks
            sleep 3
            
            if choco install nodejs -y --force; then
                print_success "Node.js installed successfully on retry!"
                return 0
            else
                print_error "Node.js installation failed even after cleanup!"
                print_warning "Trying aggressive cleanup and final attempt..."
                
                # Try aggressive cleanup
                aggressive_chocolatey_cleanup
                
                # Final attempt with longer wait
                sleep 10
                
                if choco install nodejs -y --force; then
                    print_success "Node.js installed successfully after aggressive cleanup!"
                    return 0
                else
                    print_error "Node.js installation failed even after aggressive cleanup!"
                    track_chocolatey_failure
                    print_warning "You may need to install Node.js manually or use alternative methods."
                    return 1
                fi
            fi
        fi
    elif is_wsl; then
        curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
        sudo apt-get install -y nodejs
    else
        print_warning "Please install Node.js manually for your system."
        return 1
    fi
    
    if command_exists node; then
        print_success "Node.js installed successfully!"
        return 0
    else
        print_error "Node.js installation failed!"
        return 1
    fi
}

# Function to install Composer
install_composer() {
    print_yellow "🎼 Installing Composer..."
    
    if is_windows && command_exists choco; then
        # Clean any existing lock files first
        clean_chocolatey_locks
        
        # Wait a moment for any processes to finish
        sleep 5
        
        # Try to install Composer
        if choco install composer -y; then
            print_success "Composer installed successfully!"
            return 0
        else
            print_error "Composer installation failed!"
            print_warning "This might be due to lock file issues. Trying to clean and retry..."
            
            # Clean lock files again and retry
            clean_chocolatey_locks
            sleep 3
            
            if choco install composer -y --force; then
                print_success "Composer installed successfully on retry!"
                return 0
            else
                print_error "Composer installation failed even after cleanup!"
                print_warning "Trying aggressive cleanup and final attempt..."
                
                # Try aggressive cleanup
                aggressive_chocolatey_cleanup
                
                # Final attempt with longer wait
                sleep 10
                
                if choco install composer -y --force; then
                    print_success "Composer installed successfully after aggressive cleanup!"
                    return 0
                else
                    print_error "Composer installation failed even after aggressive cleanup!"
                    track_chocolatey_failure
                    print_warning "You may need to install Composer manually or use alternative methods."
                    return 1
                fi
            fi
        fi
    elif is_wsl; then
        curl -sS https://getcomposer.org/installer | php
        sudo mv composer.phar /usr/local/bin/composer
        sudo chmod +x /usr/local/bin/composer
    else
        print_warning "Please install Composer manually for your system."
        return 1
    fi
    
    if command_exists composer; then
        print_success "Composer installed successfully!"
        return 0
    else
        print_error "Composer installation failed!"
        return 1
    fi
}

# Function to install PHP
install_php() {
    print_yellow "🐘 Installing PHP..."
    
    if is_windows && command_exists choco; then
        # Clean any existing lock files first
        clean_chocolatey_locks
        
        # Wait a moment for any processes to finish
        sleep 5
        
        # Try to install PHP
        if choco install php -y; then
            print_success "PHP installed successfully!"
            return 0
        else
            print_error "PHP installation failed!"
            print_warning "This might be due to lock file issues. Trying to clean and retry..."
            
            # Clean lock files again and retry
            clean_chocolatey_locks
            sleep 3
            
            if choco install php -y --force; then
                print_success "PHP installed successfully on retry!"
                return 0
            else
                print_error "PHP installation failed even after cleanup!"
                print_warning "Trying aggressive cleanup and final attempt..."
                
                # Try aggressive cleanup
                aggressive_chocolatey_cleanup
                
                # Final attempt with longer wait
                sleep 10
                
                if choco install php -y --force; then
                    print_success "PHP installed successfully after aggressive cleanup!"
                    return 0
                else
                    print_error "PHP installation failed even after aggressive cleanup!"
                    track_chocolatey_failure
                    print_warning "You may need to install PHP manually or use alternative methods."
                    return 1
                fi
            fi
        fi
    elif is_wsl; then
        sudo apt-get update
        sudo apt-get install -y php
    else
        print_warning "Please install PHP manually for your system."
        return 1
    fi
    
    if command_exists php; then
        print_success "PHP installed successfully!"
        return 0
    else
        print_error "PHP installation failed!"
        return 1
    fi
}

# Function to wait for Docker to be ready
wait_docker_ready() {
    print_yellow "⏳ Waiting for Docker to be ready..."
    
    local max_attempts=30
    local attempt=0
    
    while [ $attempt -lt $max_attempts ]; do
        if docker info >/dev/null 2>&1; then
            print_success "Docker is ready!"
            return 0
        fi
        
        attempt=$((attempt + 1))
        print_yellow "⏳ Waiting for Docker... Attempt $attempt/$max_attempts"
        sleep 10
    done
    
    print_error "Docker failed to start within expected time!"
    return 1
}

# Function to track Chocolatey failures and suggest alternatives
track_chocolatey_failure() {
    CHOCO_FAILURE_COUNT=$((CHOCO_FAILURE_COUNT + 1))
    
    if [ $CHOCO_FAILURE_COUNT -ge 3 ]; then
        print_warning "⚠️  Multiple Chocolatey installations have failed. This suggests a systemic issue."
        echo ""
        show_alternative_installations
        echo ""
        print_warning "💡 Consider using the alternative installation methods above instead of continuing with Chocolatey."
        echo ""
        read -p "Do you want to continue trying with Chocolatey? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "Exiting to allow manual installation of packages."
            exit 0
        fi
    fi
}

# Function to show alternative installation methods
show_alternative_installations() {
    print_warning "🔄 Alternative Installation Methods"
    echo ""
    echo "Since Chocolatey is experiencing persistent lock file issues, here are alternative ways to install the required packages:"
    echo ""
    echo "📦 **Option 1: Use winget (Windows Package Manager)**"
    echo "Open PowerShell as Administrator and run:"
    echo "  winget install Git.Git"
    echo "  winget install OpenJS.NodeJS"
    echo "  winget install TheComposer.Composer"
    echo "  winget install PHP.PHP"
    echo "  winget install Docker.DockerDesktop"
    echo ""
    echo "📦 **Option 2: Manual Downloads**"
    echo "1. Git: https://git-scm.com/download/win"
    echo "2. Node.js: https://nodejs.org/en/download/"
    echo "3. Composer: https://getcomposer.org/download/"
    echo "4. PHP: https://windows.php.net/download/"
    echo "5. Docker Desktop: https://www.docker.com/products/docker-desktop/"
    echo ""
    echo "📦 **Option 3: Use WSL2 for Development**"
    echo "1. Install WSL2: wsl --install"
    echo "2. Use Ubuntu/Debian package manager instead of Chocolatey"
    echo "3. Run your Laravel project in WSL2 environment"
    echo ""
    print_info "💡 **Recommendation**: Try winget first, as it's Microsoft's official package manager and usually more reliable than Chocolatey."
}

# Function to provide comprehensive troubleshooting steps
show_comprehensive_troubleshooting() {
    print_warning "🔧 Comprehensive Troubleshooting Steps"
    echo ""
    echo "The Chocolatey lock file issue persists. Here are the steps to resolve it:"
    echo ""
    echo "📋 **Step 1: Manual Lock File Cleanup (Run as Administrator)**"
    echo "1. Open Command Prompt as Administrator"
    echo "2. Run these commands one by one:"
    echo ""
    echo "   rmdir /s /q C:\ProgramData\chocolatey\lib-bad"
    echo "   del /f /q C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef"
    echo "   del /f /q C:\ProgramData\chocolatey\lib\*.lock"
    echo "   del /f /q C:\ProgramData\chocolatey\*.lock"
    echo ""
    echo "📋 **Step 2: Restart Chocolatey Service**"
    echo "1. Open PowerShell as Administrator"
    echo "2. Run: Restart-Service -Name 'Chocolatey' -Force"
    echo ""
    echo "📋 **Step 3: Alternative Installation Methods**"
    echo "Option A: Manual Docker Desktop Installation"
    echo "1. Download from: https://www.docker.com/products/docker-desktop/"
    echo "2. Run installer as Administrator"
    echo "3. Restart computer"
    echo ""
    echo "Option B: Use winget (Windows Package Manager)"
    echo "1. Open PowerShell as Administrator"
    echo "2. Run: winget install Docker.DockerDesktop"
    echo "3. Restart computer"
    echo ""
    echo "📋 **Step 4: If Still Having Issues**"
    echo "1. Restart your computer"
    echo "2. Try running the deployment script again"
    echo "3. Consider using WSL2 for development instead"
    echo ""
    print_info "💡 **Pro Tip**: Sometimes a simple computer restart can resolve Chocolatey lock issues."
}

# Function to provide manual lock file cleanup instructions
show_manual_lock_cleanup() {
    print_warning "🔧 Manual Lock File Cleanup Required"
    echo ""
    echo "To fix the Chocolatey lock file issue, please run these commands in Windows Command Prompt as Administrator:"
    echo ""
    echo "1. Open Command Prompt as Administrator (right-click Command Prompt → Run as Administrator)"
    echo "2. Run these commands one by one:"
    echo ""
    echo "   rmdir /s /q C:\ProgramData\chocolatey\lib-bad"
    echo "   del /f /q C:\ProgramData\chocolatey\lib\f7305e8da17e94357fea6af6fcda055f18a81cef"
    echo "   del /f /q C:\ProgramData\chocolatey\lib\*.lock"
    echo ""
    echo "3. Close Command Prompt"
    echo "4. Run this deployment script again"
    echo ""
    print_info "💡 Alternative: You can also restart your computer to clear any locked processes."
}

# Function to check and create .env file
initialize_environment_file() {
    print_yellow "🔧 Initializing environment configuration..."
    
    if [ ! -f .env ]; then
        if [ -f .env.example ]; then
            cp .env.example .env
            print_success "Created .env file from .env.example"
        else
            print_warning "No .env.example file found. You may need to create .env manually."
        fi
    else
        print_success ".env file already exists"
    fi
}

# Function to build and start Docker containers
start_docker_containers() {
    print_yellow "🐳 Building and starting Docker containers..."
    
    # Stop any existing containers
    docker-compose down
    
    # Build and start containers
    if docker-compose up -d --build; then
        print_success "Docker containers started successfully!"
        return 0
    else
        print_error "Failed to start Docker containers!"
        return 1
    fi
}

# Function to run Laravel setup commands
setup_laravel() {
    print_yellow "🔧 Setting up Laravel application..."
    
    # Wait for containers to be fully ready
    sleep 15
    
    # Generate application key
    docker-compose exec -T app php artisan key:generate
    
    # Run migrations
    docker-compose exec -T app php artisan migrate --force
    
    # Clear caches
    docker-compose exec -T app php artisan config:clear
    docker-compose exec -T app php artisan cache:clear
    docker-compose exec -T app php artisan view:clear
    
    # Install and build frontend assets
    docker-compose exec -T app npm install
    docker-compose exec -T app npm run build
    
    print_success "Laravel setup completed successfully!"
    return 0
}

# Function to check application health
test_application_health() {
    print_yellow "🏥 Testing application health..."
    
    local max_attempts=10
    local attempt=0
    
    while [ $attempt -lt $max_attempts ]; do
        if curl -f -s "http://localhost:$PROJECT_PORT" >/dev/null 2>&1; then
            print_success "Application is running successfully!"
            return 0
        fi
        
        attempt=$((attempt + 1))
        print_yellow "⏳ Waiting for application... Attempt $attempt/$max_attempts"
        sleep 5
    done
    
    print_error "Application failed to respond within expected time!"
    return 1
}

# Function to display usage information
show_usage() {
    echo "Usage: $0 [OPTIONS]"
    echo ""
    echo "Options:"
    echo "  -p, --port PORT        Application port (default: 8000)"
    echo "  -d, --db-port PORT     Database port (default: 3307)"
    echo "  -s, --skip-checks      Skip dependency checks"
    echo "  -f, --force-install    Force reinstall of dependencies"
    echo "  -h, --help             Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0                     # Run with default settings"
    echo "  $0 -p 8080            # Use port 8080 for application"
    echo "  $0 -s                 # Skip dependency checks"
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -p|--port)
            PROJECT_PORT="$2"
            shift 2
            ;;
        -d|--db-port)
            DB_PORT="$2"
            shift 2
            ;;
        -s|--skip-checks)
            SKIP_CHECKS=true
            shift
            ;;
        -f|--force-install)
            FORCE_INSTALL=true
            shift
            ;;
        -h|--help)
            show_usage
            exit 0
            ;;
        *)
            print_error "Unknown option: $1"
            show_usage
            exit 1
            ;;
    esac
done

# Main execution
main() {
    print_status
    
    print_info "🖥️  Environment: $(detect_windows_env)"
    print_info "🔍 Checking system requirements..."
    
    # Check if we should skip dependency checks
    if [ "$SKIP_CHECKS" = false ]; then
        # Check and install Chocolatey if needed
        if ! command_exists choco; then
            print_info "📦 Chocolatey not found. Installing..."
            if ! install_chocolatey; then
                print_error "Failed to install Chocolatey"
                exit 1
            fi
        else
            print_success "Chocolatey already installed"
        fi
        
        # Check and install Docker Desktop if needed
        if ! command_exists docker; then
            print_info "🐳 Docker not found. Installing Docker Desktop..."
            if ! install_docker_desktop; then
                print_error "Failed to install Docker Desktop"
                echo ""
                show_comprehensive_troubleshooting
                exit 1
            fi
            
            print_warning "🔄 Docker Desktop installed. Please restart your computer and run this script again."
            print_info "💡 After restart, Docker Desktop will start automatically."
            exit 0
        else
            print_success "Docker already installed"
        fi
        
        # Check and install Git if needed
        if ! command_exists git; then
            print_info "📚 Git not found. Installing..."
            if ! install_git; then
                print_error "Failed to install Git"
                exit 1
            fi
        else
            print_success "Git already installed"
        fi
        
        # Check and install Node.js if needed
        if ! command_exists node; then
            print_info "🟢 Node.js not found. Installing..."
            if ! install_nodejs; then
                print_error "Failed to install Node.js"
                exit 1
            fi
        else
            print_success "Node.js already installed"
        fi
        
        # Check and install Composer if needed
        if ! command_exists composer; then
            print_info "🎼 Composer not found. Installing..."
            if ! install_composer; then
                print_error "Failed to install Composer"
                exit 1
            fi
        else
            print_success "Composer already installed"
        fi
    fi
    
    # Wait for Docker to be ready
    if ! wait_docker_ready; then
        print_error "Docker is not ready"
        exit 1
    fi
    
    # Initialize environment file
    initialize_environment_file
    
    # Start Docker containers
    if ! start_docker_containers; then
        print_error "Failed to start Docker containers"
        exit 1
    fi
    
    # Setup Laravel
    if ! setup_laravel; then
        print_error "Failed to setup Laravel"
        exit 1
    fi
    
    # Test application health
    if ! test_application_health; then
        print_error "Application health check failed"
        exit 1
    fi
    
    echo ""
    print_success "🎉 Deployment completed successfully!"
    echo "====================================="
    echo -e "🌐 Application URL: ${CYAN}http://localhost:$PROJECT_PORT${NC}"
    echo -e "🗄️  Database Port: ${CYAN}$DB_PORT${NC}"
    echo -e "🐳 Docker containers are running"
    echo ""
    echo -e "${YELLOW}📋 Useful commands:${NC}"
    echo -e "   View logs: ${WHITE}docker-compose logs -f${NC}"
    echo -e "   Stop containers: ${WHITE}docker-compose down${NC}"
    echo -e "   Restart containers: ${WHITE}docker-compose restart${NC}"
    echo -e "   Access container: ${WHITE}docker-compose exec app bash${NC}"
    echo ""
    echo -e "${YELLOW}🔧 Laravel commands:${NC}"
    echo -e "   Run migrations: ${WHITE}docker-compose exec app php artisan migrate${NC}"
    echo -e "   Clear cache: ${WHITE}docker-compose exec app php artisan cache:clear${NC}"
    echo -e "   Run tests: ${WHITE}docker-compose exec app php artisan test${NC}"
    echo ""
}

# Run main function
main "$@"
