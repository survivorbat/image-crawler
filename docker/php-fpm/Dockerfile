FROM survivorbat/php7.4-composer AS builder

COPY --chown=php:php src/composer.json src/composer.lock src/symfony.lock /app/src/

USER php

RUN composer install -d /app/src --optimize-autoloader --ignore-platform-reqs --no-interaction --no-suggest --no-scripts

# Runtime
FROM php:7.4.0alpha3-fpm-alpine AS runtime

COPY --from=builder /etc/passwd /etc/group /etc/

RUN mkdir -p /app \
    && chown php:php /app \
    && apk add --update --no-cache \
       alpine-sdk \
       php7-redis \
       php7-opcache \
       postgresql-dev \
       autoconf \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && docker-php-ext-install opcache pdo pdo_pgsql

WORKDIR /app/src

COPY --chown=php:php --from=builder /app/src/vendor /app/src/vendor
COPY --chown=php:php docker/php-fpm /
COPY src/ /app/src/

# Test with composer
FROM runtime AS test

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN /app/src/bin/phpunit

# Final image
FROM runtime
