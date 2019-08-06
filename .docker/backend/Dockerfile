
FROM phpstorm/php-73-apache-xdebug-27
RUN apt-get update; apt-get -y install iputils-ping
RUN apt-get -y -f install mysql-client
RUN apt-get -y install libyaml-dev
RUN yes "" | pecl install yaml
RUN echo "extension=yaml.so" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_host=192.168.10.213" >> /usr/local/etc/php/php.ini
RUN sed -i 's/html$/backend\/web/' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/html$/backend\/web/' /etc/apache2/sites-available/default-ssl.conf