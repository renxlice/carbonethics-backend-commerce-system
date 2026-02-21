#!/bin/bash

# CarbonEthics E-Commerce API - Setup Script
# This script ensures error-free installation

echo "🚀 Starting CarbonEthics E-Commerce API Setup..."

# Check prerequisites
echo "📋 Checking prerequisites..."
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.2+"
    exit 1
fi

if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer"
    exit 1
fi

if ! command -v git &> /dev/null; then
    echo "❌ Git is not installed. Please install Git"
    exit 1
fi

echo "✅ All prerequisites found!"

# Clone repository if not in project directory
if [ ! -f "composer.json" ]; then
    echo "📥 Cloning repository..."
    git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git .
    if [ $? -ne 0 ]; then
        echo "❌ Failed to clone repository"
        exit 1
    fi
fi

echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader
if [ $? -ne 0 ]; then
    echo "❌ Failed to install dependencies"
    exit 1
fi

echo "🔧 Setting up environment..."
if [ ! -f ".env" ]; then
    cp .env.hrdsample .env
    if [ $? -ne 0 ]; then
        echo "❌ Failed to copy environment file"
        exit 1
    fi
fi

echo "🔑 Generating application key..."
php artisan key:generate --force
if [ $? -ne 0 ]; then
    echo "❌ Failed to generate application key"
    exit 1
fi

echo "🗄️ Setting up database..."
# Database file is created automatically by AppServiceProvider
php artisan migrate:fresh --seed
if [ $? -ne 0 ]; then
    echo "❌ Failed to setup database"
    exit 1
fi

echo "🧪 Running tests..."
php artisan test
if [ $? -ne 0 ]; then
    echo "❌ Tests failed"
    exit 1
fi

echo "🎉 Setup completed successfully!"
echo "🌐 Starting development server..."
echo "📡 API will be available at: http://127.0.0.1:8000"
echo "📚 API Documentation: http://127.0.0.1:8000/api/products"
echo "⏹ Press Ctrl+C to stop the server"

php artisan serve --host=127.0.0.1 --port=8000
