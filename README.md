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

## 🚀 Setup Options

### Option 1: Docker Setup (Recommended)

#### Prerequisites
- Docker
- Docker Compose
- Git

#### Quick Start with Docker

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
   - **Database**: localhost:3306
   - **Redis**: localhost:6379

### Option 2: Local Setup

#### Prerequisites
- PHP 8.1+
- Composer
- Node.js
- MySQL
- Git

#### Quick Start with Local Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-pdf-generator
   ```

2. **Run the automated setup**
   ```bash
   ./local-setup.sh
   ```

3. **Start the development server**
   ```bash
   php artisan serve
   ```

4. **Access the application**
   - **Web Application**: http://localhost:8000

### Option 3: Production Deployment

#### Prerequisites
- Docker
- Docker Compose
- SSL Certificate
- Domain Name
- Strong Passwords

#### Production Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-pdf-generator
   ```

2. **Configure production environment**
   ```bash
   # Copy and edit production environment
   cp .env.production .env
   # Edit .env with your production settings
   ```

3. **Set up SSL certificates**
   ```bash
   # Create SSL directory
   mkdir -p docker/nginx/ssl
   # Add your SSL certificates
   # cert.pem and key.pem
   ```

4. **Run production setup**
   ```bash
   ./production-setup.sh
   ```

5. **Access the application**
   - **Web Application**: https://yourdomain.com

#### Production Updates
```bash
# Update application with zero downtime
./production-update.sh
```

4. **Build and start containers**
   ```bash
   docker compose up -d --build
   ```

5. **Install dependencies**
   ```bash
   docker compose exec app composer install
   docker compose exec app npm install
   ```

6. **Generate application key**
   ```bash
   docker compose exec app php artisan key:generate
   ```

7. **Run migrations and seeders**
   ```bash
   docker compose exec app php artisan migrate --seed
   ```

8. **Create storage link**
   ```bash
   docker compose exec app php artisan storage:link
   ```

9. **Set proper permissions**
   ```bash
   docker compose exec app chmod -R 775 storage bootstrap/cache
   ```

### Access the Application

- **Web Application**: http://localhost:8000
- **Database**: localhost:3306
- **Redis**: localhost:6379

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

# Remove all containers and volumes
docker compose down -v
```

## 📊 Getting Started with Existing Data

### Option 1: Using Docker with Pre-seeded Data

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

### Option 2: Import Your Own Data

1. **Prepare your data** in the correct format
2. **Create a custom seeder** or modify `DatabaseSeeder.php`
3. **Run the seeder**:
   ```bash
   docker compose exec app php artisan db:seed --class=YourCustomSeeder
   ```

### Option 3: Database Dump Import

1. **Place your SQL dump** in the project root
2. **Import the dump**:
   ```bash
   docker compose exec -T db mysql -u your_mysql_user -p your_mysql_password laravel_pdf_generator < your_dump.sql
   ```

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
├── docker/
│   ├── nginx/
│   ├── php/
│   └── mysql/
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
DB_DATABASE=laravel_pdf_generator
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_mysql_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Database Configuration

The application uses MySQL 8.0 with the following default settings:
- **Database**: laravel_pdf_generator
- **User**: your_mysql_user
- **Password**: your_mysql_password
- **Root Password**: your_mysql_root_password

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

- Redis caching for sessions and cache
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
   docker compose exec app composer install --no-dev
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

# Nginx logs
docker compose logs webserver

# MySQL logs
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
