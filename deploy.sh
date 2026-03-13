#!/bin/bash
# ===========================================
# YFU Paraguay - Deployment Script
# Server: Ferozo/Dattaweb (CentOS 7)
# URL: https://yfu.org.py/app/
# ===========================================
set -e

PHP=/opt/php8-2/bin/php-cli
APP=/home/yfuorgpy/public_html/yfu_src
PUBLIC=/home/yfuorgpy/public_html/app
STORAGE=/home/yfuorgpy/storagedir

echo "========================================="
echo " YFU Paraguay - Deploy"
echo " $(date)"
echo "========================================="

# 1. Pull latest from GitHub
echo "[1/5] Pulling latest code..."
cd $APP
git pull origin main

# 2. Install/update dependencies
echo "[2/5] Composer install..."
export COMPOSER_ALLOW_SUPERUSER=1
$PHP /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --working-dir=$APP

# 3. Run migrations
echo "[3/5] Running migrations..."
$PHP $APP/artisan migrate --force

# 4. Clear and rebuild caches
echo "[4/5] Rebuilding caches..."
$PHP $APP/artisan config:cache
# NOTE: route:cache breaks subdirectory routing (/app/) - do NOT enable
$PHP $APP/artisan route:clear
$PHP $APP/artisan view:cache

# 5. Sync public assets
echo "[5/5] Syncing public assets..."
cp $APP/public/favicon.ico $PUBLIC/ 2>/dev/null || true
cp $APP/public/robots.txt $PUBLIC/ 2>/dev/null || true

# Fix permissions
chown -R yfuorgpy:webusers $APP
chown -R yfuorgpy:webusers $PUBLIC
chown -R yfuorgpy:webusers $STORAGE
chmod -R 775 $STORAGE
chmod -R 775 $APP/bootstrap/cache

echo "========================================="
echo " Deploy complete!"
echo " URL: https://yfu.org.py/app/"
echo "========================================="
