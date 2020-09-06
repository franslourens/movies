FROM php:5.6-fpm-alpine

RUN apk add --update --no-cache \
        libpng-dev\
        libjpeg-turbo-dev

RUN docker-php-ext-install mysql mysqli
RUN docker-php-ext-enable mysql mysqli
