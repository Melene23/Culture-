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

# 6. Supprimer le fichier SQLite s'il existe
RUN rm -f database/database.sqlite

# 7. Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# 8. Créer un .env minimal pour Docker (sans DB_CONNECTION)
RUN echo "APP_ENV=production" > .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "LOG_CHANNEL=stderr" >> .env

# 9. Ne PAS générer la clé ici (Render le fera)
# php artisan key:generate --force

# 10. Exposer le port
EXPOSE 8000

# 11. Lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
