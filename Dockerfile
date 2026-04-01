FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

FROM composer:latest as builder

WORKDIR /app
COPY . .
RUN composer install --no-dev

FROM php:8.4-fpm

WORKDIR /var/www/html
COPY --from=builder /app .

CMD ["php-fpm"]
