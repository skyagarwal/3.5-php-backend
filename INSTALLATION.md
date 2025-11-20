# Mangwale 3.5 - One-Click Docker Installation

## Prerequisites
- Docker & Docker Compose installed
- Git installed
- Minimum 4GB RAM, 20GB disk space

## Quick Start (One Command)

```bash
git clone git@github.com:skyagarwal/3.5-php-backend.git
cd 3.5-php-backend
./install.sh
```

The installation script will:
1. Copy `.env.example` to `.env` and configure it
2. Build and start Docker containers (PHP, Nginx, MySQL, Redis, phpMyAdmin)
3. Install PHP dependencies via Composer
4. Run database migrations
5. Build frontend assets
6. Set correct permissions
7. Cache configuration

## Manual Installation

If you prefer manual steps:

### 1. Clone and Setup
```bash
git clone git@github.com:skyagarwal/3.5-php-backend.git
cd 3.5-php-backend
cp .env.example .env
```

### 2. Configure Environment
Edit `.env` file with your settings:
```env
APP_NAME=Mangwale
APP_URL=http://localhost:8090
DB_HOST=mysql
DB_DATABASE=mangwale_db
DB_USERNAME=mangwale_user
DB_PASSWORD=admin123
```

### 3. Start Docker Containers
```bash
docker-compose up -d
```

### 4. Install Dependencies
```bash
docker exec mangwale_php composer install --no-dev --optimize-autoloader
```

### 5. Setup Database
```bash
docker exec mangwale_php php artisan key:generate
docker exec mangwale_php php artisan migrate --force
```

### 6. Build Assets
```bash
docker exec mangwale_php npm install
docker exec mangwale_php npm run prod
```

### 7. Set Permissions
```bash
docker exec mangwale_php chown -R www-data:www-data /var/www/html
docker exec mangwale_php find /var/www/html -type f -exec chmod 664 {} \;
docker exec mangwale_php find /var/www/html -type d -exec chmod 775 {} \;
docker exec mangwale_php chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
```

### 8. Cache Configuration
```bash
docker exec mangwale_php php artisan config:cache
docker exec mangwale_php php artisan route:cache
docker exec mangwale_php php artisan view:cache
```

## Access Points

After installation:

- **Main Application**: http://localhost:8090 or https://your-domain.com
- **phpMyAdmin**: http://localhost:8084
- **Admin Panel**: http://localhost:8090/admin
- **Vendor Panel**: http://localhost:8090/vendor

## Default Ports

- HTTP: 8090
- HTTPS: 8443
- MySQL: 23306
- Redis: 6380
- phpMyAdmin: 8084

## Troubleshooting

### Permission Issues
```bash
docker exec mangwale_php chmod -R 775 storage bootstrap/cache
docker exec mangwale_php chown -R www-data:www-data storage bootstrap/cache
```

### Clear Caches
```bash
docker exec mangwale_php php artisan cache:clear
docker exec mangwale_php php artisan config:clear
docker exec mangwale_php php artisan view:clear
```

### View Logs
```bash
docker logs mangwale_php
docker logs mangwale_nginx
docker exec mangwale_php tail -f storage/logs/laravel.log
```

### Database Connection Issues
```bash
docker exec mangwale_mysql mysql -umangwale_user -padmin123 -e "SHOW DATABASES;"
```

## Production Deployment

For production:
1. Change `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper domain in `APP_URL`
4. Use strong passwords for database
5. Setup SSL certificates (Traefik configuration included)
6. Run `php artisan optimize`

## Stack Information

- **PHP**: 8.3-FPM
- **Laravel**: 12.39.0
- **MySQL**: 8.0
- **Nginx**: Alpine
- **Redis**: Latest
- **Node**: For asset compilation

## Support

For issues or questions:
- Check logs in `storage/logs/`
- Review Docker container logs
- Ensure all containers are running: `docker-compose ps`
