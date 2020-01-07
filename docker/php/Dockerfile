FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libmemcached-dev \
        libpng-dev \
        git-core \
        zip \
        libcurl3-dev \
        curl \
        unzip \
        ffmpeg \
        && docker-php-ext-configure gd --with-png-dir=/usr/include --with-jpeg-dir=/usr/include \
        && docker-php-ext-install gd \
        && docker-php-ext-install zip \
        && docker-php-ext-install curl \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install bcmath \
        && pecl install mongodb \
        && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini \
        && pecl install memcached \
        && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/ext-memcached.ini


RUN curl -sS https://getcomposer.org/installer | php

RUN mv composer.phar /usr/local/bin/composer

EXPOSE 9000

CMD ["php-fpm", "-F"]