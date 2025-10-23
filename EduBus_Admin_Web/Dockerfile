FROM php:8.2-fpm

# Cài đặt Nginx và các extension cần cho Laravel
RUN apt-get update && apt-get install -y nginx zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Sao chép toàn bộ mã nguồn Laravel vào container
COPY . .

# Cấp quyền ghi cho storage và bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Sao chép file cấu hình nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80 để Render truy cập
EXPOSE 80

# Chạy nginx và php-fpm
CMD ["sh", "-c", "nginx && php-fpm -F"]
