FROM php:7.4.3-fpm-alpine3.11

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli
# Copy the php config file
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

USER www-data