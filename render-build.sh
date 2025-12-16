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

# CRÉATION DE LA TABLE SESSIONS (NOUVEAU)
echo "🗃️  Configuration des sessions..."
if [ ! -f "database/migrations/*create_sessions_table.php" ]; then
    echo "📋 Création de la migration pour la table sessions..."
    php artisan session:table
fi

# Optimiser Laravel
echo "⚡ Optimisation de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécuter les migrations (INCLUT MAINTENANT LA TABLE SESSIONS)
echo "🗄️ Exécution des migrations..."
php artisan migrate --force

# Vérifier que la table sessions existe
echo "🔍 Vérification de la table sessions..."
if php artisan tinker --execute="echo \Schema::hasTable('sessions') ? '✅ Table sessions existante' : '❌ Table sessions manquante';" 2>/dev/null; then
    echo "✅ Table sessions vérifiée"
else
    echo "⚠️  Impossible de vérifier la table sessions"
fi

# Optionnel: Exécuter les seeders (décommentez si nécessaire)
# echo "🌱 Exécution des seeders..."
# php artisan db:seed --force

# Créer le lien de stockage
echo "📁 Création du lien de stockage..."
php artisan storage:link

# Permissions (important pour Render)
echo "🔐 Configuration des permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Build terminé avec succès!"
