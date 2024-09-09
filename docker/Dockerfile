# Stage 1: Install dependencies
FROM composer:2 as vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader

# Stage 2: Build the application
FROM php:8.3-fpm

WORKDIR /var/www

COPY . .

COPY --from=vendor /app/vendor ./vendor

RUN docker-php-ext-install pdo pdo_mysql

# Install additional dependencies (optional)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www

# Открываем порт для подключения к приложению
EXPOSE 8000

# Запускаем сервер Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


