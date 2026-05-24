FROM php:8.2-apache

# Install the correct Linux system packages for PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo pdo_pgsql pgsql

# Copy your code into the container
COPY . /var/www/html/

# Expose port 80 for the web traffic
EXPOSE 80