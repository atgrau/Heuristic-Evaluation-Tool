FROM php:apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY dist /var/www/html/dist
COPY sql-files /var/www/html/sql-files
COPY src /var/www/html/src
COPY vendor /var/www/html/vendor
COPY .htaccess /var/www/html
COPY index.php /var/www/html