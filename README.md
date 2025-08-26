# Laravel PDF Generator - Project Architecture & Code Guide

A comprehensive Laravel application for generating compensation forms and PDF documents with Bengali language support and advanced form management capabilities.

## 🏗️ Project Architecture

### Technology Stack
- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (development) / MySQL/PostgreSQL (production)
- **PDF Generation**: Spatie Browsershot (Chrome/Chromium-based)
- **Testing**: PHPUnit with Laravel testing helpers
- **Build Tools**: Vite for asset compilation

### Application Structure

```
pdf-generate/
├── app/                          # Core application logic
│   ├── Http/Controllers/        # HTTP request handlers
│   ├── Models/                  # Eloquent ORM models
│   ├── Services/                # Business logic services
│   ├── Traits/                  # Reusable trait classes
│   └── Providers/               # Service providers
├── resources/views/              # Blade template files
│   ├── admin/                   # Admin interface views
│   ├── compensation/            # Compensation form views
│   ├── pdf/                     # PDF template views
│   └── components/              # Reusable UI components
├── database/                     # Database structure & data
│   ├── migrations/              # Database schema migrations
│   ├── seeders/                 # Sample data generators
│   └── factories/               # Model factories for testing
├── routes/                       # Application routing
├── tests/                        # Test suite
└── storage/                      # File storage & logs
```

## 🔧 Core Components

### 1. Models & Data Layer

#### Compensation Model (`app/Models/Compensation.php`)
The central model representing compensation cases with:
- **Core Fields**: Case details, plot information, applicant data
- **JSON Fields**: Complex nested data structures for ownership, tax info, etc.
- **Relationships**: User associations, audit trails
- **Custom Methods**: Bengali date formatting, application area formatting

```php
// Example of JSON field usage
protected $casts = [
    'ownership_details' => 'array',
    'tax_info' => 'array',
    'kanungo_opinion' => 'array',
];

// Custom method for Bengali date conversion
public function getCaseDateBengaliAttribute()
{
    return $this->convertToBengaliDate($this->case_date);
}
```

#### User Model (`app/Models/User.php`)
Extended user model with role-based access control:
- **Roles**: Regular user, super user, admin
- **Status Management**: Approval workflow for new registrations
- **Audit Trail**: Creation, update, and deletion tracking

### 2. Services Layer

#### PDF Generator Service (`app/Services/PdfGeneratorService.php`)
Handles PDF generation using Chrome/Chromium:
- **HTML to PDF**: Convert Blade templates to PDF documents
- **URL to PDF**: Generate PDFs from web pages
- **Chrome Management**: Automatic Chrome executable detection
- **Customization**: Margins, format, timeout, and rendering options

```php
// Generate PDF from HTML content
public static function generateFromHtml(string $html, array $options = []): string
{
    $browsershot = Browsershot::html($html)
        ->noSandbox()
        ->format($options['format'] ?? 'A4')
        ->addChromiumArguments([
            '--font-render-hinting=none',
            '--disable-gpu-sandbox'
        ]);
    
    return $browsershot->pdf();
}
```

### 3. Traits & Utilities

#### Bengali Date Trait (`app/Traits/BengaliDateTrait.php`)
Provides Bengali language support:
- **Date Conversion**: English to Bengali date format (dd/mm/yyyy)
- **Numeral Conversion**: English to Bengali digits (0-9 → ০-৯)
- **Amount Formatting**: Currency formatting with Bengali numerals
- **Word Conversion**: Number to Bengali words (for amounts)

```php
// Convert English date to Bengali format
$bengaliDate = $compensation->getCaseDateBengaliAttribute();

// Convert numbers to Bengali digits
$bengaliAmount = $compensation->bnDigits(1234.56);

// Format currency amounts
$formattedAmount = $compensation->formatAmountBangla(287734.59);
```

### 4. Controllers & Request Handling

#### Compensation Controller (`app/Http/Controllers/CompensationController.php`)
Main controller handling compensation workflow:
- **CRUD Operations**: Create, read, update, delete compensation cases
- **PDF Generation**: Multiple PDF types (preview, notice, analysis, final order)
- **Workflow Management**: Multi-step compensation process
- **File Export**: PDF and Excel generation

#### User Management Controller (`app/Http/Controllers/UserManagementController.php`)
Admin functionality for user administration:
- **User Approval**: Approve/reject new user registrations
- **Role Management**: Assign/remove super user privileges
- **Account Control**: Password resets, account management

### 5. Views & Templates

