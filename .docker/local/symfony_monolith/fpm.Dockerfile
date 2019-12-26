FROM php:7.4-fpm-buster

RUN docker-php-ext-install pdo_mysql

WORKDIR /app
