@echo off
echo Installing dependencies...
composer install

echo Copying .env file...
copy .env.example .env

echo Generating application key...
php artisan key:generate

php artisan migrate

echo Starting Laravel server...
php artisan serve



