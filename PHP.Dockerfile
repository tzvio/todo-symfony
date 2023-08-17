FROM php:8.2-fpm
RUN apt-get -y update \
    && apt-get install -y libssl-dev pkg-config libzip-dev unzip git

RUN pecl install zlib zip mongodb \
    && docker-php-ext-enable zip \
    && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
WORKDIR /app
RUN composer require symfony/webpack-encore-bundle
RUN npm install
RUN npm install bootstrap --save-dev
RUN git config --global --add safe.directory /app \
    && git config --global user.name  "tzvika ofek" \
    && git config --global user.email "tzvika.ofek@gmail.com"