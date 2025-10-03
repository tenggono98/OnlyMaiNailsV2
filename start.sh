#!/bin/bash

set -e

echo "🚀 Starting Laravel application with Nixpacks..."

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Create storage directories and set permissions
echo "📁 Setting up storage directories..."
mkdir -p storage/app/public/homepage-images
mkdir -p storage/app/public/products
mkdir -p storage/app/public/shop/variants
mkdir -p storage/app/public/thumbnails
mkdir -p storage/app/public/banners
mkdir -p storage/app/public/images

# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Create storage link if it doesn't exist
echo "📁 Creating storage link..."
php artisan storage:link || echo "⚠️  Storage link already exists"

# Clear and cache config
echo "🧹 Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# NPM Run Build
echo "🔨 Building application..."
npm run build

# Run migrations if needed (uncomment if you want automatic migrations)
# echo "🗄️  Running migrations..."
# php artisan migrate --force

echo "🎬 Starting Laravel server..."

# Start the Laravel development server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}