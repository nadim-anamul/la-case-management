# Laravel PDF Generator - Windows Deployment Script
# This script will set up and deploy the Laravel PDF Generator project on Windows

param(
    [switch]$SkipChecks,
    [switch]$ForceInstall,
    [string]$ProjectPort = "8000",
    [string]$DbPort = "3307"
)

# Set execution policy to allow script execution
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser -Force

Write-Host "🚀 Laravel PDF Generator - Windows Deployment Script" -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan

# Function to check if a command exists
function Test-Command($CommandName) {
    try {
        Get-Command $CommandName -ErrorAction Stop | Out-Null
        return $true
    }
    catch {
        return $false
    }
}

# Function to check Windows version
function Get-WindowsVersion {
    $os = Get-WmiObject -Class Win32_OperatingSystem
    $version = [System.Version]::Parse($os.Version)
    
    if ($version.Major -eq 10) {
        return "Windows 10/11"
    } elseif ($version.Major -eq 6 -and $version.Minor -eq 3) {
        return "Windows 8.1"
    } elseif ($version.Major -eq 6 -and $version.Minor -eq 2) {
        return "Windows 8"
    } elseif ($version.Major -eq 6 -and $version.Minor -eq 1) {
        return "Windows 7"
    } else {
        return "Unknown Windows Version"
    }
}

