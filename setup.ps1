$ErrorActionPreference = "Stop"

Write-Host "`nSmall Business Management System - Setup" -ForegroundColor Cyan
Write-Host "========================================"

# Confirm that the script is running from the project directory.
if (!(Test-Path ".\artisan") -or !(Test-Path ".\.env.example")) {
    Write-Host "ERROR: Run this script from the project root folder." -ForegroundColor Red
    exit 1
}

# Check PHP.
if (!(Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "ERROR: PHP was not found. Ensure XAMPP is installed and PHP is on PATH." -ForegroundColor Red
    exit 1
}

# Create .env only if it does not already exist.
if (!(Test-Path ".\.env")) {
    Copy-Item ".\.env.example" ".\.env"
    Write-Host "Created .env from .env.example." -ForegroundColor Green
} else {
    Write-Host "Existing .env found; it will not be overwritten." -ForegroundColor Yellow
}

# Ensure the application key exists.
$envContent = Get-Content ".\.env" -Raw
if ($envContent -notmatch '(?m)^APP_KEY=.+$') {
    Write-Host "Generating application key..."
    php artisan key:generate
    if ($LASTEXITCODE -ne 0) {
        Write-Host "ERROR: Could not generate the application key." -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "Application key already exists; keeping it." -ForegroundColor Green
}

# Check Composer dependencies.
if (!(Test-Path ".\vendor\autoload.php")) {
    Write-Host "ERROR: Composer dependencies are missing. Run: composer install" -ForegroundColor Red
    exit 1
}

Write-Host "`nSetup checks completed." -ForegroundColor Green
Write-Host "Before using the system, ensure MySQL is running and the database"
Write-Host "'small_business_management' has been created and database\submission.sql imported."
Write-Host "`nStarting Laravel at http://127.0.0.1:8000 ..." -ForegroundColor Cyan

php artisan serve --host=127.0.0.1 --port=8000
