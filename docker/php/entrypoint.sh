#!/bin/sh
set -eu

if [ -d /var/www ]; then
    umask 0002

    mkdir -p \
        /var/www/bootstrap/cache \
        /var/www/public/pingo-decor/assets/banner \
        /var/www/public/pingo-decor/assets/funcionario \
        /var/www/storage/app/public \
        /var/www/storage/framework/cache/data \
        /var/www/storage/framework/sessions \
        /var/www/storage/framework/views \
        /var/www/storage/logs

    chgrp -R www-data \
        /var/www/public/pingo-decor/assets/banner \
        /var/www/public/pingo-decor/assets/funcionario \
        /var/www/storage \
        /var/www/bootstrap/cache \
        2>/dev/null || true

    chmod -R g+rwX \
        /var/www/public/pingo-decor/assets/banner \
        /var/www/public/pingo-decor/assets/funcionario \
        /var/www/storage \
        /var/www/bootstrap/cache \
        2>/dev/null || true

    find \
        /var/www/public/pingo-decor/assets/banner \
        /var/www/public/pingo-decor/assets/funcionario \
        /var/www/storage \
        /var/www/bootstrap/cache \
        -type d -exec chmod g+s '{}' + \
        2>/dev/null || true

    cd /var/www

    if [ -f artisan ] && [ -f composer.json ]; then
        if [ ! -f .env ] && [ -f .env.example ]; then
            cp .env.example .env
        fi

        if [ ! -f vendor/autoload.php ]; then
            composer install --no-interaction --prefer-dist
        fi

        if [ -f vendor/autoload.php ]; then
            if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
                php artisan key:generate --force --no-interaction
            fi

            php artisan storage:link --no-interaction 2>/dev/null || true
            php artisan migrate --force --no-interaction
        fi
    fi
fi

exec docker-php-entrypoint "$@"
