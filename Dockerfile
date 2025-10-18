# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiamos todo el proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Damos permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Exponemos el puerto 80
EXPOSE 80
