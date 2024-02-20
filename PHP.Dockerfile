FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

# Latest release
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
# RUN pecl install xdebug && docker-php-ext-enable xdebug