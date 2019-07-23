FROM navidonskis/nginx-php7.1

MAINTAINER Maxim Ilchenko <dsx90@yandex.ru>

ARG DEBIAN_FRONTEND=noninteractive

#Установка всех пакетов и зваисимостей
RUN apt-get update &&\
    apt install -y mc aptitude nano nginx git supervisor curl memcached ssmtp