#!/bin/bash

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

composer install

php artisan migrate --force

php artisan storage:link

echo yes | php artisan passport:client --personal

exec php-fpm
