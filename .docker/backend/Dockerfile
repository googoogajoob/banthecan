FROM phpstorm/php-72-apache-xdebug-27
WORKDIR /var/www
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update; apt-get -y install apt-utils; \
    apt-get -y install vim less iputils-ping zip unzip git; \
    apt-get -y -f install mysql-client
RUN cd; \
    curl -sS https://getcomposer.org/installer -o composer-setup.php; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN apt-get -y install libyaml-dev
RUN yes "" | pecl install yaml
RUN echo "extension=yaml.so" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/php.ini; \
    echo "xdebug.remote_host=192.168.10.213" >> /usr/local/etc/php/php.ini; \
    sed -i 's/html$/backend\/web/' /etc/apache2/sites-available/000-default.conf; \
    sed -i 's/html$/backend\/web/' /etc/apache2/sites-available/default-ssl.conf
RUN a2enmod rewrite
RUN a2enmod headers