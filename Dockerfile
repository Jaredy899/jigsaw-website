# Multi-stage build: first build the site, then serve it
FROM php:8.1-cli-alpine AS builder

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    unzip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy dependency files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy source files
COPY . .

# Build the site using Jigsaw
RUN vendor/bin/jigsaw build production

# Final stage: serve with nginx
FROM nginx:alpine

# Copy built site from builder stage
COPY --from=builder /app/build_production/ /usr/share/nginx/html/

# Copy custom nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]