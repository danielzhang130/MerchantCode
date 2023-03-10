# Use composer image for better caching
FROM composer:2.3.5 AS composer-build
COPY composer.json composer.lock ./
RUN composer install --no-scripts

# Use node image for better caching
#FROM node:18 AS node-build
#WORKDIR /app
#COPY package.json package-lock.json ./
#RUN npm install && npm install -g @symfony/webpack-encore

# Run on:
FROM debian:buster
ARG DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && \
    apt-get install -yq --no-install-recommends wget apt-transport-https lsb-release ca-certificates && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ buster main" >> /etc/apt/sources.list.d/php.list && \
    apt-get update && \
    apt-get install -yq --no-install-recommends software-properties-common && \
    apt-get install -yq --no-install-recommends \
    php7.4-cli \
    php7.4-common \
    php7.4-curl \
    php7.4-dom \
    php7.4-gd \
    php7.4-imagick \
    php7.4-intl \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-xdebug \
    php7.4-xml \
    php7.4-zip \
    libapache2-mod-php7.4 \
    zlibc \
    acl \
    make \
    libtool \
    apache2 \
    git \
    curl \
    libgconf-2-4 \
    npm
RUN npm install -g sass

# Overwrite default apache config
RUN a2enmod rewrite
COPY /docker/apache/catroweb.conf /etc/apache2/sites-available/catroweb.conf
RUN a2dissite 000-default.conf && \
    a2ensite catroweb.conf

# Overwrite php config:
RUN printf "\n%s\n" xdebug.mode=coverage >> /etc/php/7.4/apache2/php.ini
RUN printf "\n%s\n" xdebug.mode=coverage >> /etc/php/7.4/cli/php.ini

# Setting working directory
WORKDIR /var/www/catroweb

# Generate jwt config in container (will be overwritten with host keys if they exist)
COPY /docker/app/init-jwt-config.sh ./docker/app/init-jwt-config.sh
RUN sh docker/app/init-jwt-config.sh

# Copy all files to the container.
# A change to any project file clears the cache of all layers defined after this command!
# Make sure to define all project code indepandant commands above to improve performance.
COPY / ./

# Overwrite project config:
ARG APP_ENVIRONMENT
RUN echo "\n" >> .env.local && \
    echo APP_ENV=$APP_ENVIRONMENT >> .env.local && \
    echo "\n" >> .env.dev.local && \
    printf "%s\n" DATABASE_URL=pdo-mysql://root:root@db.merchantcode.dev:3306/catroweb_dev \
     ELASTICSEARCH_URL=http://elasticsearch:9200/ \
     ES_HOST=elasticsearch \
     ES_PORT=9200 >> .env.dev.local && \
    echo "\n" >> .env.test.local && \
    printf "%s\n" DATABASE_URL=pdo-mysql://root:root@db.catroweb.test:3306/catroweb_test \
     ELASTICSEARCH_URL=http://elasticsearch:9200/ \
     ES_HOST=elasticsearch \
     ES_PORT=9200 >> .env.test.local

# Add composer executable to the container
COPY --from=composer-build /usr/bin/composer /usr/bin/composer

# Add libraries and modules
COPY --from=composer-build /app/vendor vendor
COPY --from=composer-build /app/composer.lock composer.lock
#COPY --from=node-build /app/node_modules node_modules

# Add library scripts symlinks
COPY --from=composer-build /app/bin bin

# Finally we set all permissions, and create required keys and test fixtures.
RUN sh docker/app/prepare-test-env.sh

# Run webpack encore to (re-)compile public css/js files
#RUN npm run dev

EXPOSE 80
