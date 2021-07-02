FROM php:8-apache

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# Configure apache server
RUN a2enmod rewrite
