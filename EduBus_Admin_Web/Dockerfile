FROM php:8.2-fpm

# Cài đặt Nginx và các extension cần cho Laravel
RUN apt-get update && apt-get install -y nginx zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Sao chép mã nguồn vào container
WORKDIR /var/www/html
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Cấp quyền ghi cho storage
RUN chmod -R 777 storage bootstrap/cache

# Sao chép file cấu hình nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80 để Render truy cập
EXPOSE 80

# Lệnh khởi động container
CMD ["sh", "-c", "service nginx start && php-fpm -F"]


