# Multi-stage build for Laravel application
FROM php:8.2-fpm-alpine AS base

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

# Copy composer files
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

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy nginx configuration
COPY .deploy/config/nginx.conf /etc/nginx/http.d/default.conf

# Set environment variables
ENV LARAVEL_PATH=/var/www/html

# Build arguments for environment variables
ARG DB_DATABASE=${DB_DATABASE}
ARG DB_USERNAME=${DB_USERNAME}
ARG DB_PASSWORD=${DB_PASSWORD}

ARG BROADCAST_DRIVER=${BROADCAST_DRIVER}
ARG CACHE_DRIVER=${CACHE_DRIVER}
ARG QUEUE_CONNECTION=${QUEUE_CONNECTION}
ARG SESSION_DRIVER=${SESSION_DRIVER}
ARG SESSION_LIFETIME=${SESSION_LIFETIME}

ARG REDIS_HOST=${REDIS_HOST}
ARG REDIS_PASSWORD=${REDIS_PASSWORD}
ARG REDIS_PORT=${REDIS_PORT}

ARG MAIL_MAILER=${MAIL_MAILER}
ARG MAIL_HOST=${MAIL_HOST}
ARG MAIL_PORT=${MAIL_PORT}
ARG MAIL_USERNAME=${MAIL_USERNAME}
ARG MAIL_PASSWORD=${MAIL_PASSWORD}
ARG MAIL_ENCRYPTION=${MAIL_ENCRYPTION}
ARG MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}
ARG MAIL_FROM_NAME=${APP_NAME}

ARG PUSHER_APP_ID=${PUSHER_APP_ID}
ARG PUSHER_APP_KEY=${PUSHER_APP_KEY}
ARG PUSHER_APP_SECRET=${PUSHER_APP_SECRET}
ARG PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}

ARG LINODE_KEY=${PUSHER_APP_ID}
ARG LINODE_SECRET=${LINODE_SECRET}
ARG LINODE_ENDPOINT=${LINODE_ENDPOINT}
ARG LINODE_REGION=${LINODE_REGION}
ARG LINODE_BUCKET=${LINODE_BUCKET}
ARG BEAMS_ID=${BEAMS_ID}
ARG WK_NOTIF_TIME_TO_SEND_MIN=${WK_NOTIF_TIME_TO_SEND_MIN}
ARG FIREBASE_CREDENTIALS=${FIREBASE_CREDENTIALS}

ARG VITE_APP_NAME=${APP_NAME}
ARG VITE_PUSHER_APP_KEY=${PUSHER_APP_KEY}
ARG VITE_PUSHER_HOST=${PUSHER_HOST}
ARG VITE_PUSHER_PORT=${PUSHER_PORT}
ARG VITE_PUSHER_SCHEME=${PUSHER_SCHEME}
ARG VITE_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}
ARG OPENAI_API_KEY=${OPENAI_API_KEY}
ARG OPENAI_REQUEST_TIMEOUT=${OPENAI_REQUEST_TIMEOUT}
ARG OPENAI_MODEL=${OPENAI_MODEL}
ARG OPENAI_MESSAGE=${OPENAI_MESSAGE}
ARG CLOUDFLARE_TOKEN=${CLOUDFLARE_TOKEN}
ARG CLOUDFLARE_ZONE_ID=${CLOUDFLARE_ZONE_ID}
ARG ASSETS_URL=${ASSETS_URL}

# Make entrypoint executable (file is already copied with COPY . .)
RUN chmod +x .deploy/entrypoint.sh

# Expose port
EXPOSE 80


# Start app
EXPOSE 80
COPY ../.deploy/entrypoint.sh /

ENTRYPOINT ["sh",  "/entrypoint.sh"]
