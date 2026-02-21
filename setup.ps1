# CarbonEthics E-Commerce API - PowerShell Setup Script
# This script ensures error-free installation on Windows

Write-Host "🚀 Starting CarbonEthics E-Commerce API Setup..." -ForegroundColor Green

# Check prerequisites
Write-Host "📋 Checking prerequisites..." -ForegroundColor Yellow

try {
    $phpVersion = php --version 2>$null
    if ($LASTEXITCODE -ne 0) {
        throw "PHP is not installed. Please install PHP 8.2+"
    }
    Write-Host "✅ PHP found: $phpVersion" -ForegroundColor Green
    
    $composerVersion = composer --version 2>$null
    if ($LASTEXITCODE -ne 0) {
        throw "Composer is not installed. Please install Composer"
    }
    Write-Host "✅ Composer found: $composerVersion" -ForegroundColor Green
    
    $gitVersion = git --version 2>$null
    if ($LASTEXITCODE -ne 0) {
        throw "Git is not installed. Please install Git"
    }
    Write-Host "✅ Git found: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Prerequisites check failed: $_" -ForegroundColor Red
    exit 1
}

# Clone repository if not in project directory
if (-not (Test-Path "composer.json")) {
    Write-Host "📥 Cloning repository..." -ForegroundColor Yellow
    git clone https://github.com/renxlice/carbonethics-backend-commerce-system.git .
    if ($LASTEXITCODE -ne 0) {
        Write-Host "❌ Failed to clone repository" -ForegroundColor Red
        exit 1
    }
}

# Install dependencies
Write-Host "📦 Installing dependencies..." -ForegroundColor Yellow
composer install --no-dev --optimize-autoloader
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to install dependencies" -ForegroundColor Red
    exit 1
}

# Setup environment
Write-Host "🔧 Setting up environment..." -ForegroundColor Yellow
if (-not (Test-Path ".env")) {
    Copy-Item ".env.hrdsample" ".env"
    if ($LASTEXITCODE -ne 0) {
        Write-Host "❌ Failed to copy environment file" -ForegroundColor Red
        exit 1
    }
}

# Generate application key
Write-Host "🔑 Generating application key..." -ForegroundColor Yellow
php artisan key:generate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to generate application key" -ForegroundColor Red
    exit 1
}

# Setup database
Write-Host "🗄️ Setting up database..." -ForegroundColor Yellow
# Database file is created automatically by AppServiceProvider
php artisan migrate:fresh --seed
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Failed to setup database" -ForegroundColor Red
    exit 1
}

# Run tests
Write-Host "🧪 Running tests..." -ForegroundColor Yellow
php artisan test
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Tests failed" -ForegroundColor Red
    exit 1
}

Write-Host "🎉 Setup completed successfully!" -ForegroundColor Green
Write-Host "🌐 Starting development server..." -ForegroundColor Green
Write-Host "📡 API will be available at: http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host "📚 API Documentation: http://127.0.0.1:8000/api/products" -ForegroundColor Cyan
Write-Host "⏹ Press Ctrl+C to stop the server" -ForegroundColor Yellow

php artisan serve --host=127.0.0.1 --port=8000
