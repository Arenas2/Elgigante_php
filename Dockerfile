FROM nanoninja/php-fpm

# Install FPM
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.0-fpm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists
