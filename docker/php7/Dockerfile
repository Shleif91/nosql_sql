FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y  git \
            wget \
            zip \
            openjdk-7-jre \
            libpq-dev \
            libicu-dev \
            npm \
            libfreetype6-dev \
            libmcrypt-dev \
            libmemcached-dev \
            libjpeg62-turbo-dev \
            libpng12-dev

### composer
RUN cd / && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install \
    intl \
    exif \
    zip \
    opcache \
    mbstring \
    -j$(nproc) iconv mcrypt \
    pdo \
    pdo_mysql \
    pdo_pgsql

RUN yes | pecl install xdebug \ 
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \ 
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

### copy php config files
COPY ./config/ /usr/local/etc/

RUN ln -s /usr/bin/nodejs /usr/bin/node

RUN wget https://phar.phpunit.de/phpunit.phar
RUN chmod +x phpunit.phar
RUN mv phpunit.phar /usr/local/bin/phpunit

RUN apt-get update \
    && buildDeps=" \
            git \
            libmemcached-dev \
            zlib1g-dev \
    " \
    && doNotUninstall=" \
            libmemcached11 \
            libmemcachedutil2 \
    " \
    && apt-get install -y $buildDeps --no-install-recommends \
    && rm -r /var/lib/apt/lists/* \
    \
    && docker-php-source extract \
    && git clone --branch php7 https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached/ \
    && docker-php-ext-install memcached \
    \
    && docker-php-source delete \
    && apt-mark manual $doNotUninstall \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false $buildDeps

WORKDIR /var/www