FROM php:8.2.3-fpm-alpine3.17

RUN apk add --no-cache \
    bash \
    git \
    curl \
    zip \
    unzip

# Install PostgreSQL client and the required PHP extension
RUN apk --update --no-cache add postgresql-dev && \
    docker-php-ext-install pdo_pgsql
# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install Symfony CLI globally
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

#RUN addgroup -S www-data && adduser -S www-data www-data
RUN chown -R www-data:www-data /var/www
USER www-data

RUN echo "alias ll='ls -la --color'" > ~/.bashrc #

WORKDIR /var/www