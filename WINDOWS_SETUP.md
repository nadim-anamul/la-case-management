# Laravel PDF Generator - Windows Setup Guide

A comprehensive guide to set up the Laravel PDF Generator project on Windows using Docker or XAMPP, with auto-startup and local network access configuration.

## 📋 Table of Contents

- [Prerequisites](#prerequisites)
- [Method 1: Docker Setup (Recommended)](#method-1-docker-setup-recommended)
- [Method 2: XAMPP Setup](#method-2-xampp-setup)
- [Local Network Access Configuration](#local-network-access-configuration)
- [Auto-Startup Configuration](#auto-startup-configuration)
- [Troubleshooting](#troubleshooting)
- [Additional Resources](#additional-resources)

## 🔧 Prerequisites

### System Requirements
- **Windows 10/11** (64-bit)
- **RAM**: Minimum 4GB, Recommended 8GB+
- **Storage**: At least 2GB free space
- **Network**: Internet connection for initial setup

### Required Software

#### For Docker Setup:
- [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/)
- [Git for Windows](https://git-scm.com/download/win)
- [Visual Studio Code](https://code.visualstudio.com/) (Optional but recommended)

#### For XAMPP Setup:
- [XAMPP for Windows](https://www.apachefriends.org/download.html) (PHP 8.2+)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/) (LTS version)
- [Git for Windows](https://git-scm.com/download/win)
- [Google Chrome](https://www.google.com/chrome/) (Required for PDF generation)

---

## Method 1: Docker Setup (Recommended)

### Step 1: Install Docker Desktop

1. Download and install [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/)
2. During installation, ensure **"Use WSL 2 instead of Hyper-V"** is selected
3. Restart your computer when prompted
4. Launch Docker Desktop and complete the initial setup

### Step 2: Clone the Project

```bash
# Open Command Prompt or PowerShell as Administrator
cd C:\
git clone <your-repository-url> pdf-generate
cd pdf-generate
```

### Step 3: Create Environment File

```bash
# Copy the example environment file (create one if it doesn't exist)
copy NUL .env

# Edit .env file with the following content:
```

Create `.env` file with this content:
```env
APP_NAME="PDF Generator"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=password

# PDF Generation Settings
PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome
CHROME_PATH=/usr/bin/google-chrome
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
```

### Step 4: Build and Start Docker Containers

```bash
# Build and start the containers
docker-compose up -d --build

# Check container status
docker-compose ps
```

### Step 5: Initialize the Application

```bash
# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations and seed database
docker-compose exec app php artisan migrate --seed

# Create storage link
docker-compose exec app php artisan storage:link
```

### Step 6: Access the Application

- **Local Access**: http://localhost:8000
- **Network Access**: http://YOUR_WINDOWS_IP:8000

To find your Windows IP address:
```cmd
ipconfig | findstr "IPv4"
```

---

## Method 2: XAMPP Setup

### Step 1: Install Required Software

1. **Install XAMPP**:
   - Download XAMPP with PHP 8.2+ from [Apache Friends](https://www.apachefriends.org/download.html)
   - Install to `C:\xampp`
   - Start Apache and MySQL services from XAMPP Control Panel

2. **Install Composer**:
   - Download from [getcomposer.org](https://getcomposer.org/download/)
   - During installation, point to XAMPP's PHP: `C:\xampp\php\php.exe`

3. **Install Node.js**:
   - Download LTS version from [nodejs.org](https://nodejs.org/)
   - Verify installation: `node --version` and `npm --version`

4. **Install Git**:
   - Download from [git-scm.com](https://git-scm.com/download/win)

### Step 2: Clone and Setup Project

```bash
# Navigate to XAMPP htdocs directory
cd C:\xampp\htdocs

# Clone the project
git clone <your-repository-url> pdf-generate
cd pdf-generate

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

### Step 3: Database Configuration

1. **Open XAMPP Control Panel**
2. **Start Apache and MySQL**
3. **Create Database**:
   - Open http://localhost/phpmyadmin
   - Create new database named `laravel`
   - Create user `laravel` with password `password`
   - Grant all privileges to `laravel` user

### Step 4: Environment Configuration

Create `.env` file in project root:
```env
APP_NAME="PDF Generator"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost/pdf-generate/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=password

# Chrome/Chromium path for Windows
PUPPETEER_EXECUTABLE_PATH="C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe"
CHROME_PATH="C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe"
```

### Step 5: Initialize Application

```bash
# Generate application key
php artisan key:generate

# Run migrations and seed database
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Set permissions (run as Administrator)
icacls storage /grant Everyone:F /T
icacls bootstrap\cache /grant Everyone:F /T
```

### Step 6: Configure Virtual Host (Optional but Recommended)

1. **Edit Apache Configuration**:
   - Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
   - Add the following:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/pdf-generate/public"
    ServerName pdf-generate.local
    <Directory "C:/xampp/htdocs/pdf-generate/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

2. **Edit Hosts File**:
   - Open `C:\Windows\System32\drivers\etc\hosts` as Administrator
   - Add: `127.0.0.1 pdf-generate.local`

3. **Restart Apache**

### Step 7: Access the Application

- **Local Access**: http://localhost/pdf-generate/public or http://pdf-generate.local
- **Network Access**: http://YOUR_WINDOWS_IP/pdf-generate/public

---

## 🌐 Local Network Access Configuration

### For Docker Setup:

1. **Configure Docker Compose** (already configured in the provided docker-compose.yml):
   ```yaml
   ports:
     - "8000:8000"  # Binds to all interfaces
   ```

2. **Windows Firewall Configuration**:
   ```cmd
   # Run as Administrator
   netsh advfirewall firewall add rule name="Laravel Docker" dir=in action=allow protocol=TCP localport=8000
   ```

### For XAMPP Setup:

1. **Configure Apache to Listen on All Interfaces**:
   - Edit `C:\xampp\apache\conf\httpd.conf`
   - Find `Listen 80` and ensure it's not restricted to localhost
   - Add: `Listen 0.0.0.0:80`

2. **Windows Firewall Configuration**:
   ```cmd
   # Run as Administrator
   netsh advfirewall firewall add rule name="Apache HTTP" dir=in action=allow protocol=TCP localport=80
   netsh advfirewall firewall add rule name="MySQL" dir=in action=allow protocol=TCP localport=3306
   ```

3. **Find Your Windows IP Address**:
   ```cmd
   ipconfig | findstr "IPv4"
   ```

4. **Access from Other Devices**:
   - Use: `http://YOUR_WINDOWS_IP/pdf-generate/public`

---

## 🚀 Auto-Startup Configuration

### For Docker Setup:

1. **Configure Docker Desktop Auto-Start**:
   - Open Docker Desktop Settings
   - Go to "General" tab
   - Check "Start Docker Desktop when you log in"

2. **Create Windows Service** (Advanced):
   Create `start-pdf-generator.bat` in `C:\Scripts\`:
   ```batch
   @echo off
   cd C:\pdf-generate
   docker-compose up -d
   echo PDF Generator started successfully
   pause
   ```

3. **Add to Windows Startup**:
   - Press `Win + R`, type `shell:startup`
   - Copy the batch file to this folder

### For XAMPP Setup:

1. **Install XAMPP as Windows Service**:
   - Open XAMPP Control Panel as Administrator
   - Click "Install" next to Apache and MySQL services
   - Set services to start automatically:
     ```cmd
     sc config Apache2.4 start= auto
     sc config mysql start= auto
     ```

2. **Create Startup Script**:
   Create `start-pdf-generator.bat` in `C:\Scripts\`:
   ```batch
   @echo off
   echo Starting PDF Generator services...
   
   REM Start XAMPP services
   net start Apache2.4
   net start mysql
   
   REM Wait for services to start
   timeout /t 10
   
   echo Services started successfully
   echo Access your application at: http://localhost/pdf-generate/public
   pause
   ```

3. **Add to Windows Startup**:
   - Press `Win + R`, type `shell:startup`
   - Copy the batch file to this folder

4. **Alternative: Task Scheduler** (More reliable):
   - Open Task Scheduler
   - Create Basic Task
   - Name: "PDF Generator Startup"
   - Trigger: "When the computer starts"
   - Action: "Start a program"
   - Program: `C:\Scripts\start-pdf-generator.bat`
   - Check "Run with highest privileges"

---

## 🔍 Troubleshooting

### Common Docker Issues:

**Docker Desktop won't start:**
```bash
# Restart Docker Desktop
# Or reset Docker Desktop to factory defaults
```

**Port 8000 already in use:**
```bash
# Find process using port 8000
netstat -ano | findstr :8000

# Kill the process (replace PID with actual process ID)
taskkill /PID <PID> /F

# Or change port in docker-compose.yml
ports:
  - "8001:8000"
```

**Container build fails:**
```bash
# Clean Docker cache
docker system prune -a

# Rebuild without cache
docker-compose build --no-cache
```

### Common XAMPP Issues:

**Apache won't start (Port 80 conflict):**
1. Check if IIS is running: `net stop w3svc`
2. Check Skype: Disable "Use port 80 and 443" in Skype settings
3. Change Apache port in `C:\xampp\apache\conf\httpd.conf`

**MySQL won't start (Port 3306 conflict):**
1. Stop Windows MySQL service: `net stop mysql`
2. Change MySQL port in `C:\xampp\mysql\bin\my.ini`

**Permission denied errors:**
```cmd
# Run as Administrator
icacls C:\xampp\htdocs\pdf-generate /grant Everyone:F /T
```

**PHP extensions missing:**
- Edit `C:\xampp\php\php.ini`
- Uncomment required extensions:
  ```ini
  extension=gd
  extension=mbstring
  extension=pdo_mysql
  extension=zip
  ```

**Chrome/Chromium not found for PDF generation:**
- Verify Chrome installation path in `.env` file
- Install Chrome if not present
- For 32-bit systems, path might be: `C:\Program Files (x86)\Google\Chrome\Application\chrome.exe`

### Network Access Issues:

**Can't access from other devices:**
1. Check Windows Firewall settings
2. Verify IP address: `ipconfig`
3. Test connectivity: `ping YOUR_WINDOWS_IP` from another device
4. Ensure router allows internal network communication

**Slow performance on network:**
- Use wired connection instead of WiFi
- Check for network congestion
- Consider using a dedicated development network

---

## 📚 Additional Resources

### Useful Commands:

**Docker:**
```bash
# View logs
docker-compose logs -f

# Restart containers
docker-compose restart

# Stop containers
docker-compose down

# Update containers
docker-compose pull && docker-compose up -d
```

**XAMPP:**
```bash
# Check PHP version
php -v

# Check installed extensions
php -m

# Test PHP configuration
php -i | findstr "extension_dir"
```

### Development Tools:

- **VS Code Extensions**:
  - Laravel Extension Pack
  - PHP Intelephense
  - Docker Extension
  - Remote - WSL (if using WSL2)

- **Database Management**:
  - phpMyAdmin (included with XAMPP)
  - HeidiSQL
  - MySQL Workbench

### Performance Optimization:

**For Docker:**
- Allocate more resources in Docker Desktop settings
- Use WSL2 backend for better performance
- Enable BuildKit for faster builds

**For XAMPP:**
- Increase PHP memory limit in `php.ini`
- Optimize MySQL settings in `my.ini`
- Use SSD storage for better performance

---

## 🔐 Security Considerations

### Production Deployment:
- Change default passwords
- Use environment-specific `.env` files
- Enable HTTPS with SSL certificates
- Restrict database access
- Regular security updates

### Local Development:
- Use strong passwords for database
- Keep software updated
- Use firewall rules to restrict access
- Regular backups of your work

---

## 📞 Support

If you encounter issues not covered in this guide:

1. Check the main project README.md
2. Review Laravel documentation
3. Check Docker/XAMPP official documentation
4. Search for similar issues in the project repository

---

**Happy Coding! 🚀**

*Last updated: $(Get-Date -Format "yyyy-MM-dd")*
