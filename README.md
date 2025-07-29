# Laravel PDF Generator - Compensation Management System

A comprehensive Laravel-based compensation management system for land acquisition cases, featuring dynamic form handling, PDF generation capabilities, and step-by-step ownership continuity tracking.

## 🚀 Features

- **Dynamic Form Management**: Multi-step compensation forms with Alpine.js
- **Ownership Continuity Tracking**: Step-by-step ownership transfer documentation
- **PDF Generation**: Generate comprehensive compensation reports
- **Data Persistence**: Robust data saving and retrieval system
- **Responsive Design**: Modern UI with Tailwind CSS
- **Validation**: Comprehensive form validation with error handling
- **Preview System**: Section-wise data preview functionality
- **Demo Data**: Pre-populated with 4 comprehensive compensation records

## 🐳 Simple Docker Setup

### Prerequisites

- Docker
- Docker Compose
- Git

### Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-pdf-generator
   ```

2. **Run the automated setup**
   ```bash
   ./docker-setup.sh
   ```

3. **Access the application**
   - **Web Application**: http://localhost:8000
   - **Compensation List**: http://localhost:8000/compensations
   - **Database**: localhost:3307

### Demo Data Included

The setup automatically populates the database with 4 comprehensive compensation records:

- **CASE-2024-001**: SA-based case with multiple applicants
- **CASE-2024-002**: RS-based case with inheritance records
- **CASE-2024-003**: Complex SA case with multiple transfers
- **CASE-2024-004**: Mixed case with deed and inheritance

Each record includes complete form data for testing all features.

### Quick Commands

```bash
# Start the application (if already set up)
./start.sh

# Fresh setup with demo data
./docker-setup.sh

# Stop the application
docker compose down

# View logs
docker compose logs -f
```

## 🔧 Troubleshooting

### Server Deployment Issues

If you encounter issues like "Failed to open stream: No such file or directory" for vendor/autoload.php:

1. **Use the fix script:**
   ```bash
   ./fix-server-issues.sh
   ```

2. **Manual fix:**
   ```bash
   # Stop containers
   docker compose down
   
   # Remove images and rebuild
   docker rmi $(docker images -q pdf-generate-app) 2>/dev/null || true
   docker compose build --no-cache
   
   # Start and install dependencies
   docker compose up -d
   docker compose exec app composer install --no-interaction --optimize-autoloader
   docker compose exec app npm install
   docker compose exec app npm run build
   
   # Setup Laravel
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate:fresh --seed
   ```

### Common Issues

- **Container restarting**: Usually indicates missing dependencies
- **Database connection errors**: Check if MySQL container is running
- **Permission errors**: Run `docker compose exec app chmod -R 775 storage bootstrap/cache`

### Manual Setup

If the automated script doesn't work:

1. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

2. **Build and start containers**
   ```bash
   docker compose up -d --build
   ```

3. **Wait for database and run setup**
   ```bash
   # Wait for database to be ready
   sleep 15
   
   # Clear cached configurations
   docker compose exec app php artisan config:clear
   docker compose exec app php artisan cache:clear
   
   # Generate application key
   docker compose exec app php artisan key:generate
   
   # Run migrations and seeders with demo data
   docker compose exec app php artisan migrate:fresh --seed
   
   # Create storage link
   docker compose exec app php artisan storage:link
   
   # Set permissions
   docker compose exec app chmod -R 775 storage bootstrap/cache
   ```

### Docker Commands

```bash
# Start services
docker compose up -d

# Stop services
docker compose down

# View logs
docker compose logs -f

# Execute commands in container
docker compose exec app php artisan migrate
docker compose exec app composer install
docker compose exec app npm run dev

# Rebuild containers
docker compose up -d --build
```

### Database Access

- **Host**: localhost
- **Port**: 3307 (changed from 3306 to avoid conflicts)
- **Database**: laravel
- **Username**: laravel
- **Password**: password

## 📊 Getting Started with Existing Data

The application comes with demo data that will be automatically loaded when you run the seeders:

```bash
# After setting up Docker, run:
docker compose exec app php artisan db:seed
```

This will create 4 demo compensation records with comprehensive data including:
- SA/RS record information
- Ownership continuity details
- Deed transfers and inheritance records
- Applicant information
- Tax and document details

## 🏗️ Project Structure

```
laravel-pdf-generator/
├── app/
│   ├── Http/Controllers/
│   │   └── CompensationController.php
│   └── Models/
│       └── Compensation.php
├── resources/views/
│   ├── components/compensation/
│   │   ├── ownership-continuity-section-new.blade.php
│   │   ├── applicant-section.blade.php
│   │   └── ...
│   └── compensation_form.blade.php
├── database/
│   ├── migrations/
│   └── seeders/
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## 🔧 Configuration

### Environment Variables

Key environment variables for Docker deployment:

```env
APP_NAME="Laravel PDF Generator"
APP_ENV=local
APP_KEY=base64:your-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### Database Configuration

The application uses MySQL 8.0 with the following default settings:
- **Database**: laravel
- **User**: laravel
- **Password**: password
- **Root Password**: root_password

## 🧪 Testing

Run tests with Docker:

```bash
# Run all tests
docker compose exec app php artisan test

# Run specific test
docker compose exec app php artisan test --filter="Compensation"

# Run with coverage
docker compose exec app php artisan test --coverage
```

## 📝 Development

### Adding New Features

1. **Create migrations** for database changes
2. **Update models** with new relationships
3. **Modify controllers** for new functionality
4. **Update views** with new UI components
5. **Write tests** for new features

### Code Style

The project follows Laravel coding standards:
- PSR-12 coding style
- Laravel naming conventions
- Proper documentation

## 🔒 Security

- CSRF protection enabled
- Input validation on all forms
- SQL injection prevention
- XSS protection headers
- Secure file upload handling

## 📈 Performance

- File-based caching for sessions and cache
- Database query optimization
- Asset compilation with Vite
- Gzip compression enabled

## 🐛 Troubleshooting

### Common Issues

1. **Permission Denied**
   ```bash
   docker compose exec app chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Failed**
   - Check if MySQL container is running
   - Verify environment variables
   - Ensure database credentials are correct

3. **Composer Dependencies**
   ```bash
   docker compose exec app composer install
   ```

4. **NPM Dependencies**
   ```bash
   docker compose exec app npm install
   docker compose exec app npm run build
   ```

### Logs

View application logs:
```bash
# Laravel logs
docker compose exec app tail -f storage/logs/laravel.log

# Container logs
docker compose logs app
docker compose logs db
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write tests for new features
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 📞 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

---

**Note**: This application is designed for compensation management in land acquisition cases. Ensure proper data handling and compliance with local regulations when using in production environments.
