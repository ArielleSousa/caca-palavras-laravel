#!/bin/sh
php artisan config:clear
php artisan migrate --force
php artisan db:seed --class=PalavraSeeder --force
exec /usr/bin/supervisord -c /etc/supervisord.conf
