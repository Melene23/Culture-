#!/bin/bash
set -e

echo "🚀 Démarrage du build pour Render..."

# ============================================
# ÉTAPE CRITIQUE : Configuration de l'environnement
# ============================================

echo "🔧 Configuration de l'environnement..."

# Supprimer tout fichier .env existant (s'il a été commit par erreur)
if [ -f ".env" ]; then
    echo "🗑️  Suppression du .env existant..."
    rm .env
fi

# Vérifier les variables PostgreSQL
echo "📊 Vérification des variables PostgreSQL..."
echo "DB_CONNECTION=${DB_CONNECTION:-non défini}"
echo "DB_HOST=${DB_HOST:-non défini}"
echo "SESSION_DRIVER=${SESSION_DRIVER:-non défini}"

# Forcer PostgreSQL si ce n'est pas défini
if [ -z "$DB_CONNECTION" ] || [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "⚠️  DB_CONNECTION est sqlite ou non défini, forçage à pgsql..."
    export DB_CONNECTION=pgsql
fi

if [ -z "$SESSION_DRIVER" ] || [ "$SESSION_DRIVER" = "file" ]; then
    echo "⚠️  SESSION_DRIVER est file ou non défini, forçage à database..."
    export SESSION_DRIVER=database
fi

# Nettoyer TOUS les caches
echo "🧹 Nettoyage complet des caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# ============================================
# Installation des dépendances
# ============================================

echo "📦 Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installation des dépendances NPM..."
npm ci --production

echo "🔨 Construction des assets..."
npm run build

# ============================================
# Configuration Laravel
# ============================================

echo "🔑 Génération FORCÉE de la clé d'application..."
php artisan key:generate --force

echo "🗃️  Création de la migration sessions..."
php artisan session:table

echo "🗄️  Exécution des migrations (POSTGRESQL)..."
php artisan migrate --force

echo "⚡ Optimisation de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ============================================
# Vérifications
# ============================================

echo "🔍 Vérification finale..."

# Vérifier la connexion PostgreSQL
if php artisan tinker --execute="try { \$db = \DB::connection()->getPdo(); echo '✅ PostgreSQL connecté: ' . \DB::connection()->getDatabaseName(); } catch(\Exception \$e) { echo '❌ Erreur PostgreSQL: ' . \$e->getMessage(); }" 2>/dev/null; then
    echo "✅ PostgreSQL vérifié"
else
    echo "⚠️  Problème avec PostgreSQL"
fi

# Vérifier la table sessions
if php artisan tinker --execute="echo \Schema::hasTable('sessions') ? '✅ Table sessions existante' : '❌ Table sessions manquante';" 2>/dev/null; then
    echo "✅ Table sessions vérifiée"
else
    echo "⚠️  Impossible de vérifier sessions"
fi

echo "📁 Création du lien de stockage..."
php artisan storage:link

echo "✅ Build terminé avec succès!"
