FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    sockets \
    opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/secunda

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www/secunda

USER www

EXPOSE 9000

CMD ["php-fpm"]
