#!/bin/bash

set -e

echo "🚀 Starting Laravel application with Nixpacks..."

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Create storage link if it doesn't exist
echo "📁 Creating storage link..."
php artisan storage:link || echo "⚠️  Storage link already exists"

# Clear and cache config
echo "🧹 Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if needed (uncomment if you want automatic migrations)
# echo "🗄️  Running migrations..."
# php artisan migrate --force

echo "🎬 Starting Laravel server..."

# Start the Laravel development server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}