FROM php:8.2-fpm

ARG NOVA_USERNAME
ARG NOVA_PASSWORD

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
      apt-utils \
      git \
      libzip-dev \
      zip unzip \
      libpq-dev && \
      curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
      apt-get install -y nodejs && \
      docker-php-ext-install pdo pdo_pgsql && \
      docker-php-ext-install sockets && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --chown=root:root . .

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN composer config http-basic.nova.laravel.com ${NOVA_USERNAME} ${NOVA_PASSWORD}

RUN composer install \
      --no-interaction \
      --no-plugins \
      --no-suggest \
      --no-scripts \
      --no-autoloader \
      --prefer-dist

RUN composer dump-autoload  --no-scripts --optimize && \
    php artisan storage:link && \
    chown -R www-data:www-data /var/www && \
    chmod 755 -R /var/www && \
    chmod 775 -R /var/www/storage && \
    chmod 775 -R /var/www/bootstrap/cache





