# Utilise l'image PHP avec Apache
FROM php:8.4-apache

# Installe les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copie les fichiers de ton projet
COPY . /var/www/html/

# Active Apache mod_rewrite pour Symfony
RUN a2enmod rewrite

# Modifie la configuration d'Apache pour écouter sur 0.0.0.0:80
RUN sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf
RUN sed -i 's/80/$PORT/g' /etc/apache2/sites-available/000-default.conf

# Expose le port Apache
EXPOSE 80

# Démarre Apache
CMD ["apache2-foreground"]
