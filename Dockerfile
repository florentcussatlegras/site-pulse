# Utilise l'image PHP avec Apache
FROM php:8.4-apache

# Installe les extensions PHP nécessaires et les dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Installe Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copie les fichiers de ton projet
COPY . /var/www/html/

# Vider le cache de Composer avant d'installer les dépendances
RUN composer clear-cache

# Installe les dépendances PHP de ton projet
RUN cd /var/www/html && composer install --optimize-autoloader

# Active Apache mod_rewrite pour Symfony
RUN a2enmod rewrite

# Ajoute un script pour injecter les variables d'environnement dans Apache
RUN echo "export DATABASE_URL=${DATABASE_URL}" >> /etc/apache2/envvars

# Modifie la configuration d'Apache pour écouter sur toutes les interfaces
RUN sed -i 's/Listen 80/Listen $PORT/' /etc/apache2/ports.conf
RUN sed -i 's/80/$PORT/g' /etc/apache2/sites-available/000-default.conf

# Expose le port Apache
EXPOSE 80

# Démarre Apache
CMD ["apache2-foreground"]
