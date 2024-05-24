cp .env.example .env
composer install
php artisan migrate
php artisan key:generate
