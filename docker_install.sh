#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

apk add ca-certificates zip unzip git curl libzip-dev libpng-dev libxml2-dev oniguruma-dev
docker-php-ext-install pdo pdo_mysql zip gd bcmath xml
update-ca-certificates
curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar && chmod +x /usr/local/bin/phpunit
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
export PATH="/usr/local/bin:$PATH"