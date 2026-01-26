#!/bin/bash

# Jigsaw Website Docker Deployment Script

echo "🚀 Deploying Jigsaw Website with Docker..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker first."
    exit 1
fi

# Build the site if build_production doesn't exist or is empty
if [ ! -d "build_production" ] || [ ! "$(ls -A build_production)" ]; then
    echo "📦 Building Jigsaw site..."

    # Check if dependencies are installed
    if [ ! -d "vendor" ]; then
        echo "Installing PHP dependencies..."
        composer install --no-dev --optimize-autoloader
    fi

    # Build the site
    vendor/bin/jigsaw build production
fi

# Start the Docker container
echo "🐳 Starting Docker container..."
docker compose up -d --build

# Check if container is running
if docker compose ps | grep -q "Up"; then
    echo "✅ Website deployed successfully!"
    echo "🌐 Access your site at: http://localhost:8081"
else
    echo "❌ Failed to start container. Check logs with: docker compose logs"
    exit 1
fi