#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /var/www && php artisan key:generate && php artisan config:cache && php artisan route:cache && php artisan view:cache &&  php artisan migrate --force )
fi

if [ "$role" = "app" ]; then

    php-fpm

elif [ "$role" = "queue" ]; then

    echo "Running the queue..."
    (cd /var/www &&  php /var/www/artisan queue:work --verbose --tries=3 --timeout=90 )


elif [ "$role" = "reverb" ]; then

    echo "Running the reverb..."
    (cd /var/www && php artisan reverb:install  && php artisan reverb:start)


else
    echo "Could not match the container role \"$role\""
    exit 1
fi
