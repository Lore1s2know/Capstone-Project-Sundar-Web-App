FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist \
    && test -f vendor/livewire/flux/dist/flux.css

FROM node:22-bookworm AS frontend

WORKDIR /app

ENV CI=true

COPY --from=vendor /app/vendor ./vendor
COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm ci && npm run build

FROM serversideup/php:8.4-fpm-nginx-bookworm

USER root

WORKDIR /var/www/html

COPY . /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=frontend /app/public/build /var/www/html/public/build

COPY --chmod=755 scripts/00-laravel-deploy.sh /etc/entrypoint.d/00-laravel-deploy.sh

ENV WEB_DOCUMENT_ROOT=/var/www/html/public
ENV SSL_MODE=off
ENV LOG_OUTPUT_LEVEL=warn
ENV PHP_OPCACHE_ENABLE=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1
