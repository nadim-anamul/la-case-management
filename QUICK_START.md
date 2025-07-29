# 🚀 Quick Start Guide - Laravel PDF Generator

Get the project running with existing data in minutes!

## 📋 Prerequisites

- Docker
- Docker Compose
- Git

## ⚡ Quick Setup (5 minutes)

### Option 1: Docker Setup (Recommended)
```bash
# Clone the repository
git clone <your-repo-url>
cd laravel-pdf-generator

# Run the automated Docker setup script
./docker-setup.sh
```

### Option 2: Local Setup
```bash
# Clone the repository
git clone <your-repo-url>
cd laravel-pdf-generator

# Run the automated local setup script
./local-setup.sh

# Start the development server
php artisan serve
```

### 2. Access the Application
- **Web Application**: http://localhost:8000
- **Demo Data**: 4 compensation records with full data
- **Database**: localhost:3306

## 📊 What You Get

The setup includes **4 demo compensation records** with comprehensive data:

### Demo Record 1: SA-based Compensation
- **Case Number**: CASE-2024-001
- **Applicants**: আব্দুল রহমান
- **Award Types**: জমি/অবকাঠামো, জমি/গাছপালা
- **Ownership Details**: Complete SA/RS info, deed transfers, applicant info
- **Documents**: আপস- বন্টননামা, সরেজমিন তদন্ত

### Demo Record 2: RS-based Compensation
- **Case Number**: CASE-2024-002
- **Applicants**: রহিমা খাতুন
- **Award Types**: অবকাঠামো
- **Ownership Details**: RS record info, inheritance records
- **Documents**: না-দাবী নামা, এফিডেভিটের তথ্য

### Demo Record 3: Complex SA-based
- **Case Number**: CASE-2024-003
- **Applicants**: সাবরিনা আক্তার, মাহমুদা সুলতানা
- **Award Types**: জমি/অবকাঠামো, জমি/গাছপালা, অবকাঠামো
- **Ownership Details**: Multiple deed transfers, RS records
- **Documents**: আপস- বন্টননামা, না-দাবী নামা, সরেজমিন তদন্ত

### Demo Record 4: Inheritance-based
- **Case Number**: CASE-2024-004
- **Applicants**: নাসরিন আক্তার
- **Award Types**: জমি/গাছপালা
- **Ownership Details**: Inheritance records, deed transfers
- **Documents**: এফিডেভিটের তথ্য

## 🔧 Manual Setup (if script fails)

### 1. Environment Setup
```bash
cp .env.example .env
# Edit .env with your database credentials
```

### 2. Start Containers
```bash
docker compose up -d --build
```

### 3. Install Dependencies
```bash
docker compose exec app composer install
docker compose exec app npm install
```

### 4. Setup Application
```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app npm run build
```

## 📁 Data Export/Import

### Export Existing Data
```bash
./export-data.sh
```

### Import Data to New Environment
```bash
# Copy the exported SQL file
docker compose exec -T db mysql -u your_mysql_user -p your_mysql_password laravel_pdf_generator < database_backup_YYYYMMDD_HHMMSS.sql
```

## 🎯 Key Features to Test

1. **Compensation List**: View all demo records
2. **Create New**: Add new compensation records
3. **Edit Existing**: Modify demo records
4. **Preview**: View detailed compensation information
5. **Ownership Continuity**: Test step-by-step form
6. **Form Validation**: Test required field validation

## 🐛 Troubleshooting

### Common Issues

1. **Port Already in Use**
   ```bash
   # Change ports in docker-compose.yml
   ports:
     - "8001:80"  # Change 8000 to 8001
   ```

2. **Permission Denied**
   ```bash
   docker compose exec app chmod -R 775 storage bootstrap/cache
   ```

3. **Database Connection Failed**
   ```bash
   # Check if containers are running
   docker compose ps
   
   # Restart containers
   docker compose restart
   ```

4. **Assets Not Loading**
   ```bash
   docker compose exec app npm run build
   ```

### View Logs
```bash
# Application logs
docker compose logs app

# Database logs
docker compose logs db

# All logs
docker compose logs -f
```

## 📞 Support

- **Documentation**: Check README.md for detailed information
- **Issues**: Create an issue in the repository
- **Data Problems**: Use export-data.sh to backup your data

---

**Happy Coding! 🎉** 