FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y nginx curl unzip git

COPY app /var/www/html

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD service php8.2-fpm start && nginx -g 'daemon off;'