# Production Deployment Guide

This guide explains how to deploy the PDF Generation application to production with enhanced database handling and error recovery.

## 🚀 Quick Deployment

### Standard Deployment
```bash
./deploy-production.sh
```

This script will:
- Stop and rebuild containers
- Create database backup before changes
- Run migrations with rollback capability
- Seed database with demo data (if needed)
- Verify application health
- Clean up old backups

## 📋 Pre-Deployment Checklist

1. **Ensure all changes are committed**
   ```bash
   git status
   git add .
   git commit -m "Ready for deployment"
   ```

2. **Check current database status**
   ```bash
   ./check-migration-status.sh
   ```

3. **Verify Docker is running**
   ```bash
   docker --version
   docker compose version
   ```

## 🔧 Deployment Scripts

### 1. Main Deployment Script (`deploy-production.sh`)

**Features:**
- ✅ Automatic database backup before changes
- ✅ Enhanced error handling with rollback
- ✅ Database readiness checks
- ✅ Application health verification
- ✅ Colored output for better visibility
- ✅ Automatic cleanup of old backups

**Usage:**
```bash
./deploy-production.sh
```

### 2. Database Restore Script (`restore-from-backup.sh`)

**Features:**
- ✅ Restore from any backup file
- ✅ Automatic backup before restore
- ✅ Database connection verification
- ✅ Application health check after restore

**Usage:**
```bash
# List available backups
ls -la backup_*.sql

# Restore from specific backup
./restore-from-backup.sh backup_20241201_143022.sql
```

### 3. Migration Status Checker (`check-migration-status.sh`)

**Features:**
- ✅ Database connection testing
- ✅ Table structure verification
- ✅ Data count reporting
- ✅ Migration status display
- ✅ Application health check

**Usage:**
```bash
./check-migration-status.sh
```

### 4. Deployment Issue Fixer (`fix-deployment-issues.sh`)

**Features:**
- ✅ Fixes storage link conflicts
- ✅ Corrects permission issues
- ✅ Clears application caches
- ✅ Restarts application container
- ✅ Provides diagnostic information

**Usage:**
```bash
./fix-deployment-issues.sh
```

## 🗄️ Database Management

### Automatic Backups
- Backups are created before any database changes
- Stored as `backup_YYYYMMDD_HHMMSS.sql`
- Last 5 backups are kept automatically
- Backup file name is stored in `.last_backup_file`

### Migration Handling
- **Fresh Install**: Runs all migrations from scratch
- **Existing Database**: Runs only pending migrations
- **Rollback**: Automatically rolls back on failure
- **Error Recovery**: Restores from backup if migration fails

### Seeder Behavior
- Checks for existing demo data before seeding
- Skips seeding if data already exists
- Non-blocking (won't fail deployment)

## 🚨 Troubleshooting

### Common Issues

#### 1. Database Connection Failed
```bash
# Check if database container is running
docker ps | grep laravel-db

# Check database logs
docker compose -f docker-compose.server.yml logs db

# Restart database container
docker compose -f docker-compose.server.yml restart db
```

#### 2. Migration Failed
```bash
# Check migration status
./check-migration-status.sh

# View migration logs
docker compose -f docker-compose.server.yml exec app php artisan migrate:status

# Manual rollback (if needed)
docker compose -f docker-compose.server.yml exec app php artisan migrate:rollback --step=1
```

#### 3. Application Not Responding
```bash
# Check application logs
docker compose -f docker-compose.server.yml logs app

# Check application container
docker ps | grep laravel-app

# Restart application
docker compose -f docker-compose.server.yml restart app
```

#### 4. Data Loss Recovery
```bash
# List available backups
ls -la backup_*.sql

# Restore from backup
./restore-from-backup.sh backup_YYYYMMDD_HHMMSS.sql
```

#### 5. Application Health Check Failed
```bash
# Run the deployment issue fixer
./fix-deployment-issues.sh

# Check application logs
docker compose -f docker-compose.server.yml logs -f app

# Check if storage link exists
docker compose -f docker-compose.server.yml exec app ls -la public/storage

# Restart application container
docker compose -f docker-compose.server.yml restart app
```

#### 6. Storage Link Already Exists
```bash
# Remove existing storage link
docker compose -f docker-compose.server.yml exec app rm -f public/storage

# Create new storage link
docker compose -f docker-compose.server.yml exec app php artisan storage:link
```

### Manual Database Operations

#### Reset Database (DANGER - Data Loss)
```bash
# Stop containers
docker compose -f docker-compose.server.yml down

# Remove database volume
docker volume rm pdf-generate_dbdata

# Restart containers
docker compose -f docker-compose.server.yml up -d

# Run migrations and seeders
docker compose -f docker-compose.server.yml exec app php artisan migrate --force
docker compose -f docker-compose.server.yml exec app php artisan db:seed --force
```

#### Manual Migration
```bash
# Run specific migration
docker compose -f docker-compose.server.yml exec app php artisan migrate --force

# Rollback last migration
docker compose -f docker-compose.server.yml exec app php artisan migrate:rollback --step=1

# Check migration status
docker compose -f docker-compose.server.yml exec app php artisan migrate:status
```

## 📊 Monitoring

### Health Checks
```bash
# Application health
curl -f http://localhost:8000

# Database health
docker compose -f docker-compose.server.yml exec db mysqladmin ping -h localhost -u laravel -ppassword

# Container status
docker ps
```

### Logs
```bash
# Application logs
docker compose -f docker-compose.server.yml logs -f app

# Database logs
docker compose -f docker-compose.server.yml logs -f db

# All logs
docker compose -f docker-compose.server.yml logs -f
```

## 🆕 Recent Updates & New Features

### Database Schema Updates
- **land_category JSON field**: New field for storing land category information with award types
- **Conditional award serial numbers**: Separate fields for land, tree, and infrastructure awards
- **Enhanced RS records**: Support for multiple owner names and DP khatian checkbox
- **Updated award_serial_no**: Made nullable to prevent database errors

### UI/UX Improvements
- **Improved button colors**: Orange color for RS record buttons, consistent styling
- **Enhanced checkbox alignment**: Better spacing and styling for DP khatian checkbox
- **Conditional field display**: Dynamic form fields based on award type selection
- **Multiple owner names**: Support for adding multiple RS record owners

### New Migrations Applied
```bash
# Recent migrations included in deployment:
- 2025_08_03_190921_add_land_category_to_compensations_table.php
- 2025_08_03_193616_add_award_serial_no_fields_to_compensations_table.php
- 2025_08_03_193935_make_award_serial_no_nullable.php
```

### Updated Database Seeder
- **Enhanced demo data**: Includes new RS records structure with owner_names array
- **DP khatian support**: Default checked state for new RS records
- **Multiple owner examples**: Demo data shows various owner name combinations
- **Backward compatibility**: Handles both old and new data structures

### 🚀 Dynamic Deployment System
- **Automatic change detection**: Scripts now automatically detect new migrations, features, and changes
- **Smart feature detection**: Identifies database schema updates, UI improvements, and new components
- **Real-time summaries**: Generates deployment summaries based on actual code changes
- **Independent summary generator**: `./generate-deployment-summary.sh` for standalone deployment analysis

**Usage:**
```bash
# Generate deployment summary without deploying
./generate-deployment-summary.sh

# Full deployment with dynamic summaries
./deploy-production.sh
```

## 🔒 Security Notes

1. **Database Credentials**: Stored in `docker-compose.server.yml`
2. **Backup Files**: Contain sensitive data, secure appropriately
3. **Production Environment**: Uses `APP_ENV=production`
4. **Network Access**: Application exposed on port 8000

## 📝 Deployment Log

Each deployment creates:
- Database backup: `backup_YYYYMMDD_HHMMSS.sql`
- Backup reference: `.last_backup_file`
- Console output with colored status messages

## 🆘 Emergency Procedures

### Complete System Reset
```bash
# Stop everything
docker compose -f docker-compose.server.yml down

# Remove all containers and volumes
docker system prune -a -f --volumes

# Rebuild from scratch
./deploy-production.sh
```

### Data Recovery
```bash
# Find latest backup
ls -t backup_*.sql | head -1

# Restore from backup
./restore-from-backup.sh $(ls -t backup_*.sql | head -1)
```

## 📞 Support

If you encounter issues:
1. Run `./check-migration-status.sh` for diagnostics
2. Check logs: `docker compose -f docker-compose.server.yml logs -f`
3. Review this guide for troubleshooting steps
4. Restore from backup if needed: `./restore-from-backup.sh <backup_file>`

---

**Last Updated**: August 2025
**Version**: Enhanced with Database Error Handling & New Features 