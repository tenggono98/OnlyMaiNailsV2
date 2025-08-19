# Multi-stage build for Laravel application
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    nodejs \
    npm \
    supervisor \
    nginx

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    xml \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy package.json and install Node dependencies
COPY package*.json ./
RUN npm ci --only=production

# Copy application code
COPY . .

# Build assets
RUN npm run build

# Copy configuration files
COPY .deploy/config/nginx.conf /etc/nginx/http.d/default.conf
COPY .deploy/config/supervisor.conf /etc/supervisor/conf.d/supervisord.conf
COPY .deploy/entrypoint.sh /entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod +x /entrypoint.sh

# Set environment variables
ENV LARAVEL_PATH=/var/www/html

# Build arguments for environment variables (properly declared without expansion)
ARG APP_NAME=Laravel
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG BROADCAST_DRIVER
ARG CACHE_DRIVER
ARG QUEUE_CONNECTION
ARG SESSION_DRIVER
ARG SESSION_LIFETIME
ARG REDIS_HOST
ARG REDIS_PASSWORD
ARG REDIS_PORT
ARG MAIL_MAILER
ARG MAIL_HOST
ARG MAIL_PORT
ARG MAIL_USERNAME
ARG MAIL_PASSWORD
ARG MAIL_ENCRYPTION
ARG MAIL_FROM_ADDRESS
ARG MAIL_FROM_NAME
ARG PUSHER_APP_ID
ARG PUSHER_APP_KEY
ARG PUSHER_APP_SECRET
ARG PUSHER_APP_CLUSTER
ARG LINODE_KEY
ARG LINODE_SECRET
ARG LINODE_ENDPOINT
ARG LINODE_REGION
ARG LINODE_BUCKET
ARG BEAMS_ID
ARG WK_NOTIF_TIME_TO_SEND_MIN
ARG FIREBASE_CREDENTIALS
ARG VITE_APP_NAME
ARG VITE_PUSHER_APP_KEY
ARG VITE_PUSHER_HOST
ARG VITE_PUSHER_PORT
ARG VITE_PUSHER_SCHEME
ARG VITE_PUSHER_APP_CLUSTER
ARG OPENAI_API_KEY
ARG OPENAI_REQUEST_TIMEOUT
ARG OPENAI_MODEL
ARG OPENAI_MESSAGE
ARG CLOUDFLARE_TOKEN
ARG CLOUDFLARE_ZONE_ID
ARG ASSETS_URL

# Create necessary directories
RUN mkdir -p /var/log \
    && mkdir -p /var/www/html/storage/logs

# Expose port
EXPOSE 80

# Use the entrypoint script
ENTRYPOINT ["sh", "/entrypoint.sh"]
