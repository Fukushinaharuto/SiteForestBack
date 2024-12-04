FROM php:8.3-fpm
WORKDIR /back

COPY ./back .

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME "/opt/composer"
ENV PATH "$PATH:/opt/composer/vendor/bin"

RUN apt-get update && \
    apt-get -y install git unzip libzip-dev libpq-dev && \
    docker-php-ext-install zip pdo pdo_pgsql && \
    docker-php-ext-enable pdo_pgsql

RUN composer install

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]