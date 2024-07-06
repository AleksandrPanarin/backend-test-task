FROM php:8.3-cli-alpine as sio_test

RUN apk add --no-cache git zip bash gmp-dev mpfr-dev mpc1-dev autoconf gcc g++ make libtool wget

RUN wget http://www.bytereef.org/software/mpdecimal/releases/mpdecimal-2.5.1.tar.gz \
    && tar -xzf mpdecimal-2.5.1.tar.gz \
    && cd mpdecimal-2.5.1 \
    && ./configure \
    && make \
    && make install \
    && cd .. \
    && rm -rf mpdecimal-2.5.1 mpdecimal-2.5.1.tar.gz

RUN pecl install decimal \
    && docker-php-ext-enable decimal
# Setup php extensions
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql

ENV COMPOSER_CACHE_DIR=/tmp/composer-cache
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setup php app user
ARG USER_ID=1000
RUN adduser -u ${USER_ID} -D -H app
USER app

COPY --chown=app . /app
WORKDIR /app

EXPOSE 8337

CMD ["php", "-S", "0.0.0.0:8337", "-t", "public"]
