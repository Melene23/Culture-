# 1. Base image PHP 8.2 avec FPM
FROM php:8.2-fpm

# 2. Installer les extensions nécessaires pour PostgreSQL
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_pgsql pgsql mbstring zip

# 3. Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Définir le répertoire de travail
WORKDIR /var/www/html

# 5. Copier tout le code du projet
COPY . .

# 6. Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Créer le fichier SQLite pour éviter l'erreur
RUN touch database/database.sqlite

# 8. Créer le fichier .env s'il n'existe pas (copier depuis .env.example si disponible, sinon créer un fichier minimal)
RUN if [ -f .env.example ]; then cp .env.example .env; else touch .env; fi

# 9. Générer la clé de l'application
RUN php artisan key:generate --force

# 10. Exposer le port 8000 pour Laravel
EXPOSE 8000

# 11. Lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
