FROM php:8.1-fpm

RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .
RUN mkdir -p storage && chown -R www-data:www-data /var/www/storage

EXPOSE 9000

CMD ["php-fpm"] 