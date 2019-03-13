FROM javanile/vtiger:7.1.0

RUN apt-get update \
 && apt-get install --no-install-recommends -y git \
 && pecl install xdebug-2.5.5 \
 && curl --silent --show-error https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app
