FROM survivorbat/php7.4-composer as builder

COPY --chown=php:php src/composer.json src/composer.lock src/symfony.lock /app/src/

USER php

RUN composer install -d /app/src --optimize-autoloader --ignore-platform-reqs --no-interaction --no-suggest --no-scripts

FROM php:7.4.0alpha3-fpm-alpine

RUN addgroup -g 1000 php \
    && adduser -s /bin/sh -u 1000 -S php \
    && mkdir -p /app \
    && chown php:php /app \
    && apk add --update --no-cache \
       php7-zip \
       php7-redis \
       php7-dom \
       zip \
       libzip-dev \
       chromium \
       chromium-chromedriver \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_DRIVER_BINARY /usr/lib/chromium/chromedriver

COPY --chown=php:php --from=builder /app/src/vendor /app/src/
COPY src/* app/src/