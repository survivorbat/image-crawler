FROM php:7.4.0alpha3-fpm-alpine as builder
COPY src/composer.json src/composer.lock src/symfony.lock /app/src/
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN addgroup -g 1000 php \
    && adduser -u 1000 -s /bin/sh -S php \
    && mkdir -p /app \
    && chown -R php:php /app \
    && apk add --update --no-cache --virtual \
       git \
    && composer install -d /app/src --optimize-autoloader --no-interaction --no-suggest --no-scripts

# Runtime
FROM php:7.4.0alpha3-fpm-alpine AS runtime

COPY --from=builder /etc/passwd /etc/group /etc/

RUN mkdir -p /app \
    && chown php:php /app \
    && apk add --update --no-cache \
       alpine-sdk \
       php7-redis \
       php7-opcache \
       php7-gd \
       postgresql-dev \
       libpng \
       libpng-dev \
       autoconf \
       freetype \
       libjpeg-turbo \
       freetype-dev \
       jpeg-dev \
       libjpeg \
       libjpeg-turbo-dev \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd \
                --with-freetype-dir=/usr/lib/ \
                --with-png-dir=/usr/lib/ \
                --with-jpeg-dir=/usr/lib/ \
                --with-gd \
    && docker-php-ext-install opcache pdo pdo_pgsql gd

WORKDIR /app/src

COPY --chown=php:php --from=builder /app/src/vendor /app/src/vendor
COPY --chown=php:php docker/php-fpm /
COPY src/ /app/src/

ENV APP_ENV prod
ENV APP_DEBUG false

ENTRYPOINT "docker-entrypoint"

# Test with composer
FROM runtime AS test
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN /app/src/bin/phpunit --testsuite=unit,integration

# Final image
FROM runtime
