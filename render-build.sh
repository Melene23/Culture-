#!/bin/bash
set -e

echo "🚀 Démarrage du build pour Render..."

# Installer les dépendances PHP
echo "📦 Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# Installer les dépendances NPM
echo "📦 Installation des dépendances NPM..."
npm ci --production

# Construire les assets
echo "🔨 Construction des assets..."
npm run build

# Générer la clé d'application si elle n'existe pas
if [ -z "$APP_KEY" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate --force
fi

# Optimiser Laravel
echo "⚡ Optimisation de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécuter les migrations
echo "🗄️ Exécution des migrations..."
php artisan migrate --force

# Optionnel: Exécuter les seeders (décommentez si nécessaire)
# echo "🌱 Exécution des seeders..."
# php artisan db:seed --force

echo "✅ Build terminé avec succès!"



