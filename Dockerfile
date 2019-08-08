FROM javanile/vtiger:7.1.0

RUN apt-get update \
 && apt-get install -y --no-install-recommends git \
 && pecl install xdebug-2.5.5 \
 && docker-php-ext-enable xdebug \
 && echo "phar.readonly = Off" > /usr/local/etc/php/conf.d/phar.ini \
 && curl --silent --show-error https://getcomposer.org/installer | php \
 && curl -LSs https://box-project.github.io/box2/installer.php | php \
 && mv composer.phar /usr/local/bin/composer \
 && mv box.phar /usr/local/bin/box \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app
