FROM dunglas/frankenphp

RUN install-php-extensions opcache pdo_mysql gd intl zip

RUN sed -i 's/php-fpm/frankenphp run/g' /usr/local/bin/docker-php-entrypoint

CMD [ "--config", "/etc/Caddyfile" ]
