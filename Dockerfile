FROM php:8.2-apache

# Install PostgreSQL client tools and development libraries
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable pdo pdo_pgsql

# Copy application source code
COPY . /var/www/html/

# Expose the web server port
EXPOSE 80