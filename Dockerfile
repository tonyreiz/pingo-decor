FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        pdo_mysql \
        dom \
        xml \
        zip \
        intl \
        mbstring \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY docker/php/entrypoint.sh /usr/local/bin/pingo-entrypoint

RUN chmod +x /usr/local/bin/pingo-entrypoint

ENTRYPOINT ["/usr/local/bin/pingo-entrypoint"]

CMD ["php-fpm"]