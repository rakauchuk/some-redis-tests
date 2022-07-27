FROM php:8.1.8-cli-alpine3.16

RUN pecl install redis-5.3.7 \
	&& docker-php-ext-enable redis
