# Production Deployment Quick Checklist

Use this checklist alongside the detailed [DEPLOYMENT_GUIDE.md](./DEPLOYMENT_GUIDE.md)

## Pre-Deployment

- [ ] Server provisioned (2+ CPU, 4GB+ RAM, 20GB+ storage)
- [ ] Domain name registered and DNS configured
- [ ] SSH access to server
- [ ] Firewall configured (ports 22, 80, 443)
- [ ] All API keys and credentials ready:
  - [ ] Database credentials
  - [ ] Payment gateway keys (Razorpay, Stripe, PayPal, etc.)
  - [ ] Firebase service account JSON
  - [ ] Google Maps API key
  - [ ] AWS S3 credentials (if using)
  - [ ] SMTP email credentials
  - [ ] Purchase code (if required)

## Server Setup

- [ ] System updated (`apt update && apt upgrade`)
- [ ] Docker & Docker Compose installed
- [ ] Git/curl/wget installed
- [ ] Firewall rules configured

## Application Deployment

- [ ] Project files uploaded/cloned to server
- [ ] `.env` file created and configured
- [ ] Docker Compose file updated with production values
- [ ] Nginx configuration updated with domain name
- [ ] Docker containers built and started
- [ ] PHP dependencies installed (`composer install --no-dev`)
- [ ] Node dependencies installed and assets compiled (`npm run production`)
- [ ] Application key generated (`php artisan key:generate`)

## Database Setup

- [ ] MySQL database created
- [ ] Database user created with proper permissions
- [ ] Migrations run (`php artisan migrate --force`)
- [ ] Database seeded (if needed)
- [ ] Laravel Passport installed (`php artisan passport:install`)

## Permissions & Security

- [ ] Storage directory permissions set (775)
- [ ] Bootstrap cache permissions set (775)
- [ ] Ownership set to www-data:www-data
- [ ] `.env` file secured (600)
- [ ] Storage symlink created (`php artisan storage:link`)
- [ ] Sensitive files protected in Nginx

## Configuration

- [ ] Environment variables configured in `.env`
- [ ] Cache configuration optimized
- [ ] Queue connection set to Redis
- [ ] Session driver set to Redis
- [ ] Mail configuration tested
- [ ] Payment gateways configured
- [ ] Firebase credentials uploaded
- [ ] Google Maps API key configured

## Cron Jobs

- [ ] Laravel scheduler cron added (`* * * * * php artisan schedule:run`)
- [ ] Delivery Man disbursement cron configured
- [ ] Store disbursement cron configured
- [ ] Cron jobs tested and verified

## Queue Workers

- [ ] Queue worker process started
- [ ] Supervisor configured for queue workers (recommended)
- [ ] Queue connection verified (Redis)
- [ ] Failed jobs table created

## WebSockets

- [ ] WebSocket server started
- [ ] Supervisor configured for WebSockets (recommended)
- [ ] Nginx proxy configured for WebSocket connections
- [ ] WebSocket port (6001) accessible

## SSL/HTTPS

- [ ] SSL certificate obtained (Let's Encrypt recommended)
- [ ] Nginx configured for HTTPS
- [ ] HTTP to HTTPS redirect configured
- [ ] SSL certificate auto-renewal configured

## Optimization

- [ ] Configuration cached (`php artisan config:cache`)
- [ ] Routes cached (`php artisan route:cache`)
- [ ] Views cached (`php artisan view:cache`)
- [ ] Events cached (`php artisan event:cache`)
- [ ] Autoloader optimized (`composer dump-autoload --optimize`)
- [ ] OPcache enabled (if manual deployment)

## Testing

- [ ] Application accessible via domain
- [ ] API endpoints responding
- [ ] User registration/login working
- [ ] File uploads working
- [ ] Payment gateway integration tested
- [ ] Push notifications working
- [ ] WebSocket connections working
- [ ] Email sending tested
- [ ] Cron jobs executing
- [ ] Queue jobs processing

## Monitoring & Maintenance

- [ ] Log monitoring setup
- [ ] Error tracking configured (Sentry, etc.)
- [ ] Uptime monitoring configured
- [ ] Backup strategy implemented:
  - [ ] Database backup script
  - [ ] File backup script
  - [ ] Automated backup schedule
- [ ] Monitoring alerts configured

## Post-Deployment

- [ ] Debug mode disabled (`APP_DEBUG=false`)
- [ ] Log level set to production (`APP_LOG_LEVEL=error`)
- [ ] Application mode set to live (`APP_MODE=live`)
- [ ] Installation flag set (`APP_INSTALL=true`)
- [ ] All services running and healthy
- [ ] Performance benchmarks acceptable
- [ ] Security scan completed

## Documentation

- [ ] Deployment guide reviewed
- [ ] Team members trained on deployment process
- [ ] Rollback procedure documented
- [ ] Emergency contacts documented

## Final Verification

- [ ] All checklist items completed
- [ ] Application fully functional
- [ ] No errors in logs
- [ ] Performance acceptable
- [ ] Security measures in place
- [ ] Backup system working
- [ ] Monitoring active

---

## Quick Commands Reference

### Docker Commands
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up -d --build

# Access PHP container
docker exec -it mangwale_php bash
```

### Laravel Commands
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan optimize

# Run migrations
php artisan migrate --force

# Install Passport
php artisan passport:install --force

# Create storage link
php artisan storage:link
```

### System Commands
```bash
# Check service status
sudo systemctl status nginx
sudo systemctl status mysql
sudo systemctl status redis

# Check disk space
df -h

# Check memory usage
free -h

# Check running processes
ps aux | grep php
```

---

**Note**: Keep this checklist updated as you deploy. Mark items as complete and note any deviations or custom configurations.







