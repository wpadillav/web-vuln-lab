# Usar la imagen base de Apache con PHP 8
FROM php:8.2-apache

# Instalar dependencias y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    mariadb-client \
    libmariadb-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

    RUN mkdir -p /etc/apache2/ssl \
    && a2enmod ssl \
    && a2ensite default-ssl

# Habilitar módulos de Apache
RUN a2enmod rewrite headers

# Configurar el archivo de hosts virtuales
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf
# Configurar el archivo de hosts virtuales para SSL
COPY apache-config/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Copiar los archivos del sitio vulnerable
COPY sitio/ /var/www/html/

COPY ssl/ /etc/apache2/ssl/

# Puerto expuesto
EXPOSE 80
EXPOSE 443

# Comando de inicio
CMD ["apache2-foreground"]
