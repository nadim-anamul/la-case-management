# 🚀 Laravel PDF Generator - Complete Windows Installation Guide

This comprehensive guide provides multiple installation options for running the Laravel PDF Generator project on Windows. Choose the method that best fits your needs and technical expertise.

## 📋 System Requirements

### Minimum Requirements
- **OS**: Windows 10 (version 1903) or Windows 11
- **Architecture**: 64-bit (x64)
- **RAM**: 8GB minimum (16GB recommended)
- **Storage**: 20GB free space minimum
- **CPU**: 2 cores minimum (4 cores recommended)

### Recommended Requirements
- **OS**: Windows 11 (latest version)
- **RAM**: 16GB or more
- **Storage**: 50GB free space
- **CPU**: 4+ cores with virtualization support
- **Internet**: Stable broadband connection

## 🎯 Installation Options Overview

| Method | Difficulty | Setup Time | Performance | Best For |
|--------|------------|------------|-------------|----------|
| **Docker Desktop** | ⭐⭐ | 15-30 min | ⭐⭐⭐⭐⭐ | Production, Development |
| **WSL2 + Docker** | ⭐⭐⭐ | 20-40 min | ⭐⭐⭐⭐⭐ | Advanced Users, Linux-like |
| **XAMPP + Manual** | ⭐⭐⭐⭐ | 30-60 min | ⭐⭐⭐ | Learning, Custom Setup |
| **Laravel Sail** | ⭐⭐ | 10-20 min | ⭐⭐⭐⭐ | Laravel Developers |

---

## 🐳 Option 1: Docker Desktop (Recommended)

The easiest and most reliable method for Windows users.

### Prerequisites
- Windows 10/11 with latest updates
- Administrator privileges
- Internet connection
- Virtualization enabled in BIOS

### Step-by-Step Installation

#### Step 1: Enable Windows Features
1. **Open Windows Features**
   - Press `Win + R`, type `optionalfeatures.exe`, press Enter
   - Or: Settings → Apps → Optional features → More Windows features

2. **Enable Required Features**
   - ✅ Windows Subsystem for Linux
   - ✅ Virtual Machine Platform
   - ✅ Hyper-V (if available)

3. **Restart Computer**
   - Required after enabling these features

#### Step 2: Install Docker Desktop
1. **Download Docker Desktop**
   - Visit: https://www.docker.com/products/docker-desktop/
   - Click "Download for Windows"

2. **Run Installer**
   - Right-click installer → "Run as Administrator"
   - Follow installation wizard
   - **Important**: Choose "Use WSL 2 instead of Hyper-V" if prompted

3. **Restart Computer**
   - Required after Docker installation

#### Step 3: Verify Docker Installation
1. **Open PowerShell as Administrator**
   ```powershell
   # Check Docker version
   docker --version
   
   # Check Docker Compose version
   docker-compose --version
   
   # Test Docker
   docker run hello-world
   ```

#### Step 4: Deploy the Application
1. **Clone the Repository**
   ```powershell
   git clone https://github.com/nadim-anamul/laravel-pdf-generator.git
   cd laravel-pdf-generator
   ```

2. **Run with Docker Compose (Production-like, using docker-compose.server.yml)**
   ```powershell
   # Stop existing containers and clean up unused resources (optional)
   docker compose -f docker-compose.server.yml down
   docker system prune -a -f
   ```

   ```powershell
   # Build and start containers
   docker compose -f docker-compose.server.yml up -d --build
   ```

   ```powershell
   # Wait for database to be ready
   while (-not (docker compose -f docker-compose.server.yml exec -T db mysqladmin ping -h localhost -u laravel -ppassword --silent 2>$null)) { Write-Host "Waiting for DB..."; Start-Sleep -Seconds 2 }
   ```

   ```powershell
   # Wait for app container to be ready
   while (-not (docker compose -f docker-compose.server.yml exec -T app php artisan --version *> $null)) { Write-Host "Waiting for app..."; Start-Sleep -Seconds 2 }
   ```

   ```powershell
   # Run database migrations (no seeding)
   docker compose -f docker-compose.server.yml exec -T app php artisan migrate --force
   ```

   ```powershell
   # One-time: generate app key and storage link if not already done
   docker compose -f docker-compose.server.yml exec -T app php artisan key:generate
   docker compose -f docker-compose.server.yml exec -T app php artisan storage:link
   ```

   ```powershell
   # Build frontend assets (one-time or when assets change)
   docker compose -f docker-compose.server.yml exec -T app npm install
   docker compose -f docker-compose.server.yml exec -T app npm run build
   ```

3. **Access Application**
   - Web App: http://localhost:8000
   - Database: localhost:3307

### Docker Troubleshooting

#### Common Issues & Solutions

**Issue**: "Docker Desktop is starting..."
- **Solution**: Wait 2-5 minutes for first startup
- **Alternative**: Restart Docker Desktop from system tray

**Issue**: "WSL 2 installation is incomplete"
- **Solution**: Run in PowerShell as Administrator:
  ```powershell
  wsl --install
  wsl --set-default-version 2
  ```

**Issue**: "Virtualization not enabled"
- **Solution**: Enable in BIOS/UEFI:
  1. Restart and enter BIOS (usually F2, F10, or Del)
  2. Find "Virtualization Technology", "Intel VT-x", or "AMD-V"
  3. Enable and save

---

## 🐧 Option 2: WSL2 + Docker (Advanced)

For users who prefer a Linux-like development environment.

### Prerequisites
- Windows 10/11 (version 2004 or higher)
- Administrator privileges
- Internet connection

### Step-by-Step Installation

#### Step 1: Install WSL2
1. **Open PowerShell as Administrator**
   ```powershell
   wsl --install
   ```

2. **Set WSL2 as Default**
   ```powershell
   wsl --set-default-version 2
   ```

3. **Install Ubuntu Distribution**
   ```powershell
   wsl --install -d Ubuntu
   ```

4. **Restart Computer**

#### Step 2: Setup Ubuntu Environment
1. **Open Ubuntu from Start Menu**
2. **Create User Account**
   ```bash
   # Follow prompts to create username/password
   ```

3. **Update System**
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

#### Step 3: Install Docker in WSL2
1. **Install Docker**
   ```bash
   # Install prerequisites
   sudo apt install -y apt-transport-https ca-certificates curl software-properties-common
   ```
   
   ```bash
   # Add Docker GPG key
   curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
   ```
   
   ```bash
   # Add Docker repository
   sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
   ```
   
   ```bash
   # Update package list
   sudo apt update
   ```
   
   ```bash
   # Install Docker
   sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
   ```

2. **Start Docker Service**
   ```bash
   # Start Docker service
   sudo service docker start
   ```
   
   ```bash
   # Add user to docker group
   sudo usermod -aG docker $USER
   ```
   
   ```bash
   # Log out and back in, or restart WSL
   wsl --shutdown
   ```

#### Step 4: Deploy Application
1. **Clone Repository**
   ```bash
   git clone https://github.com/nadim-anamul/laravel-pdf-generator.git
   cd laravel-pdf-generator
   ```

2. **Run Deployment**
   ```bash
   chmod +x deploy-windows.sh
   ./deploy-windows.sh
   ```

### WSL2 Troubleshooting

**Issue**: "WSL 2 requires an update to its kernel component"
- **Solution**: Download from: https://aka.ms/wsl2kernel

**Issue**: "Docker service not starting"
- **Solution**: 
  ```bash
  sudo service docker start
  sudo systemctl enable docker
  ```

---

## 🗄️ Option 3: XAMPP + Manual Setup

For users who prefer traditional LAMP stack setup.

### Prerequisites
- Windows 10/11
- Administrator privileges
- Internet connection

