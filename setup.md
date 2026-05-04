## Setup Instructions

1. Clone the repo:
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git
cd YOUR_REPO

2. Install dependencies:
composer install
npm install

3. Copy environment file:
cp .env.example .env

4. Update .env with shared database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

5. Generate app key:
php artisan key:generate

6. Run migrations (only first time):
php artisan migrate

7. Start server:
php artisan serve