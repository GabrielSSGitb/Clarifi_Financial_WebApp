# syntax=docker/dockerfile:1

# ===============================================================
#  ClariFi - imagem multi-stage
#
#    base        extensoes PHP compartilhadas entre dev e producao
#    dev         usada pelo docker-compose (codigo vem do bind mount)
#    assets      compila os ativos de frontend com Vite
#    production  imagem final, auto-contida, servida pelo FrankenPHP
#
#  Build de desenvolvimento:  docker build --target dev .
#  Build de producao:         docker build --target production .
# ===============================================================

# ---------------------------------------------------------------
# base
# ---------------------------------------------------------------
FROM php:8.5-cli-alpine AS base

COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/

# pdo_pgsql -> Postgres | zip, gd -> maatwebsite/excel (PhpSpreadsheet)
# intl, bcmath -> formatacao monetaria e calculos | opcache -> performance
RUN apk add --no-cache bash curl git \
    && install-php-extensions pdo_pgsql zip intl gd bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

WORKDIR /var/www

# ---------------------------------------------------------------
# dev
# ---------------------------------------------------------------
FROM base AS dev

ENV PHP_CLI_SERVER_WORKERS=4

COPY docker/entrypoint.dev.sh /usr/local/bin/clarifi-entrypoint
RUN chmod +x /usr/local/bin/clarifi-entrypoint

EXPOSE 8000

HEALTHCHECK --interval=15s --timeout=5s --start-period=300s --retries=40 \
    CMD curl -fsS http://127.0.0.1:8000/up || exit 1

ENTRYPOINT ["clarifi-entrypoint"]
CMD ["serve-app"]

# ---------------------------------------------------------------
# assets
# ---------------------------------------------------------------
FROM node:24-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci --no-audit --no-fund

# O Tailwind v4 varre as views Blade em busca das classes usadas,
# por isso o contexto inteiro (menos o que esta no .dockerignore)
# precisa estar presente no momento do build.
COPY . .
RUN npm run build

# ---------------------------------------------------------------
# production
# ---------------------------------------------------------------
FROM dunglas/frankenphp:1-php8.4-alpine AS production

RUN install-php-extensions pdo_pgsql zip intl gd bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1 \
    APP_ENV=production \
    APP_DEBUG=false \
    SERVER_NAME=:8080

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress

COPY . .
COPY --from=assets /app/public/build ./public/build


RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && composer dump-autoload --no-dev --optimize --classmap-authoritative \
    && php artisan package:discover --ansi \
    && php artisan view:cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

HEALTHCHECK --interval=15s --timeout=5s --start-period=30s --retries=5 \
    CMD curl -fsS http://127.0.0.1:8080/up || exit 1