### Step-by-Step Installation

#### Step 1: Install XAMPP
1. **Download XAMPP**
   - Visit: https://www.apachefriends.org/download.html
   - Download Windows version with PHP 8.1+

2. **Install XAMPP**
   - Run installer as Administrator
   - Choose components: Apache, MySQL, PHP, phpMyAdmin
   - Install to `C:\xampp`

#### Step 2: Install Composer
1. **Download Composer**
   - Visit: https://getcomposer.org/download/
   - Download Composer-Setup.exe

2. **Install Composer**
   - Run installer
   - Point to PHP in XAMPP: `C:\xampp\php\php.exe`

#### Step 3: Install Node.js
1. **Download Node.js**
   - Visit: https://nodejs.org/
   - Download LTS version

2. **Install Node.js**
   - Run installer
   - Verify installation:
     ```cmd
     node --version
     npm --version
     ```

#### Step 4: Setup Project
1. **Clone Repository**
   ```cmd
   git clone https://github.com/nadim-anamul/laravel-pdf-generator.git
   ```
   
   ```cmd
   cd laravel-pdf-generator
   ```

2. **Install Dependencies**
   ```cmd
   composer install
   ```
   
   ```cmd
   npm install
   ```

3. **Configure Environment**
   ```cmd
   copy .env.example .env
   ```

4. **Edit .env File**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_pdf_generator
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Create Database**
   - Open http://localhost/phpmyadmin
   - Create database: `laravel_pdf_generator`

6. **Setup Laravel**
   ```cmd
   php artisan key:generate
   ```
   
   ```cmd
   php artisan migrate
   ```
   
   ```cmd
   php artisan storage:link
   ```

7. **Build Assets**
   ```cmd
   npm run build
   ```

8. **Start Development Server**
   ```cmd
   php artisan serve
   ```

### XAMPP Troubleshooting

**Issue**: "Port 80/3306 already in use"
- **Solution**: Change ports in XAMPP Control Panel

**Issue**: "PHP extensions missing"
- **Solution**: Enable in `C:\xampp\php\php.ini`

---

## ⛵ Option 4: Laravel Sail (Laravel Developers)

For Laravel developers who prefer Sail's simplicity.

### Prerequisites
- Docker Desktop installed
- Git for Windows
- Composer for Windows

### Step-by-Step Installation

#### Step 1: Install Laravel Sail
1. **Install Sail Globally**
   ```cmd
   composer global require laravel/sail
   ```

2. **Add to PATH**
   - Add `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin` to PATH

#### Step 2: Setup Project
1. **Clone Repository**
   ```cmd
   git clone https://github.com/nadim-anamul/laravel-pdf-generator.git
   ```
   
   ```cmd
   cd laravel-pdf-generator
   ```

2. **Install Dependencies**
   ```cmd
   composer install
   ```
   
   ```cmd
   npm install
   ```

3. **Start Sail**
   ```cmd
   sail up -d
   ```

4. **Setup Laravel**
   ```cmd
   sail artisan key:generate
   ```
   
   ```cmd
   sail artisan migrate
   ```
   
   ```cmd
   sail artisan storage:link
   ```

5. **Build Assets**
   ```cmd
   sail npm run build
   ```

---

## 🔧 Troubleshooting Guide

### General Issues

#### Port Conflicts
```cmd
# Check what's using a port
netstat -ano | findstr :8000
```

```cmd
# Kill process by PID
taskkill /PID <PID> /F
```

#### Permission Issues
- **Solution**: Run terminal as Administrator
- **Alternative**: Check Windows Defender settings

#### Antivirus Interference
- **Solution**: Add project folder to antivirus exclusions
- **Alternative**: Temporarily disable real-time protection

### Docker-Specific Issues

#### Docker Won't Start
1. **Check Windows Features**
   ```powershell
   # Enable Hyper-V (if available)
   Enable-WindowsOptionalFeature -Online -FeatureName Microsoft-Hyper-V -All
   ```

2. **Check WSL2**
   ```powershell
   wsl --status
   wsl --update
   ```

3. **Reset Docker Desktop**
   - Docker Desktop → Settings → Troubleshoot → Reset to factory defaults

#### Container Build Failures
```cmd
# Clean Docker system
docker system prune -a
```

```cmd
# Rebuild without cache
docker-compose build --no-cache
```

### Database Issues

#### Connection Refused
1. **Check if MySQL is running**
   ```cmd
   docker-compose ps
   ```

2. **Check database logs**
   ```cmd
   docker-compose logs db
   ```

3. **Reset database**
   ```cmd
   docker-compose down -v
   docker-compose up -d
   ```

---

## 📱 Application Management

### Starting the Application
```cmd
# Docker method
docker-compose up -d
```

```cmd
# XAMPP method
# Start Apache and MySQL in XAMPP Control Panel
```

```cmd
# Sail method
sail up -d
```

### Stopping the Application
```cmd
# Docker method
docker-compose down
```

```cmd
# XAMPP method
# Stop services in XAMPP Control Panel
```

```cmd
# Sail method
sail down
```

### Viewing Logs
```cmd
# Docker logs
docker-compose logs -f
```

```cmd
# Laravel logs
docker-compose exec app tail -f storage/logs/laravel.log
```

```cmd
# Or for XAMPP/Sail
tail -f storage/logs/laravel.log
```

### Database Management
```cmd
# Access MySQL (Docker)
docker-compose exec db mysql -u laravel -p
```

```cmd
# Access MySQL (XAMPP)
# Use phpMyAdmin at http://localhost/phpmyadmin
```

```cmd
# Run migrations
docker-compose exec app php artisan migrate
```

```cmd
# Or: php artisan migrate (XAMPP)
php artisan migrate
```

---

## 🔄 Updating the Application

### Code Updates
```cmd
# Pull latest changes
git pull origin main
```

```cmd
# Update dependencies
composer install
```

```cmd
# Update Node.js dependencies
npm install
```

```cmd
# Rebuild (Docker)
docker-compose down
```

```cmd
# Rebuild (Docker)
docker-compose up -d --build
```

```cmd
# Rebuild (XAMPP)
npm run build
```

### System Updates
1. **Update Windows** to latest version
2. **Update Docker Desktop** when available
3. **Update XAMPP** to latest version
4. **Update Node.js** to LTS version

---

## 🧹 Cleanup and Uninstallation

### Remove Application
```cmd
# Stop containers
docker-compose down -v
```

```cmd
# Remove project folder
rmdir /s laravel-pdf-generator
```

### Remove Docker
1. **Uninstall Docker Desktop** from Control Panel
2. **Remove Docker data**: `%USERPROFILE%\AppData\Local\Docker`
3. **Remove Docker Desktop**: `%PROGRAMFILES%\Docker\Docker`

### Remove XAMPP
1. **Stop all services** in XAMPP Control Panel
2. **Uninstall XAMPP** from Control Panel
3. **Remove data**: `C:\xampp`

---

## 📚 Additional Resources

### Official Documentation
- [Docker Desktop for Windows](https://docs.docker.com/desktop/install/windows/)
- [WSL Installation Guide](https://docs.microsoft.com/en-us/windows/wsl/install)
- [Laravel Documentation](https://laravel.com/docs)
- [XAMPP Documentation](https://www.apachefriends.org/docs.html)

### Community Resources
- [Laravel Discord](https://discord.gg/laravel)
- [Docker Community](https://forums.docker.com/)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)

### Video Tutorials
- Docker Desktop installation walkthrough
- WSL2 setup guide
- Laravel development environment setup

---

## 🆘 Getting Help

### Before Asking for Help
1. ✅ Check this troubleshooting guide
2. ✅ Review application logs
3. ✅ Verify system requirements
4. ✅ Check Windows Event Viewer
5. ✅ Ensure all features are enabled

### Where to Get Help
1. **GitHub Issues**: Report bugs and feature requests
2. **Community Forums**: Ask questions and share solutions
3. **Documentation**: Check official guides and tutorials
4. **Stack Overflow**: Search for existing solutions

### Information to Include
When asking for help, include:
- Windows version and build number
- Installation method used
- Error messages and logs
- Steps already tried
- System specifications

---

## 📝 Notes and Tips

### Performance Tips
- **SSD Storage**: Use SSD for better performance
- **RAM Allocation**: Allocate more RAM to Docker if available
- **Antivirus**: Exclude project folders from real-time scanning
- **Windows Updates**: Keep Windows updated for best compatibility

### Security Considerations
- **Firewall**: Configure Windows Firewall for development ports
- **Antivirus**: Add development tools to exclusions
- **Updates**: Regularly update all components
- **Backups**: Backup your project and database regularly

### Development Workflow
- **Git**: Use Git for version control
- **Branches**: Work on feature branches
- **Testing**: Run tests before committing
- **Documentation**: Keep documentation updated

---

## 🎉 Success Checklist

After installation, verify these items:

- ✅ Application accessible at http://localhost:8000
- ✅ Database connection working
- ✅ PDF generation functional
- ✅ All form sections working
- ✅ Assets loading correctly
- ✅ Logs being generated
- ✅ Docker containers running (if using Docker)
- ✅ Services starting automatically

---

## 🚀 **Production & Network Access Setup**

### **Option A: Windows Service (Recommended for Production)**

This method ensures your application starts automatically after PC restarts and runs as a background service.

#### **Step 1: Install NSSM (Non-Sucking Service Manager)**
```cmd
# Download NSSM
curl -L -o nssm.zip https://nssm.cc/release/nssm-2.24.zip
```

```cmd
# Extract to C:\nssm
mkdir C:\nssm
tar -xf nssm.zip -C C:\nssm
```

```cmd
# Add to PATH (run as Administrator)
setx PATH "%PATH%;C:\nssm\nssm-2.24\win64" /M
```

#### **Step 2: Create Windows Service for Docker**
```cmd
# Create Docker service (run as Administrator)
nssm install "LaravelPDFGenerator" "C:\Program Files\Docker\Docker\Docker Desktop.exe"
```

```cmd
# Set startup type to automatic
nssm set "LaravelPDFGenerator" Start SERVICE_AUTO_START
```

```cmd
# Start the service
nssm start "LaravelPDFGenerator"
```

#### **Step 3: Create Laravel Application Service**
```cmd
# Create batch file for startup
echo @echo off > C:\laravel-startup.bat
echo cd /d "C:\path\to\laravel-pdf-generator" >> C:\laravel-startup.bat
echo docker-compose up -d >> C:\laravel-startup.bat
```

```cmd
# Create service for Laravel
nssm install "LaravelApp" "C:\laravel-startup.bat"
```

```cmd
# Set startup type to automatic
nssm set "LaravelApp" Start SERVICE_AUTO_START
```

```cmd
# Set dependency on Docker service
nssm set "LaravelApp" DependOnService "LaravelPDFGenerator"
```

```cmd
# Start the service
nssm start "LaravelApp"
```

### **Option B: Task Scheduler (Alternative Method)**

#### **Step 1: Create Startup Script**
```cmd
# Create startup script
echo @echo off > C:\laravel-startup.bat
echo timeout /t 30 >> C:\laravel-startup.bat
echo cd /d "C:\path\to\laravel-pdf-generator" >> C:\laravel-startup.bat
echo docker-compose up -d >> C:\laravel-startup.bat
```

#### **Step 2: Setup Task Scheduler**
1. **Open Task Scheduler**
   - Press `Win + R`, type `taskschd.msc`, press Enter

2. **Create Basic Task**
   - Right-click → "Create Basic Task"
   - Name: "Laravel PDF Generator Startup"
   - Trigger: "When the computer starts"
   - Action: "Start a program"
   - Program: `C:\laravel-startup.bat`
   - Finish

3. **Advanced Settings**
   - Right-click task → Properties
   - General tab: Check "Run whether user is logged on or not"
   - Settings tab: Check "Allow task to be run on demand"

---

## 🌐 **Local Network Access Setup**

### **Step 1: Find Your Local IP Address**
```cmd
# Find your local IP address
ipconfig
```

Look for your local IP (usually starts with `192.168.x.x` or `10.x.x.x`)

### **Step 2: Configure Docker for Network Access**
```cmd
# Stop current containers
docker-compose down
```

Edit your `docker-compose.yml` file to bind to all network interfaces:

```yaml
services:
  app:
    ports:
      - "0.0.0.0:8000:8000"  # Bind to all interfaces
    # ... other settings
```

### **Step 3: Configure Windows Firewall**
```cmd
# Allow incoming connections on port 8000 (run as Administrator)
netsh advfirewall firewall add rule name="Laravel PDF Generator" dir=in action=allow protocol=TCP localport=8000
```

```cmd
# Allow outgoing connections
netsh advfirewall firewall add rule name="Laravel PDF Generator Out" dir=out action=allow protocol=TCP localport=8000
```

### **Step 4: Test Network Access**
1. **From your PC**: http://localhost:8000
2. **From other devices**: http://YOUR_LOCAL_IP:8000
   - Example: http://192.168.1.100:8000

### **Step 5: Make it Permanent**
```cmd
# Create a network startup script
echo @echo off > C:\laravel-network-startup.bat
echo cd /d "C:\path\to\laravel-pdf-generator" >> C:\laravel-network-startup.bat
echo docker-compose down >> C:\laravel-network-startup.bat
echo docker-compose up -d >> C:\laravel-network-startup.bat
```

---

## 🔧 **Advanced Network Configuration**

### **Custom Domain Setup (Optional)**
1. **Edit Windows Hosts File**
   ```cmd
   # Open hosts file as Administrator
   notepad C:\Windows\System32\drivers\etc\hosts
   ```

2. **Add Local Domain**
   ```
   127.0.0.1 laravel-pdf.local
   192.168.1.100 laravel-pdf.local
   ```

3. **Access via**: http://laravel-pdf.local:8000

### **HTTPS Setup (Optional)**
```cmd
# Generate self-signed certificate
openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365 -nodes
```

Update `docker-compose.yml`:
```yaml
services:
  app:
    ports:
      - "0.0.0.0:443:443"
    volumes:
      - ./cert.pem:/etc/ssl/certs/cert.pem
      - ./key.pem:/etc/ssl/private/key.pem
```

---

## 📱 **Access from Mobile Devices**

### **Android/iOS Access**
1. **Ensure devices are on same WiFi network**
2. **Access via**: http://YOUR_LOCAL_IP:8000
3. **Test PDF generation on mobile devices**

### **Network Security Considerations**
```cmd
# Restrict access to specific IP ranges (optional)
netsh advfirewall firewall add rule name="Laravel Restricted" dir=in action=allow protocol=TCP localport=8000 remoteip=192.168.1.0/24
```

---

## 🚀 **Production Deployment Checklist**

After setting up auto-start and network access:

- ✅ **Auto-start service** configured and tested
- ✅ **Windows Firewall** configured for port 8000
- ✅ **Network access** working from other devices
- ✅ **Service dependency** properly configured
- ✅ **Startup delay** sufficient for Docker to initialize
- ✅ **Error logging** configured for troubleshooting
- ✅ **Backup strategy** in place for data persistence

---

**Happy Developing! 🚀**

For more information about this project, see the main [README.md](README.md) file.

---

*Last updated: August 2025*
*Windows compatibility: Windows 10/11 (64-bit)*
