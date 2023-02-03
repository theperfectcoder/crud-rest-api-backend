# Pull the latest changes from the git repository
git reset --hard
git clean -df
git pull origin main

# Install/update composer dependencies
composer install

# Run database migrations
php artisan migrate

# Run database migrations
php artisan key:generate

# Clear caches
php artisan cache:clear

# Publish auto docs vendor
php artisan vendor:publish --tag=request-docs-config

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# Run server
php artisan serve

