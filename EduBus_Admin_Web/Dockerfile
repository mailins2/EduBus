FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www/html

# Copy toàn bộ mã nguồn Laravel
COPY . .

# Tạo database SQLite nếu chưa có
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache

# Copy file cấu hình nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --no-dev --optimize-autoloader || true

# Xóa toàn bộ config mặc định của Nginx
RUN rm -f /etc/nginx/conf.d/default.conf /etc/nginx/sites-enabled/default || true

# Copy file cấu hình nginx của bạn
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Khởi động cả Nginx và PHP-FPM
CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm -F"]

