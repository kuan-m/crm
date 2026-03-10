ARG PHP_IMAGE
ARG APP_USER
ARG APP_GROUP
ARG APP_UID
ARG APP_GID
FROM ${PHP_IMAGE} AS app

ARG APP_USER
ARG APP_GROUP
ARG APP_UID
ARG APP_GID

RUN apk add --no-cache \
    bash \
    git \
    icu-dev \
    libzip-dev \
    linux-headers \
    mysql-client \
    unzip \
    zip \
    ${PHPIZE_DEPS} \
 && docker-php-ext-install -j"$(nproc)" intl opcache pdo_mysql zip \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && apk del ${PHPIZE_DEPS} \
 && rm -f /usr/local/etc/php/php.ini /usr/local/etc/php/conf.d/xdebug.ini \
 && rm -f /usr/local/etc/php-fpm.d/www.conf \
 && addgroup -g "${APP_GID}" -S "${APP_GROUP}" \
 && adduser -u "${APP_UID}" -S -D -G "${APP_GROUP}" -h "/home/${APP_USER}" "${APP_USER}" \
 && mkdir -p /home/"${APP_USER}" /var/www/crm /var/www/crm/vendor \
 && chown -R "${APP_UID}:${APP_GID}" /home/"${APP_USER}" /var/www/crm \
 && git config --system --add safe.directory /var/www/crm

COPY --from=composer:2.8.6 /usr/bin/composer /usr/local/bin/composer

COPY infra/development/php/php.ini /usr/local/etc/php/php.ini
COPY infra/development/php/zz-opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY infra/development/php/zz-xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini
COPY infra/development/php-fpm/crm.conf /usr/local/etc/php-fpm.d/crm.conf

WORKDIR /var/www/crm
ENV HOME=/home/${APP_USER}
ENV COMPOSER_HOME=/home/${APP_USER}/.composer
USER ${APP_USER}

CMD ["php-fpm", "-F"]
