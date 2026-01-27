FROM php:8.2-apache

# Enable MySQL support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project to Apache root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
