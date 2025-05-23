# syntax=docker/dockerfile:1

FROM php:8.2.12-apache

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./public /var/www/html

USER www-data
