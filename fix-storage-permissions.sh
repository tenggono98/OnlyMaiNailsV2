#!/bin/bash

echo "🔧 Fixing storage permissions and setup..."

# Create storage directories if they don't exist
mkdir -p storage/app/public/homepage-images
mkdir -p storage/app/public/products
mkdir -p storage/app/public/shop/variants
mkdir -p storage/app/public/thumbnails
mkdir -p storage/app/public/banners
mkdir -p storage/app/public/images

# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Create storage link
php artisan storage:link

# Clear and cache config
php artisan config:clear
php artisan config:cache

echo "✅ Storage permissions fixed!"
echo "📁 Storage directories created:"
echo "   - storage/app/public/homepage-images"
echo "   - storage/app/public/products"
echo "   - storage/app/public/shop/variants"
echo "   - storage/app/public/thumbnails"
echo "   - storage/app/public/banners"
echo "   - storage/app/public/images"
