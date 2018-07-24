#!/bin/bash
#
# Provisioning File
#
echo "Begin Provisioning "
uname -a

echo "Repository update and upgrade"
sudo apt-get update
sudo apt-get upgrade

echo "Install Apache2"
sudo apt-get -y install apache2
sudo cp /vagrant/.vagrant-provision/banthecan.conf /etc/apache2/sites-available
sudo cp /vagrant/.vagrant-provision/banthecan-admin.conf /etc/apache2/sites-available
sudo a2ensite banthecan.conf
sudo a2ensite banthecan-admin.conf
sudo a2dissite 000-default.conf

echo "Install PHP"
sudo apt-get -y install php7.0
sudo apt-get -y install php-xdebug
sudo apt-get install libapache2-mod-php7.0
sudo apt-get install php7.0-mysql

echo "Configure Apache"
sudo a2enmod rewrite
sudo a2enmod reqtimeout
sudo a2enmod php7.0
sudo cp /vagrant/.vagrant-provision/20-xdebug.ini /etc/php/7.0/apache2/conf.d/20-xdebug.ini
sudo service apache2 restart

echo "Install MariaDB"
sudo apt-get -y install mariadb-server
export DATABASE_PASS="root"
sudo mysqladmin -u root password "$DATABASE_PASS"
sudo mysql -u root -p"$DATABASE_PASS" -e "UPDATE mysql.user SET plugin = 'mysql_native_password' WHERE User='root'"
sudo mysql -u root -p"$DATABASE_PASS" -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1')"
sudo mysql -u root -p"$DATABASE_PASS" -e "DELETE FROM mysql.user WHERE User=''"
sudo mysql -u root -p"$DATABASE_PASS" -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%'"
sudo mysql -u root -p"$DATABASE_PASS" -e "FLUSH PRIVILEGES"
sudo mysql -u root -p"$DATABASE_PASS" -e "CREATE DATABASE IF NOT EXISTS banthecan_demo"
sudo mysql -u root -p"$DATABASE_PASS" banthecan_demo < /vagrant/.vagrant-provision/banthecandemo.sql

echo "Provisioning Complete"
