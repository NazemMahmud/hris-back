FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    unzip \
    ldap-utils \
    libldap2-dev \
    curl \
    libpng-dev

#upload
RUN echo "file_uploads = On\n" \
         "memory_limit = 500M\n" \
         "upload_max_filesize = 500M\n" \
         "post_max_size = 500M\n" \
         "max_execution_time = 6000\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    # host.docker.internal does not work on Linux yet: https://github.com/docker/for-linux/issues/264
    # Workaround:
    # ip -4 route list match 0/0 | awk '{print $3 " host.docker.internal"}' >> /etc/hosts \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-configure bcmath --enable-bcmath
RUN docker-php-ext-install pdo_mysql zip ldap exif bcmath
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install gd


# An IDE key has to be set, but anything works, at least for PhpStorm and VS Code...
ENV XDEBUG_CONFIG="xdebug.idekey=''"

