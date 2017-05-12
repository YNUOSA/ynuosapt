FROM php:5.6-apache
RUN docker-php-ext-install mysql mysqli
RUN apt-get update -y && apt-get install -y sendmail libpng-dev
#no libpng
RUN docker-php-ext-install gd
RUN yes | pecl install xdebug
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini
