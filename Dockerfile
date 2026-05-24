FROM php:8.2-apache

# Install BOTH MySQL and PostgreSQL drivers so your code can connect to anything!
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql \
    && docker-php-ext-enable mysqli pdo pdo_mysql pdo_pgsql

COPY . /var/www/html/

EXPOSE 80
