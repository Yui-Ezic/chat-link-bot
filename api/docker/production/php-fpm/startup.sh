#!/bin/sh

sed -i "s/80/${PORT}/g" /etc/nginx/http.d/default.conf
sed -i "s/bot-php-fpm/127.0.0.1/g" /etc/nginx/http.d/default.conf

php-fpm -D

while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;

nginx

sleep infinit
