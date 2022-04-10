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
#     ext-apcu \
     &&  pecl install apcu && docker-php-ext-enable apcu \
    # cleanup
    && docker-php-source delete

## Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## WkHtmlToPdf
# RUN apt-get install -y xvfb libfontconfig fontconfig libpng16-16 libxrender1 xfonts-75dpi build-essential xorg xfonts-base && \
#     mkdir -p /tmp && \
#     wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.stretch_amd64.deb -P /tmp/wkhtmltopdf && \
#     dpkg -i /tmp/wkhtmltopdf/wkhtmltox_0.12.6-1.stretch_amd64.deb && \
#     apt -f install && \
#     ln -s /usr/local/bin/wkhtmltopdf /usr/bin/wkhtmltopdf && \
#     apt-get autoremove -y  && \
#     apt-get clean && \
#     rm -rf /var/lib/apt/lists/* && \
#     rm -rf /tmp/*

## Symfony cache folder
ENV CACHE_SYMFONY=/var/www/symfony/var/cache
RUN mkdir -p $CACHE_SYMFONY
RUN chown -R www-data: $CACHE_SYMFONY

WORKDIR /var/www/symfony

