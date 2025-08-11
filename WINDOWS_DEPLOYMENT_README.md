# 🚀 Laravel PDF Generator - Windows Deployment Guide

This guide will help you deploy the Laravel PDF Generator project on Windows using Docker. We provide two deployment scripts: one for PowerShell and one for Bash environments.

## 📋 Prerequisites

- Windows 10/11 (64-bit)
- Administrator privileges (for initial setup)
- Internet connection for downloading dependencies
- At least 8GB RAM (16GB recommended)
- At least 10GB free disk space

## 🎯 Deployment Options

### Option 1: PowerShell Script (Recommended for Windows)
- **File**: `deploy-windows.ps1`
- **Environment**: Native Windows PowerShell
- **Features**: Full Windows integration, automatic dependency installation

### Option 2: Bash Script (WSL/Git Bash)
- **File**: `deploy-windows.sh`
- **Environment**: WSL, Git Bash, or Cygwin
- **Features**: Cross-platform compatibility, Unix-like commands

## 🚀 Quick Start

### Using PowerShell Script (Recommended)

1. **Open PowerShell as Administrator**
   ```powershell
   # Right-click on PowerShell and select "Run as Administrator"
   ```

2. **Navigate to your project directory**
   ```powershell
   cd C:\path\to\laravel-pdf-generator
   ```

3. **Run the deployment script**
   ```powershell
   .\deploy-windows.ps1
   ```

### Using Bash Script (WSL/Git Bash)

1. **Open WSL or Git Bash**
   ```bash
   # In WSL terminal or Git Bash
   ```

2. **Navigate to your project directory**
   ```bash
   cd /mnt/c/path/to/laravel-pdf-generator
   ```

3. **Make the script executable and run it**
   ```bash
   chmod +x deploy-windows.sh
   ./deploy-windows.sh
   ```

## ⚙️ Script Options

Both scripts support the following command-line options:

```bash
# PowerShell
.\deploy-windows.ps1 -SkipChecks -ProjectPort 8080 -DbPort 3308

# Bash
./deploy-windows.sh -s -p 8080 -d 3308
```

### Available Options

| Option | Long Form | Description | Default |
|--------|-----------|-------------|---------|
| `-p` | `--port` | Application port | 8000 |
| `-d` | `--db-port` | Database port | 3307 |
| `-s` | `--skip-checks` | Skip dependency checks | false |
| `-f` | `--force-install` | Force reinstall dependencies | false |
| `-h` | `--help` | Show help message | - |

## 🔧 What the Scripts Do

### 1. System Requirements Check
- ✅ Windows version detection
- ✅ Administrator privileges verification
- ✅ Available disk space check

### 2. Dependency Installation
- 📦 **Chocolatey**: Windows package manager
- 🐳 **Docker Desktop**: Containerization platform
- 📚 **Git**: Version control system
- 🟢 **Node.js**: JavaScript runtime
- 🎼 **Composer**: PHP dependency manager

### 3. Docker Setup
- 🐳 Build Docker images
- 🚀 Start containers (Laravel app + MySQL database)
- ⏳ Wait for services to be ready
- 🔍 Health checks

### 4. Laravel Configuration
- 🔑 Generate application key
- 🗄️ Run database migrations
- 🧹 Clear application caches
- 📦 Install and build frontend assets

## 📱 Application Access

After successful deployment:

- **🌐 Web Application**: http://localhost:8000
- **🗄️ Database**: localhost:3307
- **🐳 Docker Dashboard**: Available in Docker Desktop

## 🛠️ Useful Commands

### Docker Management
```bash
# View running containers
docker-compose ps

# View logs
docker-compose logs -f

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# Access Laravel container
docker-compose exec app bash
```

### Laravel Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# Run tests
docker-compose exec app php artisan test

# Generate application key
docker-compose exec app php artisan key:generate
```

### Database Access
```bash
# Access MySQL container
docker-compose exec db mysql -u laravel -p

# Database credentials
# Host: localhost
# Port: 3307
# Database: laravel
# Username: laravel
# Password: password
```

## 🔍 Troubleshooting

### Common Issues

#### 1. Docker Desktop Not Starting
```powershell
# Check Windows features
# Enable "Windows Subsystem for Linux" and "Virtual Machine Platform"
# Restart computer after enabling features
```

#### 2. Port Already in Use
```bash
# Check what's using the port
netstat -ano | findstr :8000

# Kill the process or change port in script
./deploy-windows.sh -p 8080
```

#### 3. Permission Denied
```powershell
# Run PowerShell as Administrator
# Or check Windows Defender settings
```

#### 4. Insufficient Disk Space
```bash
# Check available space
df -h

# Clean up Docker images
docker system prune -a
```

#### 5. WSL Issues
```bash
# Update WSL
wsl --update

# Restart WSL
wsl --shutdown
```

### Error Logs

Check these locations for detailed error information:

- **Docker logs**: `docker-compose logs -f`
- **Laravel logs**: `docker-compose exec app tail -f storage/logs/laravel.log`
- **Windows Event Viewer**: Application and System logs

## 🔄 Updating the Application

### Code Updates
```bash
# Pull latest changes
git pull origin main

# Rebuild and restart containers
docker-compose down
docker-compose up -d --build

# Run migrations if needed
docker-compose exec app php artisan migrate
```

### Dependency Updates
```bash
# Update PHP dependencies
docker-compose exec app composer update

# Update Node.js dependencies
docker-compose exec app npm update
docker-compose exec app npm run build
```

## 🧹 Cleanup

### Remove All Containers and Data
```bash
# Stop and remove containers
docker-compose down -v

# Remove all Docker images
docker system prune -a

# Remove project directory
rm -rf /path/to/laravel-pdf-generator
```

### Keep Data, Remove Only Containers
```bash
# Stop containers but keep volumes
docker-compose down

# Start again
docker-compose up -d
```

## 📚 Additional Resources

- [Docker Desktop for Windows](https://docs.docker.com/desktop/install/windows/)
- [WSL Installation Guide](https://docs.microsoft.com/en-us/windows/wsl/install)
- [Laravel Documentation](https://laravel.com/docs)
- [Chocolatey Documentation](https://chocolatey.org/docs)

## 🆘 Getting Help

If you encounter issues:

1. **Check the troubleshooting section above**
2. **Review Docker and Laravel logs**
3. **Verify system requirements**
4. **Check Windows Event Viewer for system errors**
5. **Ensure all Windows features are enabled**

## 📝 Notes

- **First Run**: The initial deployment may take 15-30 minutes depending on your internet speed and system performance
- **Restart Required**: After installing Docker Desktop, a system restart is required
- **Administrator Rights**: Some installations require administrator privileges
- **Antivirus**: Windows Defender or other antivirus software may need to be configured to allow Docker operations

---

**Happy Deploying! 🎉**

For more information about this project, see the main [README.md](README.md) file.
