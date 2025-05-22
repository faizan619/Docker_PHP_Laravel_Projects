# syntax=docker/dockerfile:1

FROM php:8.2.12-apache

# Set production-level php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install required extensions for PDO + MySQL
RUN apt-get update && apt-get install -y \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite (optional, good for frameworks)
RUN a2enmod rewrite

# Set working directory (optional)
WORKDIR /var/www/html

# Copy your app files into Apache web root
COPY ./public /var/www/html
