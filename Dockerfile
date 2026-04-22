FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . .
COPY docker-entrypoint.sh /docker-entrypoint.sh

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 755 storage bootstrap/cache && chmod +x /docker-entrypoint.sh

RUN npm install && npm run build

EXPOSE 8000

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]