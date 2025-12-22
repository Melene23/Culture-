# Image multi-étapes pour builder puis servir l'app Laravel avec Apache

# Étape 1 : dépendances PHP via Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --no-scripts
COPY . .
# Ré-exécuter pour installer les providers après copie complète (sans scripts interactifs)
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction

# Étape 2 : build des assets front avec Node/Vite
FROM node:20 AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Étape finale : image PHP + Apache
FROM php:8.2-apache
WORKDIR /var/www/html

# Paquets système + extensions PHP nécessaires (PostgreSQL, Zip, GD)
RUN apt-get update \
  && apt-get install -y git unzip libzip-dev libpng-dev libpq-dev libonig-dev \
  && docker-php-ext-install pdo_pgsql zip gd \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Apache: activer mod_rewrite et pointer vers /public
RUN a2enmod rewrite \
  && sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
  && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copier le code applicatif
COPY . .

# Copier les dépendances et les assets buildés depuis les étapes précédentes
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Droits pour Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Exposer le port HTTP
EXPOSE 80

CMD ["bash", "-lc", "sed -i \"s/Listen 80/Listen ${PORT:-80}/\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT:-80}>/\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
