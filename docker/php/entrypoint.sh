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

    if [ -f artisan ] && [ -f vendor/autoload.php ]; then
        php artisan storage:link --force --no-interaction >/dev/null 2>&1 || true
    fi
fi

exec docker-php-entrypoint "$@"
