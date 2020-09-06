FROM php:5.6-fpm-alpine

RUN apk add --update --no-cache \
        libpng12-dev\
        libjpeg-dev

RUN docker-php-ext-install mysql mysqli
