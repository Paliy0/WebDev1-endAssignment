#!/bin/bash
set -e

# Railway provides PORT environment variable
PORT=${PORT:-80}

# Replace port in nginx config
sed -i "s/listen 80/listen $PORT/" /etc/nginx/nginx.conf

# Start PHP-FPM in background
php-fpm -D

# Start nginx in foreground
nginx -g 'daemon off;'
