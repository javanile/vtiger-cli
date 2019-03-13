FROM javanile/vtiger:7.1.0

RUN docker-php-ext-enable xdebug \
 && curl --silent --show-error https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

WORKDIR /app
