FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade && apk add --no-cache bash git libzip-dev

RUN docker-php-ext-install zip pdo pdo_mysql

WORKDIR /var/www/html

COPY ./ /var/www/html

RUN php composer.phar install