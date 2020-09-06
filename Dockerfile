FROM php:5.6-fpm-alpine

RUN apk add --update --no-cache \
        libpng-dev\
        libjpeg-turbo-dev \
        zlib-dev \
        pcre-dev

RUN docker-php-ext-install mysql mysqli
#RUN docker-php-ext-enable mysql mysqli
