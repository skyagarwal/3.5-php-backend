# Deployment Summary - Quick Reference

## Architecture Overview

**Deployment Method**: Docker Compose (Primary) or Manual LAMP Stack

**Services**:
- PHP 8.3-FPM (Laravel 10)
- Nginx (Web Server)
- MySQL 8.0 (Database)
- Redis 7.0 (Cache & Queue)
- phpMyAdmin (Optional - Database Management)

**Current Production URL**: `https://testing.mangwale.com`

---

## Key Configuration Details

### Ports Used (Docker)
- **Nginx HTTP**: 8090 → 80
- **Nginx HTTPS**: 8443 → 443
- **MySQL**: 23306 → 3306
- **Redis**: 6380 → 6379
- **phpMyAdmin**: 8084 → 80
- **WebSockets**: 6001

### Database Configuration
- **Database Name**: `mangwale_db`
- **Username**: `mangwale_user`
- **Default Password**: `admin123` (⚠️ CHANGE IN PRODUCTION)
- **Root Password**: `rootpassword` (⚠️ CHANGE IN PRODUCTION)

### Network
- **Docker Network**: `mangwale_network` (bridge)
- **External Network**: `traefik_default` (for Traefik integration)

---

## Required Environment Variables

### Critical Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_HOST=mysql (or 127.0.0.1 for manual)
DB_DATABASE=mangwale_db
DB_USERNAME=mangwale_user
DB_PASSWORD=your_secure_password
REDIS_HOST=redis (or 127.0.0.1 for manual)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Service Integration
- **Laravel Passport**: OAuth tokens
- **WebSockets**: Real-time features
- **Firebase**: Push notifications
- **Payment Gateways**: Multiple providers
- **File Storage**: Local or S3

---

## File Permissions

### Required Permissions
```bash
storage/              → 775 (www-data:www-data)
bootstrap/cache/      → 775 (www-data:www-data)
.env                  → 600
```

### Directories Requiring Write Access
- `storage/logs/`
- `storage/framework/cache/`
- `storage/framework/sessions/`
- `storage/framework/views/`
- `storage/app/public/`

---

## Cron Jobs Required

### Laravel Scheduler
```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Disbursement Jobs
```cron
# Delivery Man Disbursement (configurable via admin panel)
0 12 * * * cd /path/to/project && php artisan dm:disbursement >> /dev/null 2>&1

# Store Disbursement (configurable via admin panel)
0 12 * * * cd /path/to/project && php artisan store:disbursement >> /dev/null 2>&1
```

**Note**: Schedule frequency and time are configurable in Admin Panel → Business Settings → Disbursement

---

## Queue Workers

### Required Process
```bash
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
```

**Recommended**: Use Supervisor for process management

---

## WebSockets

### Required Process
```bash
php artisan websockets:serve
```

**Port**: 6001
**Path**: `/laravel-websockets`
**Recommended**: Use Supervisor for process management

---

## PHP Extensions Required

- pdo_mysql
- mbstring
- exif
- pcntl
- bcmath
- gd
- zip
- opcache
- redis
- curl
- xml
- json
- fileinfo
- sodium
- tokenizer
- ctype
- openssl

---

## Nginx Configuration Highlights

### Key Settings
- **Root**: `/var/www/html/public`
- **Client Max Body Size**: 100M
- **FastCGI Timeout**: 300s
- **Gzip**: Enabled
- **Security Headers**: X-Frame-Options, X-XSS-Protection, etc.

### Special Routes
- `/public/*` → Rewritten to remove `/public/` prefix
- `/storage/app/public/*` → Rewritten to `/storage/*`
- `/laravel-websockets` → WebSocket proxy

---

## MySQL Configuration

### Custom Settings (`docker/mysql/my.cnf`)
```ini
default-authentication-plugin=mysql_native_password
innodb_buffer_pool_size=256M
max_connections=200
tmp_table_size=32M
max_heap_table_size=32M
```

---

## Deployment Steps Summary

1. **Server Setup**
   - Install Docker & Docker Compose
   - Configure firewall
   - Setup domain DNS

2. **Application Setup**
   - Clone/upload project files
   - Configure `.env` file
   - Update `docker-compose.yml`
   - Build and start containers

3. **Database Setup**
   - Create database and user
   - Run migrations
   - Install Passport

4. **Configuration**
   - Set file permissions
   - Create storage symlink
   - Cache configurations
   - Setup cron jobs

5. **Services**
   - Start queue workers
   - Start WebSocket server
   - Configure SSL/HTTPS

6. **Verification**
   - Test all endpoints
   - Verify cron jobs
   - Check queue processing
   - Test WebSocket connections

---

## Security Checklist

- [ ] Change default database passwords
- [ ] Set `APP_DEBUG=false`
- [ ] Secure `.env` file (600 permissions)
- [ ] Configure firewall rules
- [ ] Enable HTTPS/SSL
- [ ] Set proper file permissions
- [ ] Disable directory listing
- [ ] Protect sensitive files in Nginx
- [ ] Use strong database passwords
- [ ] Enable Redis password (if exposed)

---

## Monitoring Points

### Application Health
- API response times
- Error rates
- Queue job processing
- WebSocket connections
- Database query performance

### Server Resources
- CPU usage
- Memory usage
- Disk space
- Network traffic

### Services Status
- PHP-FPM processes
- Nginx status
- MySQL connections
- Redis memory usage
- Queue worker processes
- WebSocket server

---

## Backup Requirements

### Database
- Daily automated backups
- Retention: 30 days minimum
- Off-server storage recommended

### Files
- `storage/app/public/` (user uploads)
- `.env` file (secure backup)
- Configuration files

---

## Troubleshooting Quick Reference

| Issue | Solution |
|-------|----------|
| Permission denied | `chown -R www-data:www-data .` and `chmod -R 775 storage bootstrap/cache` |
| 500 Error | Check logs: `tail -f storage/logs/laravel.log` |
| Database connection | Verify credentials in `.env` and MySQL service status |
| Queue not processing | Check Redis connection and queue worker process |
| WebSocket not working | Verify WebSocket server running and Nginx proxy config |
| Storage link missing | Run `php artisan storage:link` |

---

## Support Resources

- **Main Deployment Guide**: [DEPLOYMENT_GUIDE.md](./DEPLOYMENT_GUIDE.md)
- **Quick Checklist**: [DEPLOYMENT_CHECKLIST.md](./DEPLOYMENT_CHECKLIST.md)
- **API Documentation**: [API_ENDPOINTS_DOCUMENTATION.md](./API_ENDPOINTS_DOCUMENTATION.md)

---

**Last Updated**: 2024
**Project**: PHP Mangwale Backend
**Version**: 3.4







