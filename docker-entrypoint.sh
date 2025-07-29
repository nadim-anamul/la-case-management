#!/bin/bash

echo "Starting Laravel application..."

# Run setup tasks
composer install --no-interaction --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
chmod -R 775 storage bootstrap/cache

echo "Setup complete. Starting server..."

# This line executes the CMD from the Dockerfile
exec "$@"