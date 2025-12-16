#!/bin/bash
set -e

echo "🚀 Démarrage du build pour Render..."

# ============================================
# ÉTAPE 1: NETTOYAGE COMPLET
# ============================================

echo "🧹 Nettoyage complet des caches..."
rm -f bootstrap/cache/*.php
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Supprimer tout .env existant
if [ -f ".env" ]; then
    echo "🗑️  Suppression du .env local..."
    rm .env
fi

# ============================================
# ÉTAPE 2: AFFICHER LES VARIABLES (debug)
# ============================================

echo "🔍 Variables d'environnement Render:"
echo "DB_CONNECTION=${DB_CONNECTION}"
echo "SESSION_DRIVER=${SESSION_DRIVER}"
echo "DB_HOST=${DB_HOST}"

# ============================================
# ÉTAPE 3: INSTALLATION
# ============================================

echo "📦 Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installation des dépendances NPM..."
npm ci --production

echo "🔨 Construction des assets..."
npm run build

# ============================================
# ÉTAPE 4: CONFIGURATION LARAVEL
# ============================================

echo "🔑 Génération de la clé d'application..."
php artisan key:generate --force

echo "🗃️  Préparation de la table sessions..."
# Vérifier si la migration sessions existe déjà
if ! ls database/migrations/*create_sessions_table.php 2>/dev/null; then
    echo "📋 Création de la migration sessions..."
    php artisan session:table
fi

echo "🗄️  Exécution des migrations..."
php artisan migrate --force

echo "⚡ Optimisation..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ============================================
# ÉTAPE 5: VÉRIFICATIONS
# ============================================

echo "✅ Vérifications finales..."

# Test PostgreSQL
echo "🔌 Test de connexion PostgreSQL..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Connecté à PostgreSQL: ' . DB::connection()->getDatabaseName() . PHP_EOL;
    echo '📊 Driver: ' . DB::connection()->getDriverName() . PHP_EOL;
} catch (\Exception \$e) {
    echo '❌ ERREUR PostgreSQL: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "⚠️  Tinker non disponible"

# Test sessions table
echo "📋 Vérification table sessions..."
php artisan tinker --execute="
if (Schema::hasTable('sessions')) {
    echo '✅ Table sessions existe' . PHP_EOL;
    echo '📈 Nombre de sessions: ' . DB::table('sessions')->count() . PHP_EOL;
} else {
    echo '❌ Table sessions manquante!' . PHP_EOL;
}
" 2>/dev/null || echo "⚠️  Tinker non disponible"

# ============================================
# ÉTAPE 6: FINALISATION
# ============================================

echo "📁 Création du lien de stockage..."
php artisan storage:link

echo "🔐 Configuration des permissions..."
chmod -R 775 storage bootstrap/cache

echo "🎉 Build terminé avec succès!"
