FROM php:8.1-apache

# Installa PDO e il driver per MySQL/MariaDB
RUN docker-php-ext-install pdo pdo_mysql