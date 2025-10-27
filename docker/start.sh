#!/usr/bin/env bash
set -e

# Nếu APP_KEY chưa được set thì tự generate tạm (chỉ để chạy)
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY not found, generating temporary one..."
  php artisan key:generate --force
fi

# Clear cache cũ
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Start PHP-FPM và Nginx
php-fpm -D
nginx -g 'daemon off;'
