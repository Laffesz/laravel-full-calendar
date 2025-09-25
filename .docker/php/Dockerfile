FROM ubuntu:24.04

WORKDIR /app

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install dependencies
RUN apt-get update \
    && apt-get install -y bash git tini libzip-dev zip curl

# Install PHP and extensions
RUN apt-get update \
    && apt-get install -y php php-opcache php-apcu php-intl php-zip php-sockets php-curl php-redis php-bcmath php-xml php-ctype php-iconv php-mbstring

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/tmp

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add the wait script to the image
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.9.0/wait /wait
RUN chmod +x /wait

CMD ["php", "-v"]
