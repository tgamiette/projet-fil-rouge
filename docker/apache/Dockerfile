# https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION=8.1

# "php" stage
FROM php:${PHP_VERSION}-apache AS symfony_php

## Basic tools
RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install -y bash \
            curl \
            wget \
            ca-certificates \
            nano \
    		acl

## Apache
RUN a2enmod ssl rewrite

## PHP
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxrender1 libfontconfig \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libmcrypt-dev \
        zip libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install pdo_mysql gd mbstring bcmath zip intl opcache \
    && docker-php-ext-enable intl opcache

## APCU
ENV EXT_APCU_VERSION=5.1.17
RUN docker-php-source extract \
     &&  pecl install apcu  \
    && docker-php-ext-enable apcu \
    && docker-php-source delete

## Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Symfony cache folder
ENV CACHE_SYMFONY=/var/www/symfony/var/cache
RUN mkdir -p $CACHE_SYMFONY
RUN chown -R www-data: $CACHE_SYMFONY

WORKDIR /var/www/symfony

