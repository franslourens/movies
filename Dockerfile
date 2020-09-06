FROM php:5.6-fpm-alpine

RUN apk add --update --no-cache \
        libpng-dev\
        libjpeg-dev

RUN docker-php-ext-install mysql mysqli