#### Blade Template Structure
- **Layouts**: Base templates with navigation and common elements
- **Components**: Reusable UI components (forms, tables, modals)
- **PDF Templates**: Specialized views optimized for PDF generation
- **Admin Interface**: User management and system administration

#### Key View Categories
```
resources/views/
├── layouts/           # Base page layouts
├── compensation/      # Compensation form views
├── pdf/              # PDF-specific templates
├── admin/            # Administrative interfaces
├── auth/             # Authentication forms
└── components/       # Reusable UI components
```

## 🗄️ Database Architecture

### Core Tables

#### `compensations` Table
Main compensation case storage with JSON fields for complex data:
- **Basic Info**: Case number, dates, plot information
- **JSON Fields**: Ownership details, tax information, documents
- **Workflow**: Status tracking, approval stages
- **Audit**: Creation, modification, deletion tracking

#### `users` Table
Extended user management:
- **Authentication**: Email, password, remember token
- **Roles**: User type and approval status
- **Timestamps**: Creation and modification tracking

### JSON Field Structure

#### Ownership Details Example
```json
{
  "deed_transfers": [
    {
      "application_type": "specific",
      "application_specific_area": "PLOT-005",
      "application_sell_area": "2"
    }
  ]
}
```

#### Tax Information Example
```json
{
  "tax_percentage": "15",
  "tax_amount": "15000",
  "tax_year": "2024"
}
```

## 🚀 Development Workflow

### 1. Environment Setup
```bash
# Clone repository
git clone <repository-url>
cd pdf-generate

# Install dependencies
composer install
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed
```

### 2. Development Commands
```bash
# Start development server
php artisan serve

# Run tests
php artisan test

# Asset compilation
npm run dev

# Database operations
php artisan migrate:fresh --seed
php artisan make:migration create_new_table
php artisan make:controller NewController
```

### 3. Testing Strategy
- **Feature Tests**: End-to-end functionality testing
- **Unit Tests**: Individual component testing
- **Database Tests**: Data integrity and migration testing
- **PDF Tests**: Document generation validation

## 📋 Code Standards & Best Practices

### 1. Laravel Conventions
- Follow PSR-4 autoloading standards
- Use Laravel naming conventions for routes, controllers, models
- Implement proper validation and error handling
- Use Eloquent relationships and model events

### 2. Code Organization
- **Single Responsibility**: Each class should have one clear purpose
- **Dependency Injection**: Use Laravel's service container
- **Service Layer**: Business logic in dedicated service classes
- **Trait Usage**: Share common functionality across models

### 3. Database Design
- **JSON Fields**: Use for flexible, schema-less data
- **Indexing**: Proper indexes on frequently queried fields
- **Migrations**: Version-controlled database schema changes
- **Seeders**: Consistent test data generation

### 4. Security Considerations
- **Authentication**: Laravel's built-in auth system
- **Authorization**: Role-based access control
- **Input Validation**: Comprehensive form validation
- **CSRF Protection**: Built-in CSRF token handling

## 🔍 Key Features

### 1. Compensation Management
- Multi-step form workflow
- Dynamic form validation
- PDF generation for all stages
- Bengali language support
- Ownership continuity tracking

### 2. PDF Generation
- Chrome/Chromium-based rendering
- Customizable templates
- Multiple output formats
- Font and styling control
- Background and layout options

### 3. User Administration
- Role-based access control
- User approval workflow
- Password management
- Account status tracking

### 4. Data Export
- PDF generation for various documents
- Excel export capabilities
- Data analysis tools
- Report generation

## 🚀 Deployment

### Docker Support
- `Dockerfile` for containerized deployment
- `docker-compose.yml` for local development
- `docker-compose.server.yml` for production deployment

### Production Considerations
- Environment-specific configurations
- Database optimization
- PDF generation performance
- Security hardening
- Monitoring and logging

## 📚 Additional Resources

- **Bengali Font Setup**: See `BENGALI_FONT_SETUP.md`
- **PDF Generation Guide**: See `PDF_GENERATION_GUIDE.md`
- **Security Guidelines**: See `SECURITY.md`
- **Deployment Scripts**: See `deploy.sh`, `deploy-production.sh`

## 🤝 Contributing

1. Follow the established code structure and conventions
2. Write comprehensive tests for new features
3. Update documentation for API changes
4. Use meaningful commit messages
5. Test PDF generation across different environments

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

*For detailed setup instructions and troubleshooting, refer to the individual documentation files in the project root.*
