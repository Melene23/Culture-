# 1. Base image PHP 8.2 avec FPM
FROM php:8.2-fpm

# 2. Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip

# 3. Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Définir le répertoire de travail
WORKDIR /var/www/html

# 5. Copier tout le code du projet
COPY . .

# 6. Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Copier le fichier d'exemple .env si .env n'existe pas
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# 8. Générer la clé de l'application uniquement si APP_KEY est vide
RUN php artisan key:generate --force

# 9. Exposer le port 8000 pour Laravel
EXPOSE 8000

# 10. Lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
