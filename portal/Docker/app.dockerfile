FROM php:7.4-fpm-alpine

RUN docker-php-ext-install opcache pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli


RUN apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer
