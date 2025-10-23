# Dùng PHP 8.2 với FPM
FROM php:8.2-fpm

# Cài đặt Nginx, Composer và các extension cần thiết
RUN apt-get update && apt-get install -y \
    nginx git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Đặt thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ mã nguồn vào container
COPY . .

# Cấp quyền ghi cho Laravel
RUN chmod -R 777 storage bootstrap/cache

# Copy file cấu hình nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài đặt dependencies (bỏ qua nếu đã có vendor/)
RUN composer install --no-interaction --no-dev --optimize-autoloader || true

# Xoá default site của nginx (nếu có)
RUN rm -f /etc/nginx/sites-enabled/default || true

# Expose port 80 cho Render
EXPOSE 80

# Khởi động Nginx và PHP-FPM khi container chạy
CMD ["sh", "-c", "service nginx start && php-fpm -F"]
