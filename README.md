# Laravel PDF Generator

A Laravel application for managing land acquisition compensation data and generating PDF reports.

## Features

- Compensation data management
- PDF generation
- Kanungo/Surveyor opinion management
- Responsive design with Tailwind CSS

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Build assets:
   ```bash
   npm run build
   ```

## Development

### Tailwind CSS Setup

This project uses Tailwind CSS v4 with Vite for asset compilation. The setup includes:

- **Tailwind CSS v4**: Latest version with improved performance
- **PostCSS**: For processing CSS
- **Vite**: For fast asset building
- **Alpine.js**: For interactive components

#### Development Commands

```bash
# Start development server with hot reload
npm run dev

# Build for production
npm run build

# Watch for changes and rebuild
npm run watch
```

#### Asset Structure

- **CSS**: `resources/css/app.css` - Main stylesheet with Tailwind directives
- **JS**: `resources/js/app.js` - Main JavaScript with Alpine.js
- **Config**: `tailwind.config.js` - Tailwind configuration
- **PostCSS**: `postcss.config.js` - PostCSS configuration

### Laravel Development

```bash
# Start Laravel development server
php artisan serve

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear
```

## Usage

1. Access the application at `http://localhost:8000`
2. Navigate to compensations to manage compensation data
3. Use the Kanungo opinion feature to add surveyor opinions
4. Generate PDF reports as needed

## Production Deployment

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Run `npm run build` to compile assets
3. Ensure all assets are properly served
4. Configure your web server to serve the application

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
