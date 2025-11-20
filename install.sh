#!/bin/bash

set -e

echo "========================================"
echo "Mangwale 3.5 - One-Click Installation"
echo "========================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Error: Docker is not installed${NC}"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}Error: Docker Compose is not installed${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Docker and Docker Compose found${NC}"
echo ""

# Step 1: Environment Setup
echo "Step 1/9: Setting up environment file..."
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${GREEN}✓ .env file created from .env.example${NC}"
    else
        echo -e "${YELLOW}⚠ .env.example not found, creating basic .env${NC}"
        cat > .env << EOF
APP_NAME=Mangwale
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8090

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mangwale_db
DB_USERNAME=mangwale_user
DB_PASSWORD=admin123

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
EOF
    fi
else
    echo -e "${YELLOW}⚠ .env file already exists, skipping${NC}"
fi
echo ""

# Step 2: Stop existing containers
echo "Step 2/9: Stopping existing containers (if any)..."
docker-compose down 2>/dev/null || true
echo -e "${GREEN}✓ Existing containers stopped${NC}"
echo ""

# Step 3: Build and start containers
echo "Step 3/9: Building and starting Docker containers..."
docker-compose up -d --build
echo -e "${GREEN}✓ Docker containers started${NC}"
echo ""

# Wait for MySQL to be ready
echo "Step 4/9: Waiting for MySQL to be ready..."
sleep 10
until docker exec mangwale_mysql mysql -umangwale_user -padmin123 -e "SELECT 1" &> /dev/null; do
    echo "Waiting for MySQL..."
    sleep 5
done
echo -e "${GREEN}✓ MySQL is ready${NC}"
echo ""

# Step 5: Install Composer dependencies
echo "Step 5/9: Installing PHP dependencies..."
docker exec mangwale_php composer install --no-dev --optimize-autoloader --no-interaction
echo -e "${GREEN}✓ Composer dependencies installed${NC}"
echo ""

# Step 6: Generate application key
echo "Step 6/9: Generating application key..."
docker exec mangwale_php php artisan key:generate --force
echo -e "${GREEN}✓ Application key generated${NC}"
echo ""

# Step 7: Run migrations
echo "Step 7/9: Running database migrations..."
docker exec mangwale_php php artisan migrate --force
echo -e "${GREEN}✓ Database migrations completed${NC}"
echo ""

# Step 8: Set permissions
echo "Step 8/9: Setting correct permissions..."
docker exec mangwale_php chown -R www-data:www-data /var/www/html
docker exec mangwale_php find /var/www/html -type f -exec chmod 664 {} \;
docker exec mangwale_php find /var/www/html -type d -exec chmod 775 {} \;
docker exec mangwale_php chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

# Step 9: Cache configuration
echo "Step 9/9: Caching configuration..."
docker exec mangwale_php php artisan config:cache
docker exec mangwale_php php artisan route:cache
docker exec mangwale_php php artisan view:cache
echo -e "${GREEN}✓ Configuration cached${NC}"
echo ""

echo "========================================"
echo -e "${GREEN}Installation Complete!${NC}"
echo "========================================"
echo ""
echo "Your Mangwale 3.5 application is now running!"
echo ""
echo "Access Points:"
echo "  • Main Application: http://localhost:8090"
echo "  • phpMyAdmin: http://localhost:8084"
echo "  • Admin Panel: http://localhost:8090/admin"
echo "  • Vendor Panel: http://localhost:8090/vendor"
echo ""
echo "Database Credentials:"
echo "  • Database: mangwale_db"
echo "  • Username: mangwale_user"
echo "  • Password: admin123"
echo "  • Host: localhost:23306"
echo ""
echo "Container Status:"
docker-compose ps
echo ""
echo "To view logs: docker-compose logs -f"
echo "To stop: docker-compose down"
echo "To restart: docker-compose restart"
echo ""
echo -e "${GREEN}Happy coding!${NC}"
