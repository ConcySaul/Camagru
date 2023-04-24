FROM php:7.4-apache 

# SSL

RUN a2enmod ssl
RUN apt-get update && \
    apt-get install -y openssl libssl-dev && \
    rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 /var/www/html

RUN a2enmod rewrite

RUN openssl req -new -newkey rsa:2048 -nodes -keyout /etc/ssl/private/apache-selfsigned.key -x509 -days 365 -out /etc/ssl/certs/apache-selfsigned.crt -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=localhost"

COPY default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN a2ensite default-ssl.conf

RUN docker-php-ext-install pdo_mysql

RUN curl -o /tmp/PHPMailer.tar.gz -SL https://github.com/PHPMailer/PHPMailer/archive/v6.5.1.tar.gz \
    && tar -xzf /tmp/PHPMailer.tar.gz -C /tmp \
    && mv /tmp/PHPMailer-6.5.1 /usr/local/lib/phpmailer \
    && rm /tmp/PHPMailer.tar.gz
