FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

WORKDIR /var/www/html

# El código de la aplicación se monta desde el host vía bind-mount en docker-compose.yml
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
