FROM javanile/vtiger:7.1.0

RUN curl --silent --show-error https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

WORKDIR /app