# Function to install Chocolatey
function Install-Chocolatey {
    Write-Host "📦 Installing Chocolatey package manager..." -ForegroundColor Yellow
    
    try {
        Set-ExecutionPolicy Bypass -Scope Process -Force
        [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
        iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
        
        if (Test-Command choco) {
            Write-Host "✅ Chocolatey installed successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Chocolatey installation failed!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Chocolatey installation failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to install Docker Desktop
function Install-DockerDesktop {
    Write-Host "🐳 Installing Docker Desktop..." -ForegroundColor Yellow
    
    try {
        # Install Docker Desktop using Chocolatey
        choco install docker-desktop -y
        
        if (Test-Command docker) {
            Write-Host "✅ Docker Desktop installed successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Docker Desktop installation failed!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Docker Desktop installation failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to install Git
function Install-Git {
    Write-Host "📚 Installing Git..." -ForegroundColor Yellow
    
    try {
        choco install git -y
        
        if (Test-Command git) {
            Write-Host "✅ Git installed successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Git installation failed!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Git installation failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to install Node.js
function Install-NodeJS {
    Write-Host "🟢 Installing Node.js..." -ForegroundColor Yellow
    
    try {
        choco install nodejs -y
        
        if (Test-Command node) {
            Write-Host "✅ Node.js installed successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Node.js installation failed!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Node.js installation failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to install Composer
function Install-Composer {
    Write-Host "🎼 Installing Composer..." -ForegroundColor Yellow
    
    try {
        choco install composer -y
        
        if (Test-Command composer) {
            Write-Host "✅ Composer installed successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Composer installation failed!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Composer installation failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to wait for Docker to be ready
function Wait-DockerReady {
    Write-Host "⏳ Waiting for Docker to be ready..." -ForegroundColor Yellow
    
    $maxAttempts = 30
    $attempt = 0
    
    while ($attempt -lt $maxAttempts) {
        try {
            docker info | Out-Null
            Write-Host "✅ Docker is ready!" -ForegroundColor Green
            return $true
        }
        catch {
            $attempt++
            Write-Host "⏳ Waiting for Docker... Attempt $attempt/$maxAttempts" -ForegroundColor Yellow
            Start-Sleep -Seconds 10
        }
    }
    
    Write-Host "❌ Docker failed to start within expected time!" -ForegroundColor Red
    return $false
}

# Function to check and create .env file
function Initialize-EnvironmentFile {
    Write-Host "🔧 Initializing environment configuration..." -ForegroundColor Yellow
    
    if (-not (Test-Path ".env")) {
        if (Test-Path ".env.example") {
            Copy-Item ".env.example" ".env"
            Write-Host "✅ Created .env file from .env.example" -ForegroundColor Green
        } else {
            Write-Host "⚠️  No .env.example file found. You may need to create .env manually." -ForegroundColor Yellow
        }
    } else {
        Write-Host "✅ .env file already exists" -ForegroundColor Green
    }
}

# Function to build and start Docker containers
function Start-DockerContainers {
    Write-Host "🐳 Building and starting Docker containers..." -ForegroundColor Yellow
    
    try {
        # Stop any existing containers
        docker-compose down
        
        # Build and start containers
        docker-compose up -d --build
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Docker containers started successfully!" -ForegroundColor Green
            return $true
        } else {
            Write-Host "❌ Failed to start Docker containers!" -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Host "❌ Error starting Docker containers: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to run Laravel setup commands
function Setup-Laravel {
    Write-Host "🔧 Setting up Laravel application..." -ForegroundColor Yellow
    
    try {
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
        
        Write-Host "✅ Laravel setup completed successfully!" -ForegroundColor Green
        return $true
    }
    catch {
        Write-Host "❌ Laravel setup failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Function to check application health
function Test-ApplicationHealth {
    Write-Host "🏥 Testing application health..." -ForegroundColor Yellow
    
    $maxAttempts = 10
    $attempt = 0
    
    while ($attempt -lt $maxAttempts) {
        try {
            $response = Invoke-WebRequest -Uri "http://localhost:$ProjectPort" -TimeoutSec 10 -ErrorAction Stop
            if ($response.StatusCode -eq 200) {
                Write-Host "✅ Application is running successfully!" -ForegroundColor Green
                return $true
            }
        }
        catch {
            $attempt++
            Write-Host "⏳ Waiting for application... Attempt $attempt/$maxAttempts" -ForegroundColor Yellow
            Start-Sleep -Seconds 5
        }
    }
    
    Write-Host "❌ Application failed to respond within expected time!" -ForegroundColor Red
    return $false
}

# Main execution
try {
    Write-Host "🖥️  Windows Version: $(Get-WindowsVersion)" -ForegroundColor Blue
    Write-Host "🔍 Checking system requirements..." -ForegroundColor Blue
    
    # Check if we should skip dependency checks
    if (-not $SkipChecks) {
        # Check and install Chocolatey if needed
        if (-not (Test-Command choco)) {
            Write-Host "📦 Chocolatey not found. Installing..." -ForegroundColor Yellow
            if (-not (Install-Chocolatey)) {
                throw "Failed to install Chocolatey"
            }
        } else {
            Write-Host "✅ Chocolatey already installed" -ForegroundColor Green
        }
        
        # Check and install Docker Desktop if needed
        if (-not (Test-Command docker)) {
            Write-Host "🐳 Docker not found. Installing Docker Desktop..." -ForegroundColor Yellow
            if (-not (Install-DockerDesktop)) {
                throw "Failed to install Docker Desktop"
            }
            
            Write-Host "🔄 Docker Desktop installed. Please restart your computer and run this script again." -ForegroundColor Yellow
            Write-Host "💡 After restart, Docker Desktop will start automatically." -ForegroundColor Cyan
            exit 0
        } else {
            Write-Host "✅ Docker already installed" -ForegroundColor Green
        }
        
        # Check and install Git if needed
        if (-not (Test-Command git)) {
            Write-Host "📚 Git not found. Installing..." -ForegroundColor Yellow
            if (-not (Install-Git)) {
                throw "Failed to install Git"
            }
        } else {
            Write-Host "✅ Git already installed" -ForegroundColor Green
        }
        
        # Check and install Node.js if needed
        if (-not (Test-Command node)) {
            Write-Host "🟢 Node.js not found. Installing..." -ForegroundColor Yellow
            if (-not (Install-NodeJS)) {
                throw "Failed to install Node.js"
            }
        } else {
            Write-Host "✅ Node.js already installed" -ForegroundColor Green
        }
        
        # Check and install Composer if needed
        if (-not (Test-Command composer)) {
            Write-Host "🎼 Composer not found. Installing..." -ForegroundColor Yellow
            if (-not (Install-Composer)) {
                throw "Failed to install Composer"
            }
        } else {
            Write-Host "✅ Composer already installed" -ForegroundColor Green
        }
    }
    
    # Wait for Docker to be ready
    if (-not (Wait-DockerReady)) {
        throw "Docker is not ready"
    }
    
    # Initialize environment file
    Initialize-EnvironmentFile
    
    # Start Docker containers
    if (-not (Start-DockerContainers)) {
        throw "Failed to start Docker containers"
    }
    
    # Wait a bit for containers to fully start
    Start-Sleep -Seconds 10
    
    # Setup Laravel
    if (-not (Setup-Laravel)) {
        throw "Failed to setup Laravel"
    }
    
    # Test application health
    if (-not (Test-ApplicationHealth)) {
        throw "Application health check failed"
    }
    
    Write-Host ""
    Write-Host "🎉 Deployment completed successfully!" -ForegroundColor Green
    Write-Host "=====================================" -ForegroundColor Green
    Write-Host "🌐 Application URL: http://localhost:$ProjectPort" -ForegroundColor Cyan
    Write-Host "🗄️  Database Port: $DbPort" -ForegroundColor Cyan
    Write-Host "🐳 Docker containers are running" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "📋 Useful commands:" -ForegroundColor Yellow
    Write-Host "   View logs: docker-compose logs -f" -ForegroundColor White
    Write-Host "   Stop containers: docker-compose down" -ForegroundColor White
    Write-Host "   Restart containers: docker-compose restart" -ForegroundColor White
    Write-Host "   Access container: docker-compose exec app bash" -ForegroundColor White
    Write-Host ""
    Write-Host "🔧 Laravel commands:" -ForegroundColor Yellow
    Write-Host "   Run migrations: docker-compose exec app php artisan migrate" -ForegroundColor White
    Write-Host "   Clear cache: docker-compose exec app php artisan cache:clear" -ForegroundColor White
    Write-Host "   Run tests: docker-compose exec app php artisan test" -ForegroundColor White
    Write-Host ""
    
}
catch {
    Write-Host ""
    Write-Host "❌ Deployment failed: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "💡 Please check the error messages above and try again." -ForegroundColor Yellow
    Write-Host "🆘 If you continue to have issues, please check:" -ForegroundColor Yellow
    Write-Host "   - Docker Desktop is running" -ForegroundColor White
    Write-Host "   - Ports $ProjectPort and $DbPort are available" -ForegroundColor White
    Write-Host "   - You have sufficient disk space" -ForegroundColor White
    Write-Host "   - Windows Defender is not blocking Docker" -ForegroundColor White
    exit 1
}
