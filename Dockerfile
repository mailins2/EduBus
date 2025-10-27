# --- EduBus Dockerfile ---
FROM php:8.2-fpm

# Cài đặt các gói cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev nginx \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy toàn bộ mã nguồn vào container
COPY . .

# Cài dependencies PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Tạo file sqlite rỗng (đề phòng provider cố mở DB)
RUN touch /tmp/database.sqlite && chown www-data:www-data /tmp/database.sqlite

# Phân quyền cho storage và cache
RUN chown -R www-data:www-data storage bootstrap/cache || true

# Copy file nginx.conf và script khởi động
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]
