# Native image
FROM php:7.2-cli

# Install MySQL client
RUN apt-get update && apt-get install mysql-client -y

# Enable debuging
RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Set default workdir
WORKDIR /var/www/html

# Keep spinning
CMD ["tail", "-f", "/dev/null"]