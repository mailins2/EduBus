FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www/html

# Copy toàn bộ mã nguồn Laravel
COPY . .

RUN chmod -R 777 storage bootstrap/cache

# Copy file cấu hình nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --no-dev --optimize-autoloader || true

# Xoá site mặc định của nginx
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf.default || true

# Debug kiểm tra nội dung public/
RUN ls -la /var/www/html && ls -la /var/www/html/public

EXPOSE 80

CMD ["sh", "-c", "service nginx start && php-fpm -F"]
