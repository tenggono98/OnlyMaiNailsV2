#!/bin/bash

# Exit on any error
set -e

# Wait for database to be ready (if using external database)
echo "Waiting for database connection..."
php artisan migrate --force

# Clear and cache configuration
echo "Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Re-cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Laravel Octane server
echo "Starting Laravel Octane server..."
php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000 --workers=4 --task-workers=2
