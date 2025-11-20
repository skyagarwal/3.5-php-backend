# Production Deployment Guide - PHP Mangwale Backend

## Table of Contents
1. [Overview](#overview)
2. [System Requirements](#system-requirements)
3. [Pre-Deployment Checklist](#pre-deployment-checklist)
4. [Server Setup](#server-setup)
5. [Docker Deployment](#docker-deployment)
6. [Manual Deployment (Non-Docker)](#manual-deployment-non-docker)
7. [Configuration](#configuration)
8. [Database Setup](#database-setup)
9. [Permissions & Security](#permissions--security)
10. [Cron Jobs Setup](#cron-jobs-setup)
11. [Queue Workers](#queue-workers)
12. [WebSockets Setup](#websockets-setup)
13. [SSL/HTTPS Configuration](#sslhttps-configuration)
14. [Post-Deployment](#post-deployment)
15. [Monitoring & Maintenance](#monitoring--maintenance)
16. [Troubleshooting](#troubleshooting)

---

## Overview

This is a Laravel 10 PHP backend application for the Mangwale platform. The application supports:
- Multi-module architecture (Food, Grocery, Pharmacy, E-commerce, Parcel)
- OAuth authentication via Laravel Passport
- Real-time WebSockets
- Multiple payment gateways
- Firebase push notifications
- File storage (Local/S3)
- Automated disbursement system
- Queue-based job processing

**Current Deployment Method**: Docker Compose with Traefik reverse proxy

---

## System Requirements

### Minimum Server Specifications
- **CPU**: 2 cores
- **RAM**: 4GB (8GB recommended for production)
- **Storage**: 20GB SSD (50GB+ recommended)
- **OS**: Ubuntu 20.04 LTS or higher / Debian 11+ / CentOS 8+

### Software Requirements
- **Docker**: 20.10+
- **Docker Compose**: 1.29+
- **PHP**: 8.2+ (if manual deployment)
- **MySQL**: 8.0+
- **Redis**: 7.0+
- **Nginx**: 1.18+ (if manual deployment)
- **Composer**: 2.0+
- **Node.js**: 16+ (for asset compilation)

### PHP Extensions Required
- php8.2-fpm
- php8.2-mysql
- php8.2-mbstring
- php8.2-xml
- php8.2-bcmath
- php8.2-curl
- php8.2-zip
- php8.2-gd
- php8.2-opcache
- php8.2-redis
- php8.2-pcntl
- php8.2-exif
- php8.2-fileinfo
- php8.2-sodium
- php8.2-tokenizer
- php8.2-ctype
- php8.2-json
- php8.2-openssl

---

## Pre-Deployment Checklist

- [ ] Server access (SSH)
- [ ] Domain name configured
- [ ] DNS records pointing to server IP
- [ ] Firewall rules configured
- [ ] SSL certificate (Let's Encrypt recommended)
- [ ] Database credentials ready
- [ ] Payment gateway API keys
- [ ] Firebase credentials JSON file
- [ ] Google Maps API key
- [ ] AWS S3 credentials (if using S3 storage)
- [ ] SMTP email credentials
- [ ] Purchase code and buyer username (if required)

---

## Server Setup

### 1. Update System Packages

```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install Docker and Docker Compose

```bash
# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Verify installation
docker --version
docker-compose --version
```

### 3. Install Additional Tools (if needed)

```bash
sudo apt install -y git curl wget unzip
```

### 4. Configure Firewall

```bash
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw enable
```

---

## Docker Deployment

### 1. Clone/Upload Project Files

```bash
# Create project directory
sudo mkdir -p /var/www/mangwale-backend
cd /var/www/mangwale-backend

# If using Git
git clone <repository-url> .

# Or upload files via SCP/SFTP
```

### 2. Configure Environment Variables

Create `.env` file from the template:

```bash
cp .env.example .env
nano .env
```

**Required Environment Variables:**

```env
# Application
APP_NAME="Mangwale Backend"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_INSTALL=true
APP_LOG_LEVEL=error
APP_MODE=live
APP_URL=https://yourdomain.com

# Database (for Docker, use service names)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mangwale_db
DB_USERNAME=mangwale_user
DB_PASSWORD=your_secure_password_here

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=phpredis

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120
QUEUE_CONNECTION=redis

# Broadcasting
BROADCAST_DRIVER=redis
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=mt1

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Filesystem
FILESYSTEM_DRIVER=local
# For S3 storage (optional)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_URL=

# Firebase
FIREBASE_PROJECT=app
FIREBASE_CREDENTIALS=/var/www/html/storage/app/firebase-credentials.json

# WebSockets
LARAVEL_WEBSOCKETS_PORT=6001

# Software License (if required)
PURCHASE_CODE=your_purchase_code
BUYER_USERNAME=your_username
SOFTWARE_ID=MzY3NzIxMTI=
SOFTWARE_VERSION=3.4
REACT_APP_KEY=45370351

# Payment Gateways (configure as needed)
RAZORPAY_KEY=
RAZORPAY_SECRET=
STRIPE_KEY=
STRIPE_SECRET=
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=
```

### 3. Update Docker Compose Configuration

Edit `docker-compose.yml`:

```yaml
version: '3.8'

services:
  php:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: mangwale_php
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - .:/var/www/html
    networks:
      - mangwale_network
    environment:
      - DB_HOST=mysql
      - DB_DATABASE=mangwale_db
      - DB_USERNAME=mangwale_user
      - DB_PASSWORD=your_secure_password
      - APP_URL=https://yourdomain.com
      - APP_ENV=production
    depends_on:
      - mysql
      - redis

  nginx:
    image: nginx:alpine
    container_name: mangwale_nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - .:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
      - ./ssl:/etc/nginx/ssl  # For SSL certificates
    networks:
      - mangwale_network
    depends_on:
      - php

  mysql:
    image: mysql:8.0
    container_name: mangwale_mysql
    restart: unless-stopped
    ports:
      - "3306:3306"  # Remove or change if not needed externally
    environment:
      MYSQL_ROOT_PASSWORD: your_root_password
      MYSQL_DATABASE: mangwale_db
      MYSQL_USER: mangwale_user
      MYSQL_PASSWORD: your_secure_password
    volumes:
      - mysql_data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
    networks:
      - mangwale_network

  redis:
    image: redis:7-alpine
    container_name: mangwale_redis
    restart: unless-stopped
    ports:
      - "6379:6379"  # Remove if not needed externally
    networks:
      - mangwale_network

volumes:
  mysql_data:

networks:
  mangwale_network:
    driver: bridge
```

### 4. Update Nginx Configuration

Edit `docker/nginx/default.conf` and update:
- `server_name` to your domain
- SSL certificate paths (if using SSL)
- Adjust `client_max_body_size` if needed

### 5. Build and Start Containers

```bash
# Build images
docker-compose build

# Start containers
docker-compose up -d

# Check status
docker-compose ps

# View logs
docker-compose logs -f
```

### 6. Install Dependencies Inside PHP Container

```bash
# Enter PHP container
docker exec -it mangwale_php bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies (if needed)
npm install
npm run production

# Exit container
exit
```

### 7. Generate Application Key

```bash
docker exec -it mangwale_php php artisan key:generate
```

### 8. Set Permissions

```bash
docker exec -it mangwale_php chown -R www-data:www-data /var/www/html
docker exec -it mangwale_php chmod -R 755 /var/www/html/storage
docker exec -it mangwale_php chmod -R 755 /var/www/html/bootstrap/cache
```

---

## Manual Deployment (Non-Docker)

### 1. Install PHP and Extensions

```bash
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml \
  php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-opcache \
  php8.2-redis php8.2-pcntl php8.2-exif php8.2-fileinfo php8.2-sodium \
  php8.2-tokenizer php8.2-ctype php8.2-json php8.2-openssl
```

### 2. Install MySQL

```bash
sudo apt install -y mysql-server
sudo mysql_secure_installation
```

### 3. Install Redis

```bash
sudo apt install -y redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### 4. Install Nginx

```bash
sudo apt install -y nginx
```

### 5. Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 6. Install Node.js and NPM

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 7. Deploy Application

```bash
# Create directory
sudo mkdir -p /var/www/mangwale-backend
cd /var/www/mangwale-backend

# Clone/upload files
# ...

# Set ownership
sudo chown -R www-data:www-data /var/www/mangwale-backend

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run production

# Set permissions
sudo chmod -R 755 storage
sudo chmod -R 755 bootstrap/cache
```

### 8. Configure Nginx

Create `/etc/nginx/sites-available/mangwale`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/mangwale-backend/public;

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 100M;
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/mangwale /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## Configuration

### 1. Database Configuration

Update `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # or mysql (for Docker)
DB_PORT=3306
DB_DATABASE=mangwale_db
DB_USERNAME=mangwale_user
DB_PASSWORD=your_secure_password
```

### 2. Create Database

```bash
# For Docker
docker exec -it mangwale_mysql mysql -u root -p

# For Manual
mysql -u root -p
```

```sql
CREATE DATABASE mangwale_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mangwale_user'@'%' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON mangwale_db.* TO 'mangwale_user'@'%';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Run Migrations

```bash
# Docker
docker exec -it mangwale_php php artisan migrate --force

# Manual
php artisan migrate --force
```

### 4. Seed Database (if needed)

```bash
php artisan db:seed --force
```

### 5. Install Laravel Passport

```bash
php artisan passport:install --force
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Clear and Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## Permissions & Security

### Required Directory Permissions

```bash
# Storage directories
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Ownership
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# Specific directories
chmod -R 775 storage/logs
chmod -R 775 storage/framework/cache
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/framework/views
chmod -R 775 storage/app/public
```

### Security Best Practices

1. **Set proper file permissions:**
   ```bash
   find . -type f -exec chmod 644 {} \;
   find . -type d -exec chmod 755 {} \;
   chmod -R 775 storage bootstrap/cache
   ```

2. **Protect .env file:**
   ```bash
   chmod 600 .env
   ```

3. **Disable directory listing in Nginx:**
   ```nginx
   autoindex off;
   ```

4. **Hide sensitive files:**
   - Ensure `.env`, `.git`, `composer.json`, `package.json` are not publicly accessible
   - Nginx configuration should deny access to these

5. **Firewall configuration:**
   ```bash
   sudo ufw default deny incoming
   sudo ufw default allow outgoing
   sudo ufw allow ssh
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

---

## Cron Jobs Setup

The application requires cron jobs for:
1. Laravel scheduler
2. Delivery Man disbursement (`dm:disbursement`)
3. Store disbursement (`store:disbursement`)

### Setup Laravel Scheduler

Edit crontab:

```bash
crontab -e
```

Add:

```cron
* * * * * cd /var/www/mangwale-backend && php artisan schedule:run >> /dev/null 2>&1
```

**For Docker:**

```cron
* * * * * docker exec mangwale_php php /var/www/html/artisan schedule:run >> /dev/null 2>&1
```

### Automated Disbursement Cron Jobs

The application can auto-generate cron commands via admin panel, or manually add:

```cron
# Delivery Man Disbursement (example: daily at 12:00)
0 12 * * * cd /var/www/mangwale-backend && php artisan dm:disbursement >> /dev/null 2>&1

# Store Disbursement (example: daily at 12:00)
0 12 * * * cd /var/www/mangwale-backend && php artisan store:disbursement >> /dev/null 2>&1
```

**For Docker:**

```cron
0 12 * * * docker exec mangwale_php php /var/www/html/artisan dm:disbursement >> /dev/null 2>&1
0 12 * * * docker exec mangwale_php php /var/www/html/artisan store:disbursement >> /dev/null 2>&1
```

**Note:** The schedule frequency (daily/weekly/monthly) and time are configurable in the admin panel under Business Settings > Disbursement.

---

## Queue Workers

### Setup Queue Worker

The application uses Redis for queue processing. Start queue workers:

**For Docker:**

```bash
# Start queue worker in background
docker exec -d mangwale_php php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600

# Or use supervisor (recommended for production)
```

**For Manual:**

```bash
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
```

### Using Supervisor (Recommended)

Create `/etc/supervisor/conf.d/mangwale-worker.conf`:

```ini
[program:mangwale-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/mangwale-backend/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/mangwale-backend/storage/logs/worker.log
stopwaitsecs=3600
```

For Docker, use:

```ini
[program:mangwale-worker]
process_name=%(program_name)s_%(process_num)02d
command=docker exec mangwale_php php /var/www/html/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/mangwale-backend/storage/logs/worker.log
stopwaitsecs=3600
```

Reload supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start mangwale-worker:*
```

---

## WebSockets Setup

The application uses Laravel WebSockets for real-time features.

### Start WebSocket Server

**For Docker:**

```bash
docker exec -d mangwale_php php artisan websockets:serve
```

**For Manual:**

```bash
php artisan websockets:serve
```

### Using Supervisor for WebSockets

Create `/etc/supervisor/conf.d/mangwale-websockets.conf`:

```ini
[program:mangwale-websockets]
command=php /var/www/mangwale-backend/artisan websockets:serve
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/mangwale-backend/storage/logs/websockets.log
```

For Docker:

```ini
[program:mangwale-websockets]
command=docker exec mangwale_php php /var/www/html/artisan websockets:serve
autostart=true
autorestart=true
user=root
redirect_stderr=true
stdout_logfile=/var/www/mangwale-backend/storage/logs/websockets.log
```

### Configure Nginx for WebSockets

Add to Nginx configuration:

```nginx
location /laravel-websockets {
    proxy_pass http://127.0.0.1:6001;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_read_timeout 86400;
}
```

For Docker, use container name:

```nginx
location /laravel-websockets {
    proxy_pass http://mangwale_php:6001;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_read_timeout 86400;
}
```

---

## SSL/HTTPS Configuration

### Using Let's Encrypt (Certbot)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

### Manual SSL Configuration

Update Nginx configuration:

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/mangwale-backend/public;

    ssl_certificate /etc/nginx/ssl/yourdomain.com.crt;
    ssl_certificate_key /etc/nginx/ssl/yourdomain.com.key;

    # SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # ... rest of configuration
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}
```

### For Docker

Mount SSL certificates:

```yaml
nginx:
  volumes:
    - ./ssl:/etc/nginx/ssl
```

Update Nginx config to use SSL certificates.

---

## Post-Deployment

### 1. Verify Installation

```bash
# Check application status
curl https://yourdomain.com/health

# Check API endpoints
curl https://yourdomain.com/api/v1/config
```

### 2. Run Optimizations

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

### 3. Test Critical Features

- [ ] User registration/login
- [ ] API authentication
- [ ] File uploads
- [ ] Payment gateway integration
- [ ] Push notifications
- [ ] WebSocket connections
- [ ] Email sending
- [ ] Cron jobs execution

### 4. Setup Monitoring

Consider setting up:
- Application monitoring (New Relic, Sentry)
- Server monitoring (Nagios, Zabbix)
- Log aggregation (ELK Stack, Papertrail)
- Uptime monitoring (UptimeRobot, Pingdom)

---

## Monitoring & Maintenance

### Log Files

**Application Logs:**
```bash
tail -f storage/logs/laravel.log
```

**Nginx Logs:**
```bash
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log
```

**Docker Logs:**
```bash
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f mysql
```

### Regular Maintenance Tasks

1. **Clear old logs:**
   ```bash
   php artisan log:clear
   ```

2. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Optimize autoloader:**
   ```bash
   composer dump-autoload --optimize
   ```

4. **Database maintenance:**
   ```bash
   php artisan db:backup  # If available
   ```

5. **Update dependencies:**
   ```bash
   composer update --no-dev
   ```

### Backup Strategy

1. **Database backups:**
   ```bash
   # Daily backup script
   mysqldump -u mangwale_user -p mangwale_db > backup_$(date +%Y%m%d).sql
   ```

2. **File backups:**
   ```bash
   tar -czf backup_files_$(date +%Y%m%d).tar.gz storage/
   ```

3. **Automated backups:**
   - Use cron jobs for automated daily backups
   - Store backups off-server (S3, FTP, etc.)

---

## Troubleshooting

### Common Issues

#### 1. Permission Denied Errors

```bash
sudo chown -R www-data:www-data /var/www/mangwale-backend
sudo chmod -R 755 storage bootstrap/cache
```

#### 2. Database Connection Errors

- Verify database credentials in `.env`
- Check if MySQL is running: `sudo systemctl status mysql`
- Verify network connectivity (for Docker)

#### 3. 500 Internal Server Error

- Check Laravel logs: `tail -f storage/logs/laravel.log`
- Verify `.env` file exists and is configured
- Check file permissions
- Clear cache: `php artisan cache:clear`

#### 4. Queue Jobs Not Processing

- Verify Redis is running
- Check queue worker is running: `ps aux | grep queue:work`
- Check failed jobs: `php artisan queue:failed`

#### 5. WebSockets Not Working

- Verify WebSocket server is running
- Check firewall allows port 6001
- Verify Nginx proxy configuration
- Check WebSocket logs

#### 6. Storage Link Issues

```bash
php artisan storage:link
# Verify link exists: ls -la public/storage
```

#### 7. Composer Memory Issues

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

#### 8. Docker Container Issues

```bash
# Restart containers
docker-compose restart

# Rebuild containers
docker-compose up -d --build

# View logs
docker-compose logs -f

# Access container shell
docker exec -it mangwale_php bash
```

### Debug Mode

For troubleshooting, temporarily enable debug mode:

```env
APP_DEBUG=true
APP_LOG_LEVEL=debug
```

**Remember to disable in production!**

---

## Additional Configuration

### Payment Gateways

Configure payment gateway credentials in `.env` or via admin panel:

- Razorpay
- Stripe
- PayPal
- Mercado Pago
- PhonePe
- Paystack
- Flutterwave
- SSLCommerz
- Xendit
- Iyzico

### Firebase Configuration

1. Download Firebase service account JSON
2. Place in `storage/app/firebase-credentials.json`
3. Set `FIREBASE_CREDENTIALS` in `.env`

### Google Maps API

1. Obtain API key from Google Cloud Console
2. Configure in admin panel or database:
   ```sql
   UPDATE business_settings SET value='YOUR_API_KEY' WHERE key='map_api_key_server';
   ```
3. Enable required APIs:
   - Routes API
   - Distance Matrix API
   - Directions API
   - Places API
   - Geocoding API

### Email Configuration

Configure SMTP settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Mangwale"
```

### File Storage (S3)

If using AWS S3:

```env
FILESYSTEM_DRIVER=s3
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
AWS_URL=https://your_bucket.s3.amazonaws.com
```

---

## Support & Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Docker Documentation**: https://docs.docker.com
- **Nginx Documentation**: https://nginx.org/en/docs/

---

## Version Information

- **Laravel Version**: 10.x
- **PHP Version**: 8.2+
- **MySQL Version**: 8.0+
- **Redis Version**: 7.0+
- **Software Version**: 3.4

---

**Last Updated**: 2024
**Document Version**: 1.0







