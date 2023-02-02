#!/usr/bin/env bash

if ./docker/app/wait-for-it.sh db.merchantcode.dev:3306 -t 60; then
    if bin/console doctrine:migrations:migrate --no-interaction; then
        /usr/sbin/apache2ctl -D FOREGROUND
    fi
fi