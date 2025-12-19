#!/bin/bash
set -e

echo "🚀 Build Render - PostgreSQL"

# NETTOYAGE
echo "🧹 Nettoyage..."
rm -f bootstrap/cache/*.php
rm -f database/database.sqlite 2>/dev/null || true

# DÉPENDANCES
echo "📦 PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

# Installer les dépendances NPM
echo "📦 Installation des dépendances NPM..."
npm ci --omit=optional

# Construire les assets
echo "🔨 Construction des assets..."
npm run build

# Exécuter les migrations
echo "�️ Exécution des migrations..."
php artisan migrate --force

# Optimiser Laravel
echo "⚡ Optimisation de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📁 Stockage..."
php artisan storage:link

echo "✅ Terminé !"
