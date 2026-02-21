# Installation Guide - Error-Free Setup

## Prerequisites Check
Before installation, ensure you have:
- PHP 8.2+ installed
- Composer installed
- Git installed

## Step-by-Step Installation

### 1. Clone Repository
```bash
git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git
cd carbonethics-backend-commerce-system
```

### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Environment Setup
```bash
# Copy environment template
cp .env.hrdsample .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Create SQLite database (if not exists)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 5. Verify Installation
```bash
# Check if server starts
php artisan serve --host=127.0.0.1 --port=8000

# Test API endpoint
curl http://127.0.0.1:8000/api/products
```

## Common Issues & Solutions

### Issue: "Database file not found"
**Solution**: Ensure database/database.sqlite exists and is writable

### Issue: "APP_KEY not set"
**Solution**: Run `php artisan key:generate`

### Issue: "Class not found"
**Solution**: Run `composer install --no-dev --optimize-autoloader`

### Issue: "Migration failed"
**Solution**: Run `php artisan migrate:fresh` instead of `php artisan migrate`

### Issue: "Port already in use"
**Solution**: Use different port: `php artisan serve --port=8001`

## Quick Installation Script
```bash
#!/bin/bash
git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git
cd carbonethics-backend-commerce-system
composer install --no-dev --optimize-autoloader
cp .env.hrdsample .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8000
```

## Windows PowerShell Installation Script
```powershell
git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git
cd carbonethics-backend-commerce-system
composer install --no-dev --optimize-autoloader
cp .env.hrdsample .env
php artisan key:generate
New-Item -Path "database/database.sqlite" -ItemType File -Force
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8000
```

## Verification Commands
```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check Laravel
php artisan --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo()
```

## Support
If you encounter any issues:
1. Check PHP version (8.2+ required)
2. Check Composer installation
3. Ensure database directory is writable
4. Check file permissions
5. Review error logs: `storage/logs/laravel.log`
