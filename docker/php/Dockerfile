FROM dunglas/frankenphp:php8.4-alpine

WORKDIR /app

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    $PHPIZE_DEPS \
    && install-php-extensions \
        intl \
        zip \
        pdo_pgsql \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer