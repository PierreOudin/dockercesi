FROM php:7.4.3-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR ../html
FROM ubuntu
RUN apt-get update
RUN apt-get install -y git
RUN git clone https://github.com/PierreOudin/GSB_PHP.git
