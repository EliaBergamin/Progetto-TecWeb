FROM php:8.1-apache

# Installare le estensioni necessarie
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copiare il contenuto del sito web
COPY public/ /var/www/html/
