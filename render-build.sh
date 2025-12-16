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

echo "📦 Node..."
npm ci --production
npm run build

# CONFIGURATION
echo "🔑 Clé..."
php artisan key:generate --force

echo "🗃️  Sessions..."
php artisan session:table
php artisan migrate --force

echo "⚡ Cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📁 Stockage..."
php artisan storage:link

echo "✅ Terminé !"
